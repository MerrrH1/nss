<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            'name' => 'PT. Domas SawitInti Perdana',
            'phone' => '081283262822',
            'address' => 'Jl. Access Road Inalum Km. 15, Lalang, Medang Deras, Batu Bara, Sumatera Utara',
            'email' => 'silvia.wijaya@bakrieoleo.com',
            'tax_number' => '01.947.929.4-072.000',
            'account_number' => '1070013070232',
            'description' => ''
        ];
        Customer::create($customers);
    }
}
