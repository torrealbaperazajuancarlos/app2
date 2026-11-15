<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

describe('front home', function () {
    test('renders the home page with its four sections', function () {
        $category = Category::factory()->create(['name' => 'Novela']);
        $author = Author::factory()->create([
            'first_name' => 'Gabriel',
            'last_name' => 'García Márquez',
        ]);
        $book = Book::factory()->create([
            'title' => 'Cien años de soledad',
            'category_id' => $category->id,
            'author_id' => $author->id,
        ]);

        $this->get(route('front.home'))
            ->assertOk()
            ->assertSee('Descubre tu próxima gran lectura')
            ->assertSee('Lo que dicen nuestros lectores')
            ->assertSee('Explora por categorías')
            ->assertSee('Nuestros autores')
            ->assertSee($book->title)
            ->assertSee($author->first_name)
            ->assertSee($author->last_name)
            ->assertSee($category->name);
    });

    test('renders the authors list with first and last names', function () {
        $author = Author::factory()->create([
            'first_name' => 'Isabel',
            'last_name' => 'Allende',
        ]);

        $this->get(route('front.home'))
            ->assertOk()
            ->assertSee($author->first_name)
            ->assertSee($author->last_name);
    });

    test('repeats the available books until three featured books are displayed', function () {
        $book = Book::factory()->create(['title' => 'Libro destacado']);

        $response = $this->get(route('front.home'))->assertOk();

        expect(substr_count($response->getContent(), $book->title))->toBeGreaterThanOrEqual(3);
    });

    test('renders an empty state when there are no books', function () {
        $this->get(route('front.home'))
            ->assertOk()
            ->assertSee('Aún no hay libros publicados');
    });
});
