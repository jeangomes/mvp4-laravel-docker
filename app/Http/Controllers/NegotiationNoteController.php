<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNegotiationNoteAndOperationRequest;
use App\Http\Resources\FinancialAssetResource;
use App\Models\FinancialAsset;
use App\Models\NegotiationNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class NegotiationNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notes = NegotiationNote::query()->orderBy('data_pregao', 'desc')->get();
        return response()->json($notes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNegotiationNoteAndOperationRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        $negotiationNote = new NegotiationNote();
        $negotiationNote->data_pregao = $validatedData['data_pregao'];
        $negotiationNote->valor_liquido = $validatedData['valor_liquido'];
        $negotiationNote->taxa_liquidacao = $validatedData['taxa_liquidacao'];
        $negotiationNote->emolumentos = $validatedData['emolumentos'];
        $negotiationNote->total_taxa = $validatedData['taxa_liquidacao'] + $validatedData['emolumentos'];
        $negotiationNote->corretagem = $validatedData['corretagem'];
        $negotiationNote->liquido = $negotiationNote->total_taxa + $validatedData['valor_liquido'];
        $negotiationNote->total = $negotiationNote->liquido + $negotiationNote->corretagem;
        $negotiationNote->corretora = $validatedData['corretora'];

        $negotiationNote->save();

        return response()->json(['message' => 'Registro criado com sucesso!', 'data' => $negotiationNote], 201);
        //dd($financialAsset);

    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialAsset $financialAsset): FinancialAssetResource
    {
        return new FinancialAssetResource($financialAsset);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreNegotiationNoteAndOperationRequest $request, FinancialAsset $financialAsset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialAsset $financialAsset)
    {
        //
    }
}
