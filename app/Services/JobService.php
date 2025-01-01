<?php

namespace App\Services;

use App\Jobs\UpdateExternalPostsCache;
use App\Models\Post;
use App\Models\Publisher;
use Illuminate\Support\Facades\Cache;

class JobService
{
    public function __construct(
        private Post $post,

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
        $cacheKey = 'external_posts';

        $positions = Cache::get($cacheKey, []);

        UpdateExternalPostsCache::dispatch();

        return $positions;
    }
}
