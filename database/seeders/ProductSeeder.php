<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [

            // LOHL EASY

            [
                'sku' => 'lohl-easy-mensal',
                'title' => 'lohl easy',
                'description' => 'lohl easy mensal',
                'price' => 40.00,
            ], [
                'sku' => 'lohl-easy-anual',
                'title' => 'lohl easy',
                'description' => 'lohl easy anual a vista',
                'price' => 360.00,
            ], [
                'sku' => 'lohl-easy-anual-parcelado',
                'title' => 'lohl easy',
                'description' => 'lohl easy anual parcelado',
                'price' => 420.00,
            ],

            // LOHL INFINITY

            [
                'sku' => 'lohl-infinity-mensal',
                'title' => 'lohl infinity',
                'description' => 'lohl infinity mensal',
                'price' => 110.00,
            ], [
                'sku' => 'lohl-infinity-anual',
                'title' => 'lohl infinity',
                'description' => 'lohl infinity anual a vista',
                'price' => 1080.00,
            ], [
                'sku' => 'lohl-infinity-anual-parcelado',
                'title' => 'lohl infinity',
                'description' => 'lohl infinity anual parcelado',
                'price' => 1200.00,
            ],

            // LOHL COMMERCE

            [
                'sku' => 'lohl-commerce-mensal',
                'title' => 'lohl commerce',
                'description' => 'lohl commerce mensal',
                'price' => 375.00,
            ], [
                'sku' => 'lohl-commerce-anual',
                'title' => 'lohl commerce',
                'description' => 'lohl commerce anual a vista',
                'price' => 3600.00,
            ], [
                'sku' => 'lohl-commerce-anual-parcelado',
                'title' => 'lohl commerce',
                'description' => 'lohl commerce anual parcelado',
                'price' => 4200.00,
            ],
        ];

        foreach ($products as $newProduct)
        {
            $product = Product::where('sku', $newProduct['sku'])->first();

            if (!$product)
            {
                $this->command->info('  creating product: ' . $newProduct['description']);

                Product::create($newProduct);
            }
        }
    }
}
