<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(LazilyRefreshDatabase::class);

test('it seeds exactly one user with a hashed password', function () {
    $this->seed(UserSeeder::class);

    $user = User::query()->sole();

    expect($user->name)->toBe('jctp')
        ->and($user->email)->toBe('torreal@hotmail.com')
        ->and($user->email_verified_at)->not->toBeNull()
        ->and($user->password)->not->toBe('12345678')
        ->and(Hash::check('12345678', $user->password))->toBeTrue();
});

test('it does not create duplicate users when seeded again', function () {
    $this->seed(UserSeeder::class);
    $this->seed(UserSeeder::class);

    expect(User::query()->count())->toBe(1);
});
