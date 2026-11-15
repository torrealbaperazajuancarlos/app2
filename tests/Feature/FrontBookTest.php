<?php

use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

describe('front books', function () {
    test('renders the books list page', function () {
        $book = Book::factory()->create(['title' => 'El amor en los tiempos del cólera']);

        $this->get(route('front.books.index'))
            ->assertOk()
            ->assertSee('Libros')
            ->assertSee($book->title)
            ->assertSee($book->author->first_name)
            ->assertSee(ucfirst($book->category->name));
    });

    test('filters the books list by category', function () {
        $category = Category::factory()->create(['name' => 'Poesía']);
        $included = Book::factory()->create([
            'title' => 'Veinte poemas de amor',
            'category_id' => $category->id,
        ]);
        $excluded = Book::factory()->create(['title' => 'Libro de otra categoría']);

        $this->get(route('front.books.index', ['category' => $category->id]))
            ->assertOk()
            ->assertSee($included->title)
            ->assertDontSee($excluded->title);
    });

    test('renders the book detail page', function () {
        $book = Book::factory()->create([
            'title' => 'Rayuela',
            'summary' => 'Una novela que invita a saltar entre capítulos.',
        ]);

        $this->get(route('front.books.show', $book))
            ->assertOk()
            ->assertSee($book->title)
            ->assertSee($book->summary)
            ->assertSee($book->author->first_name)
            ->assertSee($book->author->last_name)
            ->assertSee(ucfirst($book->category->name))
            ->assertSee('Leer PDF')
            ->assertSee(Storage::url($book->pdf), false);
    });

    test('renders an empty state when the selected category has no books', function () {
        $category = Category::factory()->create(['name' => 'Ensayos']);

        $this->get(route('front.books.index', ['category' => $category->id]))
            ->assertOk()
            ->assertSee('No encontramos libros en esta categoría');
    });
});
