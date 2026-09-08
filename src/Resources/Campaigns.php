<?php

namespace JeffersonGoncalves\Snov\Resources;

use JeffersonGoncalves\Snov\SnovClient;

/**
 * Drip campaign endpoints.
 */
class Campaigns
{
    public function __construct(private readonly SnovClient $client) {}

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->client->get('/get-user-campaigns');
    }

    /**
     * @return array<string, mixed>
     */
    public function emails(int|string $campaignId): array
    {
        return $this->client->get('/get-emails-from-campaign', ['id' => $campaignId]);
    }

    /**
     * @return array<string, mixed>
     */
    public function addProspect(int|string $campaignId, string $email, ?string $firstName = null, ?string $lastName = null): array
    {
        return $this->client->post('/add-prospect-to-email-campaign', array_filter([
            'campaignId' => $campaignId,
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ], fn ($value) => $value !== null));
    }
}
