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
            ->select(['fa.name', 'fa.code', 'fa.asset_type', DB::raw('SUM(operations.quantity) as total_quantity'),
                DB::raw('SUM(quantity * price) / SUM(quantity) AS weighted_average_price'),
                DB::raw('(SUM(quantity * price)+taxas) / SUM(quantity) AS weighted_average_cost'),
                DB::raw('SUM(operations.operation_amount) as valor_negociado'),
                DB::raw('SUM(operations.total_negociado) as total_negociado'),
            ])
            ->groupBy('fa.name', 'operations.code')
            ->orderBy('operations.code')
            ->get();
        $results->transform(function ($result) {
            $brapiApi = new GetPriceAssetFromApi($result['code']);
            $price = $brapiApi->price;
            $result['price'] = $price;
            $result['amount'] = $price * $result['total_quantity'];
            $result['diferenca'] = $result['amount'] - $result['total_negociado'];
            $result['diferenca_percentual'] = ($result['diferenca'] / $result['total_negociado']) * 100;

            return $result;
        });

        return response()->json($results);
    }
}
