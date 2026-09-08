<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        Cache::flush();
        Http::preventStrayRequests();
    })
    ->in('Feature');

/**
 * Every authenticated call mints a token first, so each fake needs the OAuth
 * endpoint stubbed alongside the endpoint under test.
 */
function fakeSnov(array $fakes, int $expiresIn = 3600): void
{
    Http::fake([
        'api.snov.io/v1/oauth/access_token' => Http::response([
            'access_token' => 'fake-token',
            'expires_in' => $expiresIn,
        ], 200),
        ...$fakes,
    ]);
}
