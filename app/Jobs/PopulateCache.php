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
        $quotes = app(KanyeQuotesManager::class)->driver('api')->getQuotes(150);

        $cacheQuotes = Cache::remember('kanye-quotes', config('constants.cache.ttl'), function() {
            return [];
        });

        $cacheQuotes = array_unique(array_merge($cacheQuotes, $quotes));
        
        Cache::put('kanye-quotes', $cacheQuotes, config('constants.cache.ttl'));
        Cache::put('populated', true, config('constants.cache.ttl'));
    }
}
