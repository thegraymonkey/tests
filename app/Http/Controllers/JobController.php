<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexJobRequest;
use App\Http\Requests\StoreJobRequest;
use App\Mail\NewPublisherNotification;
use App\Services\JobService;
use App\Services\PublisherService;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function __construct(
        private JobService $jobService,
        private PublisherService $publisherService
    ) {}

    public function index(IndexJobRequest $request)
    {
        $jobOffers = $this->jobService->getPosts($request);

        $externalJobOffers = $this->jobService->getExternalPosts();

        return view('job-board.index', compact('jobOffers', 'externalJobOffers'));
    }

    public function store(StoreJobRequest $request)
    {
        $email = $request->input('email');

        $publisher = $this->publisherService->getPublisher($email);

        if (! $publisher) {
            $publisher = $this->publisherService->createPublisher($email);
            $post = $this->jobService->createPost($publisher, $request);

            Mail::to('moderator@job-bord.com')->send(new NewPublisherNotification($publisher, $post));

            return response(['message' => 'Job offer sent to moderation!'], 200);
        }

        if ($publisher->approved === 0) {
            return response(['message' => 'Job offer can\'t be created! Publisher is not approved.'], 400);
        }

        $this->jobService->createPost($publisher, $request);

        return response(['message' => 'Job offer created successfully!'], 201);
    }
}
