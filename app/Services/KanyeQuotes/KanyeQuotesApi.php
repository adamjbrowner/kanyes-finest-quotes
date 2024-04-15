<?php

namespace App\Services\KanyeQuotes;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use App\Interfaces\KanyeQuotesDriver;
use Illuminate\Support\Facades\Log;

class KanyeQuotesApi implements KanyeQuotesDriver
{
    const API_URL = 'https://api.kanye.rest/';

    public function getQuotes(int $numQuotes): array
    {
        $responses = Http::retry(3, 300)->pool(function (Pool $pool) use ($numQuotes) {
            for ($i = 0; $i < $numQuotes; $i++) {
                $pool->get(self::API_URL);
            }
        });

        $quotes = collect($responses)->map(function ($response) {
            if ($response->failed()) {
                Log::error('Failed to get quote from Kanye API');
                return null;
            }
            return $response->json('quote');
        });

        return $quotes->filter()->toArray();
    }
}