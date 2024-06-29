<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NegotiationNote extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data_pregao' => 'date',
            'valor_liquido' => 'float',
            'taxa_liquidacao' => 'float',
            'emolumentos' => 'float',
            'total_taxa' => 'float',
            'corretagem' => 'float',
            'liquido' => 'float',
            'total' => 'float',
        ];
    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class);
    }
}
