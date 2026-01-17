<?php
namespace App\Controllers;
use App\Models\UsuarioModel;

class AuthController extends BaseController {
    public function login() {
        $session = session();
        $model = new UsuarioModel();
        $email = $this->request->getPost('email');
        $pass  = $this->request->getPost('password');

        $user = $model->where('usuario', $email)->first();

        if ($user && password_verify($pass, $user['password'])) {
            $session->set([
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'isLoggedIn' => true
            ]);
            return redirect()->to('/inicio');
        }
        return redirect()->back()->with('error', 'Credenciales inválidas');
    }

    public function salir() {
        session()->destroy();
        return redirect()->to('/');
    }
}