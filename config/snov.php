<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Snov.io Client ID
    |--------------------------------------------------------------------------
    |
    | The API user ID from your Snov.io account. Generate the credentials at
    | https://app.snov.io/api-setting
    |
    */
    'client_id' => env('SNOV_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Snov.io Client Secret
    |--------------------------------------------------------------------------
    |
    | The API secret paired with the client ID above. Both are exchanged for a
    | short-lived OAuth access token on the first request.
    |
    */
    'client_secret' => env('SNOV_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The Snov.io REST API base URL. Override only if Snov.io gives you a
    | dedicated endpoint.
    |
    */
    'base_url' => env('SNOV_BASE_URL', 'https://api.snov.io/v1'),

    /*
    |--------------------------------------------------------------------------
    | Access Token Cache
    |--------------------------------------------------------------------------
    |
    | The OAuth access token is cached under this key so a token is not minted
    | on every request. It is stored for the lifetime the API reports, minus a
    | small safety margin.
    |
    */
    'cache_key' => env('SNOV_CACHE_KEY', 'snov.access_token'),
];
