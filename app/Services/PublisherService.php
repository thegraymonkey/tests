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
        $publisher->update(['approved' => 1]);
    }

    public function markAsSpam($id): void
    {
        $publisher = $this->publisher->findOrFail($id);
        $publisher->update(['approved' => 0]);
    }
}
