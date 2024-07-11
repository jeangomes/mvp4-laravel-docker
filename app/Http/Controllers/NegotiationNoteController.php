<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNegotiationNoteAndOperationRequest;
use App\Models\NegotiationNote;
use App\Models\Operation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class NegotiationNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $notes = NegotiationNote::query()
            ->with('operations')
            ->orderBy('data_pregao', 'desc')
            ->get();

        return response()->json($notes);
    }

    private function upsertNegotiationNote($negotiationNote, $validatedData): void
    {
        $negotiationNote->data_pregao = $validatedData['data_pregao'];
        $negotiationNote->valor_liquido = $validatedData['valor_liquido'];
        $negotiationNote->taxa_liquidacao = $validatedData['taxa_liquidacao'];
        $negotiationNote->emolumentos = $validatedData['emolumentos'];
        $negotiationNote->total_taxa = $validatedData['taxa_liquidacao'] + $validatedData['emolumentos'] + $validatedData['corretagem'];
        $negotiationNote->corretagem = $validatedData['corretagem'];
        $negotiationNote->liquido = $negotiationNote->total_taxa + $validatedData['valor_liquido'];
        $negotiationNote->total = $negotiationNote->liquido;
        $negotiationNote->corretora = $validatedData['corretora'];

        $negotiationNote->save();
    }

    private function iterateOperations($negotiationNote, $validatedData, $amountStock): void
    {
        foreach ($validatedData['operations'] as $operation) {
            $totalTaxaWithoutCorretagem = $negotiationNote->total_taxa - $negotiationNote->corretagem;
            $newOperation = new Operation();
            $newOperation->negotiation_note_id = $negotiationNote->id;
            $newOperation->operation_type = $operation['operation_type'];
            $newOperation->code = $operation['code'];
            $newOperation->quantity = $operation['quantity'];
            $newOperation->price = $operation['price'];
            $newOperation->operation_amount = $operation['quantity'] * $operation['price'];
            $taxaGeral = ($newOperation->operation_amount * $totalTaxaWithoutCorretagem) / $negotiationNote->valor_liquido;
            if ($operation['asset_type'] === 'Stock') {
                $taxaCorretagem = ($newOperation->operation_amount * $negotiationNote->corretagem) / $amountStock;
                $newOperation->taxas = $taxaGeral + $taxaCorretagem;
            } else {
                $newOperation->taxas = $taxaGeral;
            }
            $newOperation->total_negociado = $newOperation->operation_amount + $newOperation->taxas;
            $newOperation->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNegotiationNoteAndOperationRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $negotiationNote = new NegotiationNote();
        DB::transaction(function () use ($validatedData, $negotiationNote) {
            $this->upsertNegotiationNote($negotiationNote, $validatedData);
            $operations = collect($validatedData['operations']);
            $amountStock = $this->getSum($operations, 'Stock');
            //$amountFiis = $this->getSum($operations, 'FII');
            $this->iterateOperations($negotiationNote, $validatedData, $amountStock);
        });

        return response()->json(['message' => 'Registro criado com sucesso!', 'data' => $negotiationNote], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(NegotiationNote $negotiationNote): JsonResponse
    {
        $negotiationNote->load('operations.financialAsset:code,asset_type');
        $negotiationNote->operations->transform(function (Operation $operation) {
            $operation->asset_type = $operation->financialAsset->asset_type;
            $operation->unsetRelation('financialAsset');
            return $operation;
        });
        return response()->json($negotiationNote);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNegotiationNoteAndOperationRequest $request, NegotiationNote $negotiationNote): JsonResponse
    {
        $validatedData = $request->validated();
        DB::transaction(function () use ($validatedData, $negotiationNote) {
            $this->upsertNegotiationNote($negotiationNote, $validatedData);
            $operations = collect($validatedData['operations']);
            $amountStock = $this->getSum($operations, 'Stock');
            $negotiationNote->operations()->delete();
            $this->iterateOperations($negotiationNote, $validatedData, $amountStock);
        });

        return response()->json(['message' => 'Registro alterado com sucesso!', 'data' => $negotiationNote]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NegotiationNote $negotiationNote): JsonResponse
    {
        DB::transaction(function () use ($negotiationNote) {
            if ($negotiationNote->operations()->delete()) {
                $negotiationNote->delete();
            }
        });
        return response()->json();
    }

    public function getFilterOperation(Collection $operations, $type): Collection
    {
        return $operations->filter(fn ($step) => $step['asset_type'] === $type);
    }

    public function transformCollection(Collection $assets): void
    {
        $assets->transform(function ($asset) {
            $asset['operation_amount'] = $asset['quantity'] * $asset['price'];

            return $asset;
        });
    }

    public function getSum(Collection $assets, $type): mixed
    {
        $assets = $this->getFilterOperation($assets, $type);
        $this->transformCollection($assets);

        return $assets->sum('operation_amount');
    }
}
