<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinancialAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:financial_assets,code',
            'is_foreigner' => 'boolean',
            'asset_type' => 'required|in:ETF,Stock,FII,Crypto,RF',
            'stock_type' => 'nullable|in:ON,PN,UNIT',
            'cnpj' => 'nullable|string|max:20',
            'fii_admin_name' => 'nullable|string|max:20',
            'fii_admin_cnpj' => 'nullable|string|max:20',
        ];
    }
}
