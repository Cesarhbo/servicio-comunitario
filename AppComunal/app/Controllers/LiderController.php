<?php

namespace App\Controllers;

use App\Models\LiderModel;

class LiderController extends BaseController
{
    // Muestra la lista de líderes para que el Frontend las pinte en una tabla
    public function index()
    {
        $model = new LiderModel();
        $data['lideres'] = $model->findAll(); //
        return view('lideres/index', $data); 
    }

    // Procesa la edición de una líder existente
    public function actualizar($id)
    {
        $model = new LiderModel();

        // Validación: El nombre es obligatorio
        $reglas = [
            'nombre_lider' => 'required|min_length[3]',
            'calles_asignadas' => 'required'
        ];

        if (!$this->validate($reglas)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors()); //
        }

        $data = [
            'nombre_lider'     => $this->request->getPost('nombre_lider'),
            'calles_asignadas' => $this->request->getPost('calles_asignadas')
        ];

        $model->update($id, $data); //
        return redirect()->to('/lideres')->with('mensaje', 'Líder actualizada con éxito');
    }

    // Por si necesitan agregar una líder nueva en el futuro
    public function guardar()
    {
        $model = new LiderModel();
        $model->insert([
            'nombre_lider'     => $this->request->getPost('nombre_lider'),
            'calles_asignadas' => $this->request->getPost('calles_asignadas')
        ]);
        return redirect()->to('/lideres')->with('mensaje', 'Nueva líder agregada');
    }
}