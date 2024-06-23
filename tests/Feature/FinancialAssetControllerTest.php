<?php

namespace Tests\Feature;

use App\Models\FinancialAsset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialAssetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_financial_asset()
    {
        $data = [
            'name' => 'Sample Asset',
            'code' => 'SAMP001',
            'is_foreigner' => false,
            'asset_type' => 'Stock',
            'stock_type' => 'ON',
            'cnpj' => '12345678000199',
            'fii_admin_name' => null,
            'fii_admin_cnpj' => null,
        ];

        $response = $this->postJson('/api/financial-assets', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Financial asset created successfully!',
                'data' => [
                    'name' => 'Sample Asset',
                    'code' => 'SAMP001',
                    // other fields as necessary
                ],
            ]);

        $this->assertDatabaseHas('financial_assets', [
            'name' => 'Sample Asset',
            'code' => 'SAMP001',
            // other fields as necessary
        ]);
    }

    public function test_requires_name_code_and_asset_type()
    {
        $response = $this->postJson('/api/financial-assets', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'code', 'asset_type']);
    }

    public function test_requires_unique_code()
    {
        $financialAsset = new FinancialAsset();

        $financialAsset->name = 'Existing Asset';
        $financialAsset->code = 'EXIST001';
        $financialAsset->is_foreigner = false;
        $financialAsset->asset_type = 'Stock';
        $financialAsset->stock_type = 'ON';
        $financialAsset->cnpj = '12345678000199';
        $financialAsset->fii_admin_name = null;
        $financialAsset->fii_admin_cnpj = null;
        $financialAsset->save();

        $data = [
            'name' => 'New Asset',
            'code' => 'EXIST001', // duplicate code
            'is_foreigner' => false,
            'asset_type' => 'Stock',
            'stock_type' => 'ON',
            'cnpj' => '12345678000199',
            'fii_admin_name' => null,
            'fii_admin_cnpj' => null,
        ];

        $response = $this->postJson('api/financial-assets', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }

    // Add more tests for other scenarios as needed
}
