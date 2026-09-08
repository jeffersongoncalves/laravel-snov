<?php

namespace JeffersonGoncalves\Snov\Resources;

use JeffersonGoncalves\Snov\SnovClient;

/**
 * Technology Checker endpoint — the stack Snov.io detects on a domain.
 */
class Technology
{
    public function __construct(private readonly SnovClient $client) {}

    /**
     * @return array<string, mixed>
     */
    public function check(string $domain): array
    {
        return $this->client->post('/get-technology-checker', [
            'domain' => $domain,
        ]);
    }
}
