<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LiderSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nombre_lider' => 'MARKELYS ALVARADO', 'calles_asignadas' => 'Calle 1'],
            ['nombre_lider' => 'KEILY GONZALEZ',    'calles_asignadas' => 'Calle 2'],
            ['nombre_lider' => 'SUSANA DUBEN',      'calles_asignadas' => 'Calle 3'],
            ['nombre_lider' => 'BLANCA MARIN',      'calles_asignadas' => 'Calle 4'],
            ['nombre_lider' => 'MARYORIS LUGO',     'calles_asignadas' => 'Calle 5'],
            ['nombre_lider' => 'AGUSTIN ARTEAGA',   'calles_asignadas' => 'Calle 6'],
            ['nombre_lider' => 'TANIA VENTURA',     'calles_asignadas' => 'Calle 7'],
            ['nombre_lider' => 'CAROLINA MORILLO',  'calles_asignadas' => 'Calle 8'],
            ['nombre_lider' => 'ANAIS CESPEDES',    'calles_asignadas' => 'Calle 9'],
            ['nombre_lider' => 'FRANCISCA COLINA',  'calles_asignadas' => 'Calle 10'],
            ['nombre_lider' => 'OLGA TANON',    'calles_asignadas' => 'Calle 11'],
        ];

        // Insertar todos los registros
        $this->db->table('lideres_calle')->insertBatch($data);
    }
}