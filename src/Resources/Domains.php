<?php

namespace JeffersonGoncalves\Snov\Resources;

use JeffersonGoncalves\Snov\SnovClient;

/**
 * Domain Search endpoints — the emails Snov.io knows for a given domain.
 */
class Domains
{
    public function __construct(private readonly SnovClient $client) {}

    /**
     * @param  string  $type  `all`, `personal` or `generic`
     * @return array<string, mixed>
     */
    public function search(string $domain, string $type = 'all', int $limit = 100, int $lastId = 0): array
    {
        return $this->client->post('/get-domain-emails-with-info', [
            'domain' => $domain,
            'type' => $type,
            'limit' => $limit,
            'lastId' => $lastId,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function count(string $domain): array
    {
        return $this->client->post('/get-domain-emails-count', [
            'domain' => $domain,
        ]);
    }
}
