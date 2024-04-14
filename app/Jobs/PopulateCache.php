<?php

namespace App\Jobs;

use App\Services\KanyeQuotes\KanyeQuotesManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PopulateCache implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $quotes = app(KanyeQuotesManager::class)->driver('api')->getQuotes(150);
        } catch (\Exception $e) {
            Log::error('Failed to populate cache: ' . $e->getMessage());
            return;
        }

        $cacheQuotes = Cache::remember('kanye-quotes', env('CACHE_TTL'), function() {
            return [];
        });

        $cacheQuotes = array_unique(array_merge($cacheQuotes, $quotes));
        
        Cache::put('kanye-quotes', $cacheQuotes, env('CACHE_TTL'));
        Cache::put('populated', true, env('CACHE_TTL'));
    }
}
