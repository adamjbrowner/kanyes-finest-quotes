<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class KanyeQuoteTest extends TestCase
{

    public function test_the_kanye_quotes_endpoint_returns_401_when_no_token_is_provided(): void
    {
        $response = $this->get('/kanye-quotes');
        $response->assertStatus(401);
    }

    public function test_the_kanye_quotes_endpoint_returns_requested_num_quotes(): void
    {
        Queue::fake();
        $numQuotes = [5, 10, 3, 1];

        foreach ($numQuotes as $num) {
            $response = $this->get('/kanye-quotes?limit=' . $num, ['Authorization' => 'Bearer ' . config('constants.api.token')]);
            $response->assertStatus(200);

            $content = $response->decodeResponseJson();
            $this->assertCount($num, $content);
        }
    }

    public function test_that_kanye_quotes_manager_returns_cache_driver_when_cache_is_populated(): void
    {
        Cache::shouldReceive('remember')
            ->once()
            ->with('populated', config('constants.cache.ttl'), \Closure::class)
            ->andReturn(true);

        $manager = app(\App\Services\KanyeQuotes\KanyeQuotesManager::class);
        $this->assertEquals('cache', $manager->getDefaultDriver());
    }

    public function test_that_kanye_quotes_manager_returns_api_driver_when_cache_is_not_populated(): void
    {
        Cache::shouldReceive('remember')
            ->once()
            ->with('populated', config('constants.cache.ttl'), \Closure::class)
            ->andReturn(false);

        $manager = app(\App\Services\KanyeQuotes\KanyeQuotesManager::class);
        $this->assertEquals('api', $manager->getDefaultDriver());
    }
}
