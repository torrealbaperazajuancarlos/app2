<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
    $this->actingAs(User::factory()->create());
});

describe('categories', function () {
    test('renders the categories index page', function () {
        $category = Category::factory()->create(['name' => 'Fiction']);

        $this->get(route('categories.index'))
            ->assertOk()
            ->assertSee($category->name);
    });

    test('renders the create category page', function () {
        $this->get(route('categories.create'))
            ->assertOk()
            ->assertSee('Create category');
    });

    test('renders the edit category page', function () {
        $category = Category::factory()->create(['name' => 'Poetry']);

        $this->get(route('categories.edit', $category))
            ->assertOk()
            ->assertSee('Edit category')
            ->assertSee($category->name);
    });

    test('creates a category', function () {
        $response = $this->post(route('categories.store'), [
            'name' => 'Non-fiction',
        ]);

        $response
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Category created successfully.');

        $this->assertDatabaseHas('categories', [
            'name' => 'Non-fiction',
        ]);
    });

    test('returns validation errors when creating a category', function () {
        $this->post(route('categories.store'), [])
            ->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('categories', 0);
    });

    test('updates a category', function () {
        $category = Category::factory()->create();

        $response = $this->put(route('categories.update', $category), [
            'name' => 'Science fiction',
        ]);

        $response
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Category updated successfully.');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Science fiction',
        ]);
    });

    test('returns validation errors when updating a category', function () {
        $category = Category::factory()->create();

        $this->put(route('categories.update', $category), [
            'name' => '',
        ])->assertSessionHasErrors(['name']);
    });

    test('deletes a category', function () {
        $category = Category::factory()->create();

        $this->delete(route('categories.destroy', $category))
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'Category deleted successfully.');

        $this->assertModelMissing($category);
    });
});
