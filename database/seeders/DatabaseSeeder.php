<?php

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'admin@admin.com', 'password' => Hash::make('12345678'),'phone_number' => '0987654321','role' => 'ADMIN']);
        User::factory()->count(20)->create();

        Catalog::create(['catalog_name'=>'ÁO']);
        Catalog::create(['catalog_name'=>'Quần']);
        Catalog::create(['catalog_name'=>'Mũ']);

        Product::factory()->count(20)->create();
    }
}
