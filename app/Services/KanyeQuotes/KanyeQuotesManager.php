<?php

namespace App\Services\KanyeQuotes;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Manager;

class KanyeQuotesManager extends Manager
{

    public function getDefaultDriver()
    {
        $useCache = Cache::remember('populated', config('constants.cache.ttl'), function() {
            return false;
        });

        return $useCache ? 'cache' : 'api';
    }

    public function createApiDriver()
    {
        return new KanyeQuotesApi();
    }

    public function createCacheDriver()
    {
        return new KanyeQuotesCache();
    }

}