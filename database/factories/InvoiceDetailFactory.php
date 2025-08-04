<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceDetail>
 */
class InvoiceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $invoice = Invoice::inRandomOrder()->first();
        $product = [
            [
                'product_name' => 'Product A',
                'price' => $this->faker->randomFloat(2, 10, 100)
            ],
            [
                'product_name' => 'Product B',
                'price' => $this->faker->randomFloat(2, 10, 50)
            ],
            [
                'product_name' => 'Product C',
                'price' => $this->faker->randomFloat(2, 5, 20)
            ],
            [
                'product_name' => 'Product D',
                'price' => $this->faker->randomFloat(2, 15, 75)
            ],
            [
                'product_name' => 'Product E',
                'price' => $this->faker->randomFloat(2, 20, 150)
            ]
        ];

        $selectedProduct = $product[array_rand($product)];

        return [
            'id'=> Str::ulid()->toString(),
            'invoice_id' => $invoice->id,
            'product_name' => $selectedProduct['product_name'],
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $selectedProduct['price']
        ];
    }
}
