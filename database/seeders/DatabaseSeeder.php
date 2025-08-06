<?php

namespace Database\Seeders;

use App\Models\InvoiceDetail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Invoice::factory(50)->create();
        // InvoiceDetail::factory(350)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // $this->call([
        //     UserUuidSeeder::class,
        // ]);

        $this->call([
            RolesPermissionsSeeder::class,
        ]);
    }
}
