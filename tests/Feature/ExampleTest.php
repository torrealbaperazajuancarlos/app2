<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('the home page returns a successful response', function () {
    $this->withoutVite();

    $response = $this->get('/');

    $response->assertOk();
});
