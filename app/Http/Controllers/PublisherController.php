<?php

namespace App\Http\Controllers;

use App\Services\PublisherService;

class PublisherController
{
    public function __construct(
        private PublisherService $service
    ) {}

    public function approve($id)
    {
        $this->service->approve($id);

        return redirect()->route('job.index')->with('success', 'Publisher approved successfully.');
    }

    public function markAsSpam($id)
    {
        $this->service->markAsSpam($id);

        return redirect()->route('job.index')->with('error', 'Publisher marked as spam.');
    }
}
