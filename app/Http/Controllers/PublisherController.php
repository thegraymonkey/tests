<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovePublisherRequest;
use App\Http\Requests\MarkPublisherAsSpamRequest;
use App\Services\PublisherService;

class PublisherController
{
    public function __construct(
        private PublisherService $service
    ) {}

    public function approve(ApprovePublisherRequest $request)
    {
        $this->service->approve($request->input('id'));

        return redirect()->route('job.index')->with('success', 'Publisher approved successfully.');
    }

    public function markAsSpam(MarkPublisherAsSpamRequest $request)
    {
        $this->service->approve($request->input('id'));

        return redirect()->route('job.index')->with('error', 'Publisher marked as spam.');
    }
}
