<?php

namespace Database\Seeders;

use App\Models\Commodity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commodities = [
            ['name' => 'Palm Kernel'],
            ['name' => 'Palm Kernel Shell'],
            ['name' => 'Crude Palm Oil'],
            ['name' => 'Crude Palm Kernel Oil'],
        ];

        foreach ($commodities as $commodity) {
            Commodity::create($commodity);
        };
    }
}
