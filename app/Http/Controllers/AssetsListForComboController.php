<?php

namespace App\Http\Controllers;

use App\Models\FinancialAsset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetsListForComboController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $assets = FinancialAsset::query()
            ->orderBy('asset_type')
            ->orderBy('code')
            ->get(['code', 'asset_type']);

        return response()->json($assets);
    }
}
