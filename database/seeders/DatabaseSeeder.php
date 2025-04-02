<?php

namespace Database\Seeders;

use App\Models\AttributeGroups;
use App\Models\Attributes;
use App\Models\Catalog;
use App\Models\HasAttribute;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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

        Catalog::create(['catalog_name'=>'Áo']);
        Catalog::create(['catalog_name'=>'Quần']);
        Catalog::create(['catalog_name'=>'Mũ']);
        Catalog::create(['catalog_name'=>"Phụ Kiện"]);
        Product::factory()->count(80)->create();

        Order::factory()->count(20)->create();

        AttributeGroups::create(['group_name'=>'Size']);
        AttributeGroups::create(['group_name'=>'Color']);
        Attributes::create(['group_id'=>1,'attribute_name'=>'M']);
        Attributes::create(['group_id'=>1,'attribute_name'=>'X']);
        Attributes::create(['group_id'=>1,'attribute_name'=>'XL']);
        Attributes::create(['group_id'=>1,'attribute_name'=>'XXL']);

        HasAttribute::factory()->count(40)->create();
    }
}
