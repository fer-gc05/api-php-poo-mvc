<?php

namespace src\Controllers;

use src\Models\Users;

class UsersController extends Controller
{

    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['name'], $data['email'], $data['role'], $data['password'], $data['password_confirmation'])):
                return ['error' => 'Complete todos los campos'];
            endif;

            $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            $role = filter_var($data['role'], FILTER_SANITIZE_STRING);
            $password = $data['password'];
            $password_confirmation = $data['password_confirmation'];

            if ($password !== $password_confirmation):
                return ['error' => 'Las contraseñas no coinciden'];
            endif;

            if (!$role):
                return ['error' => 'Seleccione un rol, este campo es obligatorio'];
            endif;

            if ($role !== 'administrador' && $role !== 'trabajador'):
                return ['error' => 'Rol inválido, seleccione administrador o trabajador'];
            endif;

            $user = new Users();
            $existingUser = $user->where('email', '=', $email)->fetch();
            if ($existingUser):
                return ['error' => 'El email ya se encuentra registrado'];
            endif;

            $data = [
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $user->insert($data);
            return $result ? ['message' => 'Usuario registrado correctamente', 'data' => $result] : ['error' => 'Error al registrar el usuario'];
        } catch (\Exception $e) {
            return ['error' => 'Error al registrar el usuario: ' . $e->getMessage()];
        }
    }

    public function update()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['name'], $data['email'], $data['password'], $data['password_confirmation'], $data['id'])):
                return ['error' => 'Complete todos los campos'];
            endif;

            $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
            $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            $role = filter_var($data['role'], FILTER_SANITIZE_STRING);
            $password = $data['password'];
            $password_confirmation = $data['password_confirmation'];
            $id = $data['id'];

            if (!$email):
                return ['error' => 'Email inválido'];
            endif;

            if ($role !== 'administrador' && $role !== 'trabajador'):
                return ['error' => 'Rol inválido, seleccione administrador o trabajador'];
            endif;

            if (!$password || !$password_confirmation):
                return ['error' => 'Los campos de contraseña no pueden estar vacíos'];
            endif;

            if ($password !== $password_confirmation):
                return ['error' => 'Las contraseñas no coinciden'];
            endif;

            $user = new Users();
            $existingUser = $user->where('email', '=', $email)->fetch();

            if (password_verify($password, $existingUser['password'])):
                return ['error' => 'La contraseña no puede ser igual a la anterior'];
            endif;

            if ($existingUser && $existingUser['id'] != $id):
                return ['error' => 'El email ya se encuentra registrado'];
            endif;

            $data = [
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ];

            $result = $user->update($id, $data);
            return $result ? ['message' => 'Usuario actualizado correctamente', 'data' => $result] : ['error' => 'Error al actualizar el usuario'];

        } catch (\Exception $e) {
            return ['error' => 'Error al actualizar el usuario: ' . $e->getMessage()];
        }
    }

    public function getAll()
    {
        try {
            $users = new Users();
            $users = $users->all();
            return $users ? $users : ['error' => 'No se encontraron usuarios'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener los usuarios: ' . $e->getMessage()];
        }

    }

    public function getById()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['id'])):
                return ['error' => 'Falta el ID del usuario'];
            endif;
            $id = $data['id'];
            $user = new Users();
            $user = $user->find($id);
            return $user ? $user : ['error' => 'Usuario no encontrado'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener el usuario: ' . $e->getMessage()];
        }
    }

    public function getByEmail()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['email'])):
                return ['error' => 'Falta el email del usuario'];
            endif;

            $email = $data['email'];
            $user = new Users();
            $user = $user->where('email', '=', $email)->fetch();
            return $user ? $user : ['error' => 'Usuario no encontrado'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener el usuario: ' . $e->getMessage()];
        }

    }

    public function getByName()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['name'])):
                return ['error' => 'Falta el nombre del usuario'];
            endif;

            $name = $data['name'];
            $user = new Users();
            $user = $user->like('name', $name)->fetchAll();
            return $user ? $user : ['error' => 'Usuario no encontrado'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener el usuario: ' . $e->getMessage()];
        }

    }

    public function getByRole()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['role'])):
                return ['error' => 'Falta el rol del usuario'];
            endif;

            $role = $data['role'];
            $user = new Users();
            $user = $user->where('role', '=', $role)->fetchAll();
            return $user ? $user : ['error' => 'Usuario no encontrado'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener el usuario: ' . $e->getMessage()];
        }

    }

    public function delete()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['id'])):
                return ['error' => 'Falta el ID del usuario'];
            endif;

            $id = $data['id'];

            $user = new Users();
            $userExists = $user->find($id);
            if (!$userExists):
                return ['error' => 'Usuario no encontrado'];
            endif;

            return $user->delete($id) ? ['message' => 'Usuario eliminado correctamente'] : ['error' => 'Error al eliminar el usuario'];

        } catch (\Exception $e) {
            return ['error' => 'Error al eliminar el usuario: ' . $e->getMessage()];
        }
    }

    public function createRandomPassword($length)
    {
        try {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomPassword = '';
            for ($i = 0; $i < $length; $i++) {
                $randomPassword .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomPassword;
        } catch (\Exception $e) {
            return ['error' => 'Error al generar la contraseña aleatoria: ' . $e->getMessage()];
        }
    }

    public function recoveryPasswordByEmail()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['email'])):
                return ['error' => 'Falta el email del usuario'];
            endif;

            $email = $data['email'];
            $user = new Users();
            $userExist = $user->where('email', '=', $email)->fetch();
            if (!$userExist):
                return ['error' => 'Usuario no encontrado'];
            endif;

            $randomPassword = $this->createRandomPassword(10);
            $data = [
                'password' => password_hash($randomPassword, PASSWORD_BCRYPT)
            ];

            $result = $user->update($userExist['id'], $data);
            if ($result):
                return ['message' => 'La contraseña se ha restablecido correctamente: ' . $randomPassword];
            endif;

            return ['error' => 'Error al restablecer la contraseña'];

        } catch (\Exception $e) {
            return ['error' => 'Error al restablecer la contraseña: ' . $e->getMessage()];
        }
    }
}