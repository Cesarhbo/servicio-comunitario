<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrecioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'precio_10kg'    => 450.00, 
            'precio_18kg'    => 745.00,
            'precio_43kg'    => 1480.00,
            'fecha_vigencia' => date('Y-m-d H:i:s')
        ];

        $this->db->table('precios_gas')->insert($data);
    }
}