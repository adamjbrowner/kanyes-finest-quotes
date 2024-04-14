<?php

namespace App\Http\Controllers;

use App\Services\KanyeQuotes\KanyeQuotesManager;
use Illuminate\Http\Request;

class KanyeQuoteController extends Controller 
{
    public function __invoke(Request $request)
    {
        $numQuotes = $request->input('limit', 5);
        $quotes = app(KanyeQuotesManager::class)->getQuotes($numQuotes);
        return response()->json($quotes);
    }
}
