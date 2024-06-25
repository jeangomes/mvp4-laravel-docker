<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FinancialAsset>
 */
class FinancialAssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'code' => strtoupper(Str::random(6)),
            'is_foreigner' => $this->faker->boolean,
            'asset_type' => $this->faker->randomElement(['ETF', 'Stock', 'FII', 'Crypto', 'RF']),
            'stock_type' => $this->faker->randomElement(['ON', 'PN', 'UNIT']),
            'cnpj' => $this->faker->optional()->numerify('########0001##'),
            'fii_admin_name' => $this->faker->optional()->company,
            'fii_admin_cnpj' => $this->faker->optional()->numerify('########0001##'),
        ];
    }
}
