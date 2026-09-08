<?php

namespace JeffersonGoncalves\Snov\Resources;

use JeffersonGoncalves\Snov\SnovClient;

/**
 * Prospect list endpoints.
 */
class Lists
{
    public function __construct(private readonly SnovClient $client) {}

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->client->get('/get-user-lists');
    }

    /**
     * @return array<string, mixed>
     */
    public function prospects(int|string $listId, int $page = 1, int $perPage = 100): array
    {
        return $this->client->post('/prospect-list', [
            'listId' => $listId,
            'page' => $page,
            'perPage' => $perPage,
        ]);
    }
}
