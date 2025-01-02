<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexJobRequest;
use App\Http\Requests\StoreJobRequest;
use App\Mail\NewPublisherNotification;
use App\Services\JobService;
use App\Services\PublisherService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class JobController extends Controller
{
    public function __construct(
        private JobService $jobService,
        private PublisherService $publisherService
    ) {}

    public function index(IndexJobRequest $request): View
    {
        $jobOffers = $this->jobService->getPosts($request);

        $externalJobOffers = $this->jobService->getExternalPosts();

        return view('job-board.index', compact('jobOffers', 'externalJobOffers'));
    }

    public function store(StoreJobRequest $request): Response
    {
        $email = $request->input('email');

        $publisher = $this->publisherService->getPublisher($email);

        if (! $publisher) {
            $publisher = $this->publisherService->createPublisher($email);
            $post = $this->jobService->createPost($publisher, $request);

            $spamUrl = URL::temporarySignedRoute(
                'publisher.spam',
                now()->addHours(24),
                ['id' => $publisher->id]
            );

            $approveUrl = URL::temporarySignedRoute(
                'publisher.approve',
                now()->addHours(24),
                ['id' => $publisher->id]
            );

            Mail::to('moderator@job-bord.com')
                ->queue(new NewPublisherNotification($publisher, $post, $spamUrl, $approveUrl));

            return response(['message' => 'Job offer sent to moderation!'], 200);
        }

        if ($publisher->approved === 0 || $publisher->approved === null) {
            return response(['message' => 'Job offer can\'t be created! Publisher is not approved.'], 400);
        }

        $this->jobService->createPost($publisher, $request);

        return response(['message' => 'Job offer created successfully!'], 201);
    }
}
