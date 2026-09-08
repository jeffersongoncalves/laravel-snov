<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Facades\Snov;

it('lists the drip campaigns', function () {
    fakeSnov([
        'api.snov.io/v1/get-user-campaigns' => Http::response([['id' => 7]], 200),
    ]);

    expect(Snov::campaigns()->all())->toBe([['id' => 7]]);
});

it('fetches the emails of a campaign by query string', function () {
    fakeSnov([
        'api.snov.io/v1/get-emails-from-campaign*' => Http::response(['success' => true], 200),
    ]);

    Snov::campaigns()->emails(7);

    Http::assertSent(fn (Request $request) => str_contains($request->url(), 'get-emails-from-campaign?id=7'));
});

it('adds a prospect to a campaign', function () {
    fakeSnov([
        'api.snov.io/v1/add-prospect-to-email-campaign' => Http::response(['success' => true], 200),
    ]);

    Snov::campaigns()->addProspect(7, 'ada@example.com', 'Ada');

    Http::assertSent(fn (Request $request) => $request->data() === [
        'campaignId' => 7,
        'email' => 'ada@example.com',
        'firstName' => 'Ada',
    ]);
});
