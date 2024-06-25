<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFinancialAssetRequest;
use App\Http\Resources\FinancialAssetResource;
use App\Models\FinancialAsset;
use Illuminate\Support\Facades\Request;

class FinancialAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $assets = FinancialAsset::query()->orderBy('asset_type')->orderBy('code')->get();
        return response()->json($assets->groupBy('asset_type'));
        //return FinancialAssetResource::collection($assets->groupBy('asset_type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinancialAssetRequest $request)
    {
        $validatedData = $request->validated();
        $financialAsset = new FinancialAsset();
        $financialAsset->name = $validatedData['name'];
        $financialAsset->code = $validatedData['code'];
        $financialAsset->is_foreigner = $validatedData['is_foreigner'];
        $financialAsset->asset_type = $validatedData['asset_type'];
        $financialAsset->stock_type = $validatedData['stock_type'];
        $financialAsset->cnpj = $validatedData['cnpj'];
        $financialAsset->fii_admin_name = $validatedData['fii_admin_name'];
        $financialAsset->fii_admin_cnpj = $validatedData['fii_admin_cnpj'];
        $financialAsset->save();

        return response()->json(['message' => 'Financial asset created successfully!', 'data' => $financialAsset], 201);
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
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialAsset $financialAsset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFinancialAssetRequest $request, FinancialAsset $financialAsset)
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
