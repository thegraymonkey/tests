<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveOrSpamPublisherRequest;
use App\Services\PublisherService;

class PublisherController
{
    public function __construct(
        private PublisherService $service
    ) {}

    public function approve(ApproveOrSpamPublisherRequest $request)
    {
        $this->service->approve($request->input('id'));

        return redirect()->route('job.index')->with('success', 'Publisher approved successfully.');
    }

    public function markAsSpam(ApproveOrSpamPublisherRequest $request)
    {
        $this->service->markAsSpam($request->input('id'));

        return redirect()->route('job.index')->with('error', 'Publisher marked as spam.');
    }
}
