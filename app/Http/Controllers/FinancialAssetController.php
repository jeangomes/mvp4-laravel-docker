<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFinancialAssetRequest;
use App\Http\Requests\UpdateFinancialAssetRequest;
use App\Http\Resources\FinancialAssetResource;
use App\Models\FinancialAsset;

class FinancialAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = FinancialAsset::all();
        return FinancialAssetResource::collection($assets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function update(UpdateFinancialAssetRequest $request, FinancialAsset $financialAsset)
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
