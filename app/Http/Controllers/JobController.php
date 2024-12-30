<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexJobRequest;
use App\Http\Requests\StoreJobRequest;
use App\Mail\NewPublisherNotification;
use App\Models\Publisher;
use App\Services\JobService;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function __construct(
        private JobService $service
    ) {}

    public function index(IndexJobRequest $request)
    {
        $jobOffers = $this->service->getPosts($request);

        $externalJobOffers = $this->service->getExternalPosts();

        return view('job-board.index', compact('jobOffers', 'externalJobOffers'));
    }

    public function store(StoreJobRequest $request)
    {
        $email = $request->input('email');

        $publisher = Publisher::where('email', $email)->first();

        if (! $publisher) {
            $publisher = Publisher::create([
                Publisher::EMAIL => $email,
                Publisher::APPROVED => null,
            ]);

            $post = $this->service->createPost($publisher, $request);

            Mail::to('moderator@job-bord.com')->send(new NewPublisherNotification($publisher, $post));

            return response(['message' => 'Job offer sent to moderation!'], 200);
        }

        if ($publisher->approved === 0) {
            return response(['message' => 'Job offer can\'t be created! Publisher is not approved.'], 400);
        }

        $this->service->createPost($publisher, $request);

        return response(['message' => 'Job offer created successfully!'], 201);
    }
}
