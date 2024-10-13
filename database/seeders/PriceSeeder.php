<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prices')->insert([
            [
                'uid' => 'asddas-asd-12-8e27-asdasd',
                'name' => 'Розинчная',
            ],
            [
                'uid' => 'adsdas1233',
                'name' => 'Оптовая',
            ]
        ]);
    }
}
