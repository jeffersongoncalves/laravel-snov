<?php

namespace JeffersonGoncalves\Snov;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Snov\Exceptions\SnovException;
use JeffersonGoncalves\Snov\Resources\Campaigns;
use JeffersonGoncalves\Snov\Resources\Domains;
use JeffersonGoncalves\Snov\Resources\Emails;
use JeffersonGoncalves\Snov\Resources\Lists;
use JeffersonGoncalves\Snov\Resources\Prospects;
use JeffersonGoncalves\Snov\Resources\Technology;

/**
 * Thin fluent client for the Snov.io REST API (https://api.snov.io/v1).
 * Groups endpoints behind resource accessors and authenticates every request
 * with an OAuth client-credentials token minted from `SNOV_CLIENT_ID` /
 * `SNOV_CLIENT_SECRET` and cached for the lifetime the API reports.
 */
class SnovClient
{
    public function domains(): Domains
    {
        return new Domains($this);
    }

    public function emails(): Emails
    {
        return new Emails($this);
    }

    public function prospects(): Prospects
    {
        return new Prospects($this);
    }

    public function lists(): Lists
    {
        return new Lists($this);
    }

    public function technology(): Technology
    {
        return new Technology($this);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this);
    }

    /**
     * @param  array<string, mixed>  $body
     * @return array<string, mixed>
     *
     * @throws SnovException
     */
    public function post(string $uri, array $body): array
    {
        return $this->handle($this->http()->post($uri, $body));
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     *
     * @throws SnovException
     */
    public function get(string $uri, array $query = []): array
    {
        return $this->handle($this->http()->get($uri, $query));
    }

    /**
     * Exchanges the client credentials for an access token. The token is
     * cached until shortly before it expires, so only the first call in a
     * given window pays for the round trip.
     *
     * @throws SnovException
     */
    public function accessToken(): string
    {
        $key = (string) config('snov.cache_key', 'snov.access_token');

        $token = Cache::get($key);

        if (is_string($token) && $token !== '') {
            return $token;
        }

        $response = Http::acceptJson()->post($this->baseUrl().'/oauth/access_token', [
            'grant_type' => 'client_credentials',
            'client_id' => (string) config('snov.client_id'),
            'client_secret' => (string) config('snov.client_secret'),
        ]);

        if ($response->failed()) {
            throw new SnovException($this->errorMessage($response), $response->status());
        }

        $data = $response->json();
        $token = is_array($data) ? ($data['access_token'] ?? null) : null;

        if (! is_string($token) || $token === '') {
            throw new SnovException($this->errorMessage($response), $response->status());
        }

        // Snov.io tokens live for an hour; shave 60s off so a token is never
        // used in the moments around its own expiry.
        $ttl = max(60, (int) ($data['expires_in'] ?? 3600) - 60);

        Cache::put($key, $token, $ttl);

        return $token;
    }

    /**
     * @throws SnovException
     */
    private function http(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl())
            ->withToken($this->accessToken())
            ->acceptJson();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws SnovException
     */
    private function handle(Response $response): array
    {
        if ($response->failed()) {
            throw new SnovException($this->errorMessage($response), $response->status());
        }

        $data = $response->json();

        return is_array($data) ? $data : [];
    }

    private function errorMessage(Response $response): string
    {
        $data = $response->json();

        foreach (['message', 'error_description', 'error'] as $key) {
            if (is_array($data) && is_string($data[$key] ?? null)) {
                return $data[$key];
            }
        }

        return $response->body() !== ''
            ? $response->body()
            : "Snov.io API request failed with status {$response->status()}.";
    }

    private function baseUrl(): string
    {
        return rtrim((string) config('snov.base_url', 'https://api.snov.io/v1'), '/');
    }
}
