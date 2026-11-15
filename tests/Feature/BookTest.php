<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->create());
    Storage::fake('public');
});

describe('books', function () {
    test('renders the books index page', function () {
        $book = Book::factory()->create(['title' => 'The Great Gatsby']);

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee($book->title);
    });

    test('renders the create book page', function () {
        $this->get(route('books.create'))
            ->assertOk()
            ->assertSee('Create book');
    });

    test('renders the edit book page', function () {
        $book = Book::factory()->create(['title' => 'Beloved']);

        $this->get(route('books.edit', $book))
            ->assertOk()
            ->assertSee('Edit book')
            ->assertSee($book->title);
    });

    test('creates a book', function () {
        $category = Category::factory()->create();
        $author = Author::factory()->create();

        $response = $this->post(route('books.store'), [
            'title' => 'Dune',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'summary' => 'A desert planet epic.',
            'pdf' => UploadedFile::fake()->create('dune.pdf', 100, 'application/pdf'),
            'image' => UploadedFile::fake()->image('dune.jpg'),
        ]);

        $response
            ->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Book created successfully.');

        $book = Book::query()->where('title', 'Dune')->firstOrFail();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Dune',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'summary' => 'A desert planet epic.',
        ]);

        Storage::disk('public')->assertExists($book->pdf);
        Storage::disk('public')->assertExists($book->image);
    });

    test('creates a book without a cover image', function () {
        $category = Category::factory()->create();
        $author = Author::factory()->create();

        $this->post(route('books.store'), [
            'title' => 'No cover',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'pdf' => UploadedFile::fake()->create('book.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('books.index'));

        $book = Book::query()->where('title', 'No cover')->firstOrFail();

        expect($book->image)->toBeNull();
        Storage::disk('public')->assertExists($book->pdf);
    });

    test('returns validation errors when creating a book', function () {
        $this->post(route('books.store'), [])
            ->assertSessionHasErrors(['title', 'category_id', 'author_id', 'pdf']);

        $this->assertDatabaseCount('books', 0);
    });

    test('updates a book without replacing its pdf', function () {
        $category = Category::factory()->create();
        $author = Author::factory()->create();

        $book = Book::factory()->create([
            'category_id' => $category->id,
            'author_id' => $author->id,
            'pdf' => 'books/existing.pdf',
        ]);

        Storage::disk('public')->put('books/existing.pdf', 'pdf content');

        $response = $this->put(route('books.update', $book), [
            'title' => 'Updated title',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'summary' => 'Updated summary.',
        ]);

        $response
            ->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Book updated successfully.');

        $book->refresh();

        expect($book->title)->toBe('Updated title');
        expect($book->pdf)->toBe('books/existing.pdf');

        Storage::disk('public')->assertExists('books/existing.pdf');
    });

    test('replaces the pdf when a new file is uploaded', function () {
        $category = Category::factory()->create();
        $author = Author::factory()->create();

        $book = Book::factory()->create([
            'category_id' => $category->id,
            'author_id' => $author->id,
            'pdf' => 'books/old.pdf',
        ]);

        Storage::disk('public')->put('books/old.pdf', 'old content');

        $this->put(route('books.update', $book), [
            'title' => $book->title,
            'category_id' => $category->id,
            'author_id' => $author->id,
            'pdf' => UploadedFile::fake()->create('new.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('books.index'));

        $book->refresh();

        expect($book->pdf)->not->toBe('books/old.pdf');

        Storage::disk('public')->assertMissing('books/old.pdf');
        Storage::disk('public')->assertExists($book->pdf);
    });

    test('returns validation errors when updating a book', function () {
        $book = Book::factory()->create();

        $this->put(route('books.update', $book), [
            'title' => '',
            'category_id' => null,
            'author_id' => null,
        ])->assertSessionHasErrors(['title', 'category_id', 'author_id']);
    });

    test('deletes a book and its files', function () {
        $book = Book::factory()->create([
            'pdf' => 'books/delete-me.pdf',
            'image' => 'books/delete-me.jpg',
        ]);

        Storage::disk('public')->put('books/delete-me.pdf', 'pdf content');
        Storage::disk('public')->put('books/delete-me.jpg', 'image content');

        $this->delete(route('books.destroy', $book))
            ->assertRedirect(route('books.index'))
            ->assertSessionHas('success', 'Book deleted successfully.');

        $this->assertModelMissing($book);

        Storage::disk('public')->assertMissing('books/delete-me.pdf');
        Storage::disk('public')->assertMissing('books/delete-me.jpg');
    });

    test('deletes its books when a category is deleted', function () {
        $category = Category::factory()->create();
        $book = Book::factory()->create(['category_id' => $category->id]);

        $category->delete();

        $this->assertModelMissing($book);
    });

    test('deletes its books when an author is deleted', function () {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);

        $author->delete();

        $this->assertModelMissing($book);
    });
});
