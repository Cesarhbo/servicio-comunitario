<?php

namespace App\Models;

use CodeIgniter\Model;

class CasaModel extends Model
{
    protected $table            = 'casas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['num_casa', 'num_calle', 'cant_habitantes', 'creado_en'];
    protected $useTimestamps    = false;

    // Esta es la función que corregirá el error en la línea 28 de tu controlador
    public function obtenerTotalHabitantes()
    {
        return $this->selectSum('cant_habitantes')->first();
    }
}