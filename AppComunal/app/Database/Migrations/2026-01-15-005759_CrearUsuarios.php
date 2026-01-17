<?php
// app/Database/Migrations/[fecha]_CrearUsuarios.php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class CrearUsuarios extends Migration {
    public function up() {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'auto_increment' => true],
            'nombre'      => ['type' => 'VARCHAR', 'constraint' => '100'],
            'usuario'     => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true], // Aquí irá el Gmail
            'password'    => ['type' => 'VARCHAR', 'constraint' => '255'],
            'creado_en'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('usuarios');
    }
    public function down() { $this->forge->dropTable('usuarios'); }
}