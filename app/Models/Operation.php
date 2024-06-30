<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
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
            'price' => 'float',
            'operation_amount' => 'float',
            'total_negociado' => 'float',
            'taxas' => 'float',
        ];
    }

    public function negotiationNote(): BelongsTo
    {
        return $this->belongsTo(NegotiationNote::class);
    }
}
