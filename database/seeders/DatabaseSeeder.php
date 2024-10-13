<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Article;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Custom;
use App\Models\Manager;
use App\Models\News;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductPrice;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(class:CategoryTypeSeeder::class);
        $this->call(class:ManagerSeeder::class);
        $this->call(class:PriceSeeder::class);
        $this->call(class:PostTypeSeeder::class);
        // Manager::factory(10)->create();
        // Session::factory(10)->create();
        // Category::factory(50)->create();
        // Product::factory(100)->create();
        // Post::factory(10)->create();
        // Manager::factory(3)->create();
        // User::factory(10)->create();
        // Cart::factory(10)->create();
        // Attribute::factory(10)->create();
        // AttributeValue::factory(50)->create();
        // Order::factory(10)->create();
        // OrderProduct::factory(10)->create();
        // ProductAttributeValue::factory(1000)->create();
        // ProductPrice::factory(300)->create();
        //Custom::factory(10)->create();
    }
}
