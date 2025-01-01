<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Factory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class UpdateExternalPostsCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(Factory $http): void
    {
        $cacheKey = 'external_posts';

        try {
            $response = $http
                ->retry(3, 1000)
                ->timeout(0.5)
                ->get(config('external.url'));

            if ($response->successful()) {
                $xmlContent = (string) $response->getBody();
                $xml = simplexml_load_string($xmlContent);

                $newPositions = [];
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

                    $newPositions[] = [
                        'id' => (string) $position->id,
                        'office' => (string) $position->office,
                        'name' => (string) $position->name,
                        'jobDescriptions' => $jobDescriptions,
                        'employmentType' => (string) $position->employmentType,
                        'seniority' => (string) $position->seniority,
                        'keywords' => (string) $position->keywords,
                    ];
                }

                Cache::forever($cacheKey, $newPositions);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update external posts cache: '.$e->getMessage());
        }
    }
}
