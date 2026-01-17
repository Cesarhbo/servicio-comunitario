<?php

namespace App\Controllers;

use App\Models\CasaModel;

class CensoController extends BaseController
{
    public function index()
    {
        $model = new CasaModel();
        
        $data['casas'] = $model->findAll();
        $resumen = $model->obtenerTotalHabitantes(); // Llama a la función SUM del modelo
        
        $data['total_personas'] = $resumen['cant_habitantes'] ?? 0;
        $data['total_casas'] = $model->countAll();

        return view('censo/index', $data);
    }

    public function guardar()
    {
        $reglas = [
            'num_casa'        => 'required|min_length[1]',
            'num_calle'       => 'required',
            'cant_habitantes' => 'required|is_natural_no_zero'
        ];

        
        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        
        $model = new CasaModel();
        
        $data = [
            'num_casa'        => $this->request->getPost('num_casa'),
            'num_calle'       => $this->request->getPost('num_calle'),
            'cant_habitantes' => $this->request->getPost('cant_habitantes'),
            'creado_en'       => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        
        return redirect()->to('/censo')->with('mensaje', 'Registro guardado exitosamente.');
    }

    public function obtenerEstadisticas()
    {
        $model = new CasaModel();
        
        $totalCasas = $model->countAll();
        $totalPersonas = $model->obtenerTotalHabitantes();

        return "Total de Casas: $totalCasas | Densidad Poblacional: " . ($totalPersonas['cant_habitantes'] ?? 0) . " personas.";
    }
}