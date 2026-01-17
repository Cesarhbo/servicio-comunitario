<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegistroGas extends Migration
{
    // app/Database/Migrations/YYYY-MM-DD-XXXXXX_RegistrosGas.php
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'constraint'     => 5,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'descripcion_jornada' => [ // Ej: Jornada Diciembre 2024
            'type'       => 'VARCHAR',
            'constraint' => '255',
        ],
        'fecha_creacion' => [
            'type' => 'DATETIME',
        ],
        'monto_total_comunidad' => [
            'type'       => 'DECIMAL',
            'constraint' => '15,2',
            'default'    => 0.00,
        ],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('registros_gas');
}

    public function down()
    {
        $this->forge->dropTable('registros_gas');
    }
}
