<?php

namespace Database\Seeders;

use App\Models\Truck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trucks = [
            // [
            //     'plate_number' => 'BL 8526 FD',
            //     'driver_name' => 'Misriadi',
            //     'notes' => '07399207000086'
            // ],
            // [
            //     'plate_number' => 'B 9848 QV',
            //     'driver_name' => 'Sandri',
            //     'notes' => '07158705000068'
            // ],
            // [
            //     'plate_number' => 'BA 8018 GU',
            //     'driver_name' => 'Rahmat',
            //     'notes' => '07278908000064'
            // ],
            // [
            //     'plate_number' => 'BK 8214 XF',
            //     'driver_name' => 'Riky',
            //     'notes' => '07140109000622'
            // ],
            [
                'plate_number' => 'BK 8892 VB',
                'driver_name' => 'Muliono',
                'notes' => '07198612000065'
            ],
            [
                'plate_number' => 'BK 8543 VB',
                'driver_name' => 'Eko',
                'notes' => '09278812000090'
            ]
        ];

        foreach ($trucks as $truck) {
            Truck::create($truck);
        }
    }
}
