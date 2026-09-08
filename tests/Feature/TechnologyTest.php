<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Facades\Snov;

it('checks the technology stack of a domain', function () {
    fakeSnov([
        'api.snov.io/v1/get-technology-checker' => Http::response(['success' => true], 200),
    ]);

    expect(Snov::technology()->check('example.com'))->toBe(['success' => true]);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/get-technology-checker'
        && $request['domain'] === 'example.com');
});
