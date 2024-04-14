<?php

namespace App\Services\KanyeQuotes;

use Illuminate\Support\Manager;

class KanyeQuotesManager extends Manager
{

    public function getDefaultDriver()
    {
        return 'api';
    }

    public function createApiDriver()
    {
        return new KanyeQuotesApi();
    }
}