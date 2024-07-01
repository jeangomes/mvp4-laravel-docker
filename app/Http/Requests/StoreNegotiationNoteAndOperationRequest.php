<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreNegotiationNoteAndOperationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'data_pregao' => 'required|date',
            'valor_liquido' => ['required', 'numeric', 'gt:0'],
            'taxa_liquidacao' => ['required', 'numeric'],
            'emolumentos' => ['required', 'numeric'],
            //'total_taxa' => ['required', 'numeric'],
            'corretagem' => ['required', 'numeric'],
            //'liquido' => ['required', 'numeric'],
            //'total' => ['required', 'numeric'],
            'corretora' => ['required', 'string'],

            'operations' => ['required', 'array', 'min:1'],
            'operations.*.operation_type' => ['required', 'string'],
            'operations.*.asset_type' => ['required', 'string'],
            'operations.*.code' => ['required', 'string'],
            'operations.*.quantity' => ['required', 'integer', 'min:1'],
            'operations.*.price' => ['required', 'numeric'],
        ];
    }
}
