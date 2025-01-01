<?php

namespace App\Services;

use App\Models\Publisher;

class PublisherService
{
    public function __construct(
        private Publisher $publisher
    ) {}

    public function approve($id): void
    {
        $publisher = $this->publisher->findOrFail($id);
        $publisher->update([Publisher::APPROVED => 1]);
    }

    public function markAsSpam($id): void
    {
        $publisher = $this->publisher->findOrFail($id);
        $publisher->update([Publisher::APPROVED => 0]);
    }

    public function getPublisher(string $email): ?Publisher
    {
        return $this->publisher->firstWhere('email', $email);
    }

    public function createPublisher(mixed $email)
    {
        return $this->publisher->create([
            Publisher::EMAIL => $email,
            Publisher::APPROVED => null,
        ]);
    }
}
