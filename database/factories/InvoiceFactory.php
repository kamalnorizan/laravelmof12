<?php

namespace Database\Factories;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id'=>Uuid::uuid4(),
            'customer_name'=>$this->faker->name(),
            'customer_email'=>$this->faker->unique()->safeEmail(),
            'status'=>$this->faker->randomElement([0, 1, 2]),
            'user_id'=>rand(1, User::count()),
        ];
    }
}
