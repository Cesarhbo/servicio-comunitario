<?php

namespace App\Models;

use CodeIgniter\Model;

class LiderModel extends Model
{
    protected $table            = 'lideres_calle';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre_lider', 'calles_asignadas'];
}