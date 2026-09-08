<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Facades\Snov;

it('finds a prospect by email', function () {
    fakeSnov([
        'api.snov.io/v1/get-prospect-by-email' => Http::response(['success' => true], 200),
    ]);

    expect(Snov::prospects()->find('ada@example.com'))->toBe(['success' => true]);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-prospect-by-email'
        && $request['email'] === 'ada@example.com');
});

it('adds a prospect to a list', function () {
    fakeSnov([
        'api.snov.io/v1/add-prospect-to-list' => Http::response(['success' => true], 200),
    ]);

    Snov::prospects()->addToList('ada@example.com', 'Ada', 'Lovelace', 12345);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/add-prospect-to-list'
        && $request['email'] === 'ada@example.com'
        && $request['firstName'] === 'Ada'
        && $request['lastName'] === 'Lovelace'
        && $request['listId'] === 12345);
});

it('omits the optional prospect fields that were not given', function () {
    fakeSnov([
        'api.snov.io/v1/add-prospect-to-list' => Http::response(['success' => true], 200),
    ]);

    Snov::prospects()->addToList('ada@example.com');

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/add-prospect-to-list'
        && $request->data() === ['email' => 'ada@example.com']);
});
