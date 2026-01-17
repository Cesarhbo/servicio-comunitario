<?php

namespace App\Controllers;

use App\Models\PrecioModel;

class PrecioController extends BaseController
{
    /**
     * Guarda los nuevos precios en la base de datos.
     * Incluye validación para asegurar que sean montos numéricos.
     */
    public function establecerPrecios()
    {
        // 1. Reglas de validación: deben ser requeridos y numéricos
        $reglas = [
            'p10' => 'required|decimal',
            'p18' => 'required|decimal',
            'p43' => 'required|decimal'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new PrecioModel();
        
        $data = [
            'precio_10kg'    => $this->request->getPost('p10'),
            'precio_18kg'    => $this->request->getPost('p18'),
            'precio_43kg'    => $this->request->getPost('p43'),
            'fecha_vigencia' => date('Y-m-d H:i:s')
        ];

        if ($model->insert($data)) {
            return redirect()->to('/precios')->with('mensaje', 'Precios actualizados correctamente.');
        }
    }

    /**
     * Retorna los precios más recientes.
     * Útil para que el Frontend calcule los montos en tiempo real.
     */
    public function obtenerPreciosActuales()
    {
        $model = new PrecioModel();
        
        // Obtenemos el registro más reciente por ID
        $precios = $model->orderBy('id', 'DESC')->first();
        
        if (!$precios) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No hay precios registrados']);
        }

        // Retorna un JSON limpio
        return $this->response->setJSON($precios);
    }
}