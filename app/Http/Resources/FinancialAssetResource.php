<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialAssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'is_foreigner' => $this->is_foreigner,
            'asset_type' => $this->asset_type,
            'stock_type' => $this->stock_type,
            'cnpj' => $this->cnpj,
            'fii_admin_name' => $this->fii_admin_name,
            'fii_admin_cnpj' => $this->fii_admin_cnpj,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
