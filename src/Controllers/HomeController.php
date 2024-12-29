<?php

namespace src\Controllers;
session_start();
use src\Models\StudentsModel;
use src\Models\Users;


class HomeController extends Controller
{
    public function index()
    {
        return $this->view('index');
    }

    public function authenticate()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['email'], $data['password'])):
                return ['error' => 'Complete todos los campos'];
            endif;

            $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            $password = $data['password'];

            if (!$email):
                return ['error' => 'Email inválido'];
            endif;

            $user = new Users();
            $user = $user->where('email', '=', $email)->fetch();

            if (!$user):
                return ['success' => false, 'message' => 'Usuario no encontrado'];
            endif;

            if (!password_verify($password, $user['password'])):
                return ['success' => false, 'message' => 'Contraseña incorrecta'];
            endif;

            $_SESSION['user'] = $user;
            return ['success' => true, 'message' => 'Usuario autenticado correctamente'];
        } catch (\Exception $e) {
            return ['error' => 'Error al autenticar el usuario: ' . $e->getMessage()];
        }
    }

    public function logout()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['confirm']) || $data['confirm'] !== true):
                return ['error' => 'Confirmación para cerrar sesión no proporcionada o inválida'];
            endif;

            session_destroy();
            return ['message' => 'Sesión cerrada correctamente'];
        } catch (\Exception $e) {
            return ['error' => 'Error al cerrar sesión: ' . $e->getMessage()];
        }
    }
}