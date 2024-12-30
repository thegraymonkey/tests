<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Publisher;
use Illuminate\Http\Client\Factory;

class JobService
{
    public function __construct(
        private Post $post,
        private Factory $http
    ) {}

    public function getPosts($request)
    {
        $query = $this->post->whereHas('publisher', function ($q) {
            $q->where(Publisher::APPROVED, 1);
        });

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where(Post::TITLE, 'like', '%'.$search.'%')
                    ->orWhere(Post::DESCRIPTION, 'like', '%'.$search.'%');
            });
        }

        return $query->with('publisher')->latest()->paginate(10);
    }

    public function createPost($publisher, $request)
    {
        return $this->post->create([
            Post::TITLE => $request->input('title'),
            Post::DESCRIPTION => $request->input('description'),
            Post::PUBLISHER_ID => $publisher->id,
        ]);
    }

    public function getExternalPosts(): array
    {
        $positions = [];

        try {
            $response = $this->http->get('https://mrge-group-gmbh.jobs.personio.de/xml');
        } catch (\Exception $e) {
            return $positions;
        }

        $xmlContent = (string) $response->getBody();

        $xml = simplexml_load_string($xmlContent);

        foreach ($xml->position as $position) {
            $jobDescriptions = [];
            if (! empty($position->jobDescriptions)) {
                foreach ($position->jobDescriptions->jobDescription as $jobDescription) {
                    $jobDescriptions[] = [
                        'name' => (string) $jobDescription->name,
                        'value' => (string) $jobDescription->value,
                    ];
                }
            }

            $positions[] = [
                'id' => (string) $position->id,
                'office' => (string) $position->office,
                'name' => (string) $position->name,
                'jobDescriptions' => $jobDescriptions,
                'employmentType' => (string) $position->employmentType,
                'seniority' => (string) $position->seniority,
                'keywords' => (string) $position->keywords,
            ];
        }

        return $positions;
    }
}
