<?php

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->create());
});

describe('authors', function () {
    test('renders the authors index page', function () {
        $author = Author::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Austen',
        ]);

        $this->get(route('authors.index'))
            ->assertOk()
            ->assertSee($author->first_name)
            ->assertSee($author->last_name);
    });

    test('renders the create author page', function () {
        $this->get(route('authors.create'))
            ->assertOk()
            ->assertSee('Create author');
    });

    test('renders the edit author page', function () {
        $author = Author::factory()->create([
            'first_name' => 'Mary',
            'last_name' => 'Shelley',
        ]);

        $this->get(route('authors.edit', $author))
            ->assertOk()
            ->assertSee('Edit author')
            ->assertSee($author->first_name)
            ->assertSee($author->last_name);
    });

    test('creates an author', function () {
        $response = $this->post(route('authors.store'), [
            'first_name' => 'George',
            'last_name' => 'Orwell',
            'phrase' => 'A writer of clear prose.',
        ]);

        $response
            ->assertRedirect(route('authors.index'))
            ->assertSessionHas('success', 'Author created successfully.');

        $this->assertDatabaseHas('authors', [
            'first_name' => 'George',
            'last_name' => 'Orwell',
            'phrase' => 'A writer of clear prose.',
        ]);
    });

    test('creates an author without a phrase', function () {
        $this->post(route('authors.store'), [
            'first_name' => 'Virginia',
            'last_name' => 'Woolf',
        ])->assertRedirect(route('authors.index'));

        $this->assertDatabaseHas('authors', [
            'first_name' => 'Virginia',
            'last_name' => 'Woolf',
            'phrase' => null,
        ]);
    });

    test('returns validation errors when creating an author', function () {
        $this->post(route('authors.store'), [])
            ->assertSessionHasErrors(['first_name', 'last_name']);

        $this->assertDatabaseCount('authors', 0);
    });

    test('updates an author', function () {
        $author = Author::factory()->create();

        $response = $this->put(route('authors.update', $author), [
            'first_name' => 'Toni',
            'last_name' => 'Morrison',
            'phrase' => 'A Nobel laureate.',
        ]);

        $response
            ->assertRedirect(route('authors.index'))
            ->assertSessionHas('success', 'Author updated successfully.');

        $this->assertDatabaseHas('authors', [
            'id' => $author->id,
            'first_name' => 'Toni',
            'last_name' => 'Morrison',
            'phrase' => 'A Nobel laureate.',
        ]);
    });

    test('returns validation errors when updating an author', function () {
        $author = Author::factory()->create();

        $this->put(route('authors.update', $author), [
            'first_name' => '',
            'last_name' => '',
        ])->assertSessionHasErrors(['first_name', 'last_name']);
    });

    test('deletes an author', function () {
        $author = Author::factory()->create();

        $this->delete(route('authors.destroy', $author))
            ->assertRedirect(route('authors.index'))
            ->assertSessionHas('success', 'Author deleted successfully.');

        $this->assertModelMissing($author);
    });
});
