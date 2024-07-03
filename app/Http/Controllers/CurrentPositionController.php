<?php

namespace App\Http\Controllers;

use App\GetPriceAssetFromApi;
use App\Models\Operation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrentPositionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $results = Operation::query()->join('financial_assets as fa', 'operations.code', '=', 'fa.code')
            ->select('fa.name', 'fa.code', DB::raw('SUM(operations.quantity) as total_quantity'))
            ->groupBy('fa.name', 'operations.code')
            ->orderBy('operations.code')
            ->get();
        $results->transform(function ($result) {
            $brapiApi = new GetPriceAssetFromApi($result['code']);
            $price = $brapiApi->price;
            $result['price'] = $price;
            $result['amount'] = $price * $result['total_quantity'];
            return $result;
        });

        return response()->json($results);
    }
}
