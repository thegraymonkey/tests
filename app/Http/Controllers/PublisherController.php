<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovePublisherRequest;
use App\Http\Requests\MarkPublisherAsSpamRequest;
use App\Services\PublisherService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PublisherController
{
    public function __construct(
        private PublisherService $service
    ) {}

    public function approve(ApprovePublisherRequest $request)
    {
        if ($request->input('moderator_key' === config('app.moderator_key'))) {
            $this->service->approve($request->input('id'));
            return redirect()->route('job.index')->with('success', 'Publisher approved successfully.');
        }

        return response(['message' => 'Unauthorized!'], 403);
    }

    public function markAsSpam(MarkPublisherAsSpamRequest $request)
    {
        if ($request->input('moderator_key' === config('app.moderator_key'))) {
            $this->service->approve($request->input('id'));
            return redirect()->route('job.index')->with('error', 'Publisher marked as spam.');
        }

        return response(['message' => 'Unauthorized!'], 403);
    }
}
