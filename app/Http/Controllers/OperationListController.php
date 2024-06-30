<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $sum = DB::raw('SUM(op.quantity) OVER (PARTITION BY op.code ORDER BY nn.data_pregao, op.id) AS qtd_total');
        $operations = Operation::query()->from('operations as op')
            ->with('negotiationNote')
            ->join('negotiation_notes as nn', 'op.negotiation_note_id', '=', 'nn.id')
            ->orderBy('nn.data_pregao')
            ->orderBy('op.id')
            ->get(['op.*', $sum]);

        return response()->json($operations);
    }
}
