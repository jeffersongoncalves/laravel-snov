<?php

namespace JeffersonGoncalves\Snov\Resources;

use JeffersonGoncalves\Snov\SnovClient;

/**
 * Prospect endpoints — look a prospect up by email, or push one into a list.
 */
class Prospects
{
    public function __construct(private readonly SnovClient $client) {}

    /**
     * @return array<string, mixed>
     */
    public function find(string $email): array
    {
        return $this->client->post('/get-prospect-by-email', [
            'email' => $email,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function addToList(string $email, ?string $firstName = null, ?string $lastName = null, int|string|null $listId = null): array
    {
        return $this->client->post('/add-prospect-to-list', array_filter([
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'listId' => $listId,
        ], fn ($value) => $value !== null));
    }
}
