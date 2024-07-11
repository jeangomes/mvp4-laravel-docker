<?php

namespace App;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetPriceAssetFromApi
{
    public float $price;

    /**
     * Create a new class instance.
     */
    public function __construct($code)
    {
        $seconds = 3600 * 24;
        $this->price = Cache::remember('assetPrice'.$code, $seconds, function () use ($code) {
            $token = config('app.brapi_api_token');
            $response = Http::get('https://brapi.dev/api/quote/'.$code.'?token='.$token);
            $result = json_decode($response->body(), true);
            return $result['results'][0]['regularMarketPrice'] ?? 0;
        });
    }
}
