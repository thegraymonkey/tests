<?php

namespace App\Http\Controllers;

use App\Services\PublisherService;

class PublisherController
{
    public function __construct(
        private PublisherService $service
    ) {}

    public function approve($id, $moderator_key)
    {
        if ($moderator_key === config('app.moderator_key')) {
            $this->service->approve($id);

            return redirect()->route('job.index')->with('success', 'Publisher approved successfully.');
        }

        return response(['message' => 'Unauthorized!'], 403);
    }

    public function markAsSpam($id, $moderator_key)
    {
        if ($moderator_key === config('app.moderator_key')) {
            $this->service->markAsSpam($id);

            return redirect()->route('job.index')->with('error', 'Publisher marked as spam.');
        }

        return response(['message' => 'Unauthorized!'], 403);
    }
}
