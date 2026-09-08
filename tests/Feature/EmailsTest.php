<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Facades\Snov;

it('finds an email from a name and a domain', function () {
    fakeSnov([
        'api.snov.io/v1/get-emails-from-names' => Http::response(['success' => true], 200),
    ]);

    expect(Snov::emails()->find('Ada', 'Lovelace', 'example.com'))->toBe(['success' => true]);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-emails-from-names'
        && $request['firstName'] === 'Ada'
        && $request['lastName'] === 'Lovelace'
        && $request['domain'] === 'example.com');
});

it('wraps a single email in an array when verifying', function () {
    fakeSnov([
        'api.snov.io/v1/get-emails-verification-status' => Http::response(['success' => true], 200),
    ]);

    Snov::emails()->verify('ada@example.com');

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-emails-verification-status'
        && $request['emails'] === ['ada@example.com']);
});

it('verifies a list of emails', function () {
    fakeSnov([
        'api.snov.io/v1/get-emails-verification-status' => Http::response(['success' => true], 200),
    ]);

    Snov::emails()->verify(['ada@example.com', 'grace@example.com']);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-emails-verification-status'
        && $request['emails'] === ['ada@example.com', 'grace@example.com']);
});
