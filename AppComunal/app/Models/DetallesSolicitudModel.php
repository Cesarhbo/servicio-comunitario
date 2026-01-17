<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleSolicitudModel extends Model
{
    protected $table            = 'detalles_solicitud';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_registro', 
        'id_lider', 
        'cant_10kg', 
        'cant_18kg', 
        'cant_43kg', 
        'subtotal_pago'
    ];

    /**
     * Esta función obtendrá los datos unidos (JOIN) para armar 
     * exactamente la tabla que tienes en la foto.
     */
    public function obtenerConsolidado($idRegistro)
    {
        return $this->select('detalles_solicitud.*, lideres_calle.nombre_lider, lideres_calle.calles_asignadas')
                    ->join('lideres_calle', 'lideres_calle.id = detalles_solicitud.id_lider')
                    ->where('id_registro', $idRegistro)
                    ->findAll();
    }
}