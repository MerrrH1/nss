<?php

namespace Database\Seeders;

use App\Models\Buyer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buyers = [
            [
                'name' => 'PT. Bakrie Food And Energy',
                'address' => 'Jl. Access Road Inalum Km. 15, Lalang, Medang Deras, Batu Bara, Sumatera Utara',
                'phone' => '081283262822',
                'contact_person' => '081283262822',
                'email' => 'silvia.wijaya@bakrieoleo.com',
                'npwp' => '02.189.870.5-072.000'
            ],
            [
                'name' => 'PT. Domas SawitInti Perdana',
                'address' => 'Jl. Access Road Inalum Km. 15, Lalang, Medang Deras, Batu Bara, Sumatera Utara',
                'phone' => '081283262822',
                'contact_person' => '081283262822',
                'email' => 'silvia.wijaya@bakrieoleo.com',
                'npwp' => '01.947.929.4-072.000'
            ]
        ];
        foreach($buyers as $buyer) {
            Buyer::create($buyer);
        };
    }
}
