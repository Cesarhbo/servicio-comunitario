<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PreciosGas extends Migration
{
    // app/Database/Migrations/YYYY-MM-DD-XXXXXX_PreciosGas.php
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'constraint'     => 5,
            'unsigned'       => true,
            'auto_increment' => true,
        ],
        'precio_10kg' => [
            'type'       => 'DECIMAL',
            'constraint' => '10,2',
        ],
        'precio_18kg' => [
            'type'       => 'DECIMAL',
            'constraint' => '10,2',
        ],
        'precio_43kg' => [
            'type'       => 'DECIMAL',
            'constraint' => '10,2',
        ],
        'fecha_vigencia' => [
            'type' => 'DATETIME',
        ],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('precios_gas');
}
    public function down()
    {
        $this->forge->dropTable('precios_gas');
    }
}
