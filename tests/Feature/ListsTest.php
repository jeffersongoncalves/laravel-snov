<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Facades\Snov;

it('lists the user prospect lists', function () {
    fakeSnov([
        'api.snov.io/v1/get-user-lists' => Http::response([['id' => 1, 'name' => 'Leads']], 200),
    ]);

    expect(Snov::lists()->all())->toBe([['id' => 1, 'name' => 'Leads']]);
});

it('paginates the prospects of a list', function () {
    fakeSnov([
        'api.snov.io/v1/prospect-list' => Http::response(['success' => true], 200),
    ]);

    Snov::lists()->prospects(1, page: 2, perPage: 50);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.snov.io/v1/prospect-list'
        && $request['listId'] === 1
        && $request['page'] === 2
        && $request['perPage'] === 50);
});
