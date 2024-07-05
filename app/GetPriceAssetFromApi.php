<?php

namespace App;

use Illuminate\Support\Facades\Http;

class GetPriceAssetFromApi
{
    public float $price;

    /**
     * Create a new class instance.
     */
    public function __construct($code)
    {
        $token = config('app.brapi_api_token');
        $response = Http::get('https://brapi.dev/api/quote/'.$code.'?token='.$token);
        $result = json_decode($response->body(), true);
        $this->price = $result['results'][0]['regularMarketPrice'] ?? 0;
    }
}
