<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('managers')->insert([
            [
                'id' => '1',
                'name' => 'Отдельный',
                'mail' => '1111111@internet.ru',
                'phone' => '11111111',
                'telegram_id' => '11111111',
                'display' => '0',
                'active' => '0',
                'is_admin' => '0'
            ],
            [
                'id' => '2',
                'name' => 'Тестовый',
                'mail' => '111111111@internet.ru',
                'phone' => '11111111',
                'telegram_id' => '1111111111',
                'display' => '1',
                'active' => '1',
                'is_admin' => '0'
            ]
        ]);
    }
}
