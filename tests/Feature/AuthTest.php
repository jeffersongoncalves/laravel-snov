<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Exceptions\SnovException;
use JeffersonGoncalves\Snov\Facades\Snov;

it('exchanges the client credentials for an access token', function () {
    fakeSnov([
        'api.snov.io/v1/get-user-lists' => Http::response(['success' => true], 200),
    ]);

    Snov::lists()->all();

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/oauth/access_token'
        && $request['grant_type'] === 'client_credentials'
        && $request['client_id'] === 'fake-client-id'
        && $request['client_secret'] === 'fake-client-secret');

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-user-lists'
        && $request->hasHeader('Authorization', 'Bearer fake-token'));
});

it('caches the access token across calls', function () {
    fakeSnov([
        'api.snov.io/v1/get-user-lists' => Http::response(['success' => true], 200),
    ]);

    Snov::lists()->all();
    Snov::lists()->all();

    Http::assertSentCount(3); // one token + two list calls
});

it('throws a SnovException when the credentials are rejected', function () {
    Http::fake([
        'api.snov.io/v1/oauth/access_token' => Http::response(['message' => 'Invalid client credentials'], 401),
    ]);

    expect(fn () => Snov::lists()->all())
        ->toThrow(SnovException::class, 'Invalid client credentials');
});

it('throws a SnovException when the token response has no token', function () {
    Http::fake([
        'api.snov.io/v1/oauth/access_token' => Http::response(['error' => 'unsupported_grant_type'], 200),
    ]);

    expect(fn () => Snov::lists()->all())
        ->toThrow(SnovException::class, 'unsupported_grant_type');
});
