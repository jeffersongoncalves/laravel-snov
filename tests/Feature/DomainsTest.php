<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Exceptions\SnovException;
use JeffersonGoncalves\Snov\Facades\Snov;

it('searches the emails of a domain', function () {
    fakeSnov([
        'api.snov.io/v1/get-domain-emails-with-info' => Http::response(['success' => true, 'emails' => []], 200),
    ]);

    expect(Snov::domains()->search('example.com'))->toBe(['success' => true, 'emails' => []]);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-domain-emails-with-info'
        && $request['domain'] === 'example.com'
        && $request['type'] === 'all'
        && $request['limit'] === 100
        && $request['lastId'] === 0);
});

it('counts the emails of a domain', function () {
    fakeSnov([
        'api.snov.io/v1/get-domain-emails-count' => Http::response(['result' => 42], 200),
    ]);

    expect(Snov::domains()->count('example.com'))->toBe(['result' => 42]);
});

it('throws a SnovException on a non-2xx response', function () {
    fakeSnov([
        'api.snov.io/v1/get-domain-emails-count' => Http::response(['message' => 'Not enough credits'], 402),
    ]);

    expect(fn () => Snov::domains()->count('example.com'))
        ->toThrow(SnovException::class, 'Not enough credits');
});
