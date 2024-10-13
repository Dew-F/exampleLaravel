<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_types')->insert([
            [
                'id' => '1',
                'name' => 'Продукты',
            ],
            [
                'id' => '2',
                'name' => 'Услуги',
            ],
            [
                'id' => '3',
                'name' => 'Кастом',
            ],
        ]);
    }
}
