<?php

namespace App\Services\KanyeQuotes;

use App\Interfaces\KanyeQuotesDriver;
use Illuminate\Support\Facades\Cache;

class KanyeQuotesCache implements KanyeQuotesDriver
{ 
    public function getQuotes(int $numQuotes): array
    {
        $quotes = Cache::remember('kanye-quotes', env('CACHE_TTL'), function() {
            return [];
        });

        $randomKeys = array_rand($quotes, $numQuotes);
        $randomQuotes = [];

        foreach ($randomKeys as $key) {
            $randomQuotes[] = $quotes[$key];
        }

        return $randomQuotes;
    }
}