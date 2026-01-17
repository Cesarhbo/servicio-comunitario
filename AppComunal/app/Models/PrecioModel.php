<?php

namespace App\Models;

use CodeIgniter\Model;

class PrecioModel extends Model
{
    protected $table            = 'precios_gas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['precio_10kg', 'precio_18kg', 'precio_43kg', 'fecha_vigencia'];
    protected $useTimestamps    = false;
}