<?php

namespace Database\Seeders;

use App\Models\services;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        services::create([
            'name' => 'Itunes',
            'image' => '',
        ]);

        services::create([
            'name' => 'Apple',
            'image' => '',
        ]);

        services::create([
            'name' => 'Steam',
            'image' => '',
        ]);

        services::create([
            'name' => 'Ebay',
            'image' => '',
        ]);
    }
}
