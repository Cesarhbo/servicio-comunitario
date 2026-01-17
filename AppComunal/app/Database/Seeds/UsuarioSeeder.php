<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder {
    public function run() {
        $this->db->table('usuarios')->truncate();
        $data = [
            'nombre'    => 'Maritza Morillo',
            'usuario'   => 'maritzamorillo@gmail.com', // hay que cambiar esto
            'password'  => password_hash('TuClaveSegura', PASSWORD_DEFAULT), // tbm hay que cambiar esto
            'creado_en' => date('Y-m-d H:i:s')
        ];
        $this->db->table('usuarios')->insert($data);
    }
}