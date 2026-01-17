<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetallesSolicitud extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_registro' => [ 
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'id_lider' => [ 
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'cant_10kg'     => [ 'type' => 'INT', 'constraint' => 5, 'default' => 0 ],
            'cant_18kg'     => [ 'type' => 'INT', 'constraint' => 5, 'default' => 0 ],
            'cant_43kg'     => [ 'type' => 'INT', 'constraint' => 5, 'default' => 0 ],
            'subtotal_pago' => [ 
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Relaciones: Esto asegura que no puedas borrar un registro si tiene detalles, 
        // o que se borren los detalles si borras el registro principal (CASCADE).
        $this->forge->addForeignKey('id_registro', 'registros_gas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_lider', 'lideres_calle', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('detalles_solicitud');
    }

    public function down()
    {
        // Esto permite que si quieres "limpiar" la base de datos, 
        // CodeIgniter sepa cómo borrar esta tabla.
        $this->forge->dropTable('detalles_solicitud');
    }
}