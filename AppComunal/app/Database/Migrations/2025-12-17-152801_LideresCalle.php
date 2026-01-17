<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LideresCalle extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre_lider' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'calles_asignadas' => [
                'type' => 'TEXT', // Permite escribir varias calles o una descripción larga
            ],
        ]);

        $this->forge->addKey('id', true); // Define ID como Clave Primaria
        $this->forge->createTable('lideres_calle'); // Crea la tabla con nombre en snake_case
    }

    public function down()
    {
        // Esto permite deshacer la migración si es necesario
        $this->forge->dropTable('lideres_calle');
    }
}