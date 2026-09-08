<?php

namespace JeffersonGoncalves\Snov\Resources;

use JeffersonGoncalves\Snov\SnovClient;

/**
 * Email Finder and Email Verifier endpoints.
 */
class Emails
{
    public function __construct(private readonly SnovClient $client) {}

    /**
     * @return array<string, mixed>
     */
    public function find(string $firstName, string $lastName, string $domain): array
    {
        return $this->client->post('/get-emails-from-names', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'domain' => $domain,
        ]);
    }

    /**
     * @param  array<int, string>|string  $emails
     * @return array<string, mixed>
     */
    public function verify(array|string $emails): array
    {
        return $this->client->post('/get-emails-verification-status', [
            'emails' => is_string($emails) ? [$emails] : array_values($emails),
        ]);
    }
}
