<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistroGasModel extends Model
{
    protected $table            = 'registros_gas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['descripcion_jornada', 'fecha_creacion', 'monto_total_comunidad'];
    protected $returnType       = 'array';
}