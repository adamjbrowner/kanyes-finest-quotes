<?php

namespace App\Interfaces;

interface KanyeQuotesDriver
{
    public function getQuotes(int $numQuotes): array;
}