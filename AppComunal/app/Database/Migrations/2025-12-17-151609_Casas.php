<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Casas extends Migration
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
            'num_casa' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'num_calle' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'cant_habitantes' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'creado_en' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('casas');
    }

    public function down()
    {
        $this->forge->dropTable('casas');
    }
}