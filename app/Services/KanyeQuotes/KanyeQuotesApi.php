<?php

namespace App\Services\KanyeQuotes;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;
use App\Interfaces\KanyeQuotesDriver;

class KanyeQuotesApi implements KanyeQuotesDriver
{
    const API_URL = 'https://api.kanye.rest/';

    public function getQuotes(int $numQuotes): array
    {
        $responses = Http::pool(function (Pool $pool) use ($numQuotes) {
            for ($i = 0; $i < $numQuotes; $i++) {
                $pool->get(self::API_URL);
            }
        });

        $quotes = collect($responses)->map(function ($response) {
            return $response->json('quote');
        });

        return $quotes->toArray();
    }
}