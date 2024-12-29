<?php

namespace src\Controllers;

use src\Models\Task;

class TasksController extends Controller
{
    function getAll()
    {
        try {
            $task = new Task();
            $result = $task->getAllTasks();
            return $result ? $result : ['error' => 'No se encontraron tareas'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener las teras' . $e->getMessage()];
        }
    }

    function getById()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['id'])):
                return ['error' => 'Falta el ID de la tarea'];
            endif;
            $id = $data['id'];
            $task = new Task();
            $result = $task->getById($id);
            return $result ? $result : ['error' => 'Tarea no encontrada'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener la tarea: ' . $e->getMessage()];
        }
    }

    public function getByTitle()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['title'])):
                return ['error' => 'Falta el título de la tarea'];
            endif;

            $title = $data['title'];

            $task = new Task();
            $result = $task->getByTitle($title);
            return $result ? $result : ['error' => 'Tarea no encontrada'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener la tarea: ' . $e->getMessage()];
        }
    }

    public function getByUser()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['user'])):
                return ['error' => 'Falta el nombre del usuario'];
            endif;

            $user = $data['user'];
            $task = new Task();
            $result = $task->getByUser($user);
            return $result ? $result : ['error' => 'Tarea no encontrada'];

        } catch (\Exception $e) {
            return ['error' => 'Error al obtener la tarea: ' . $e->getMessage()];
        }

    }

    public function getByStatus()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['status'])):
                return ['error' => 'Falta el estado de la tarea'];
            endif;

            $status = $data['status'];

            if ($status != 'pendiente' && $status != 'completada'):
                return ['error' => 'Estado de tarea no válido', 'status' => $status, 'expected' => 'pendiente o completada'];
            endif;

            $task = new Task();
            $result = $task->getByStatus($status);
            return $result ? ['data' => $result] : ['error' => 'Tarea no encontrada'];
        } catch (\Exception $e) {
            return ['error' => 'Error al obtener la tarea: ' . $e->getMessage()];
        }

    }

    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['title']) || !isset($data['description']) || !isset($data['status']) || !isset($data['deadline']) || !isset($data['user_id'])):
                return ['error' => 'Faltan datos de la tarea'];
            endif;

            $title = $data['title'];
            $description = $data['description'];
            $status = $data['status'];
            $deadline = $data['deadline'];
            $user_id = $data['user_id'];

            $task = new Task();

            $data = [
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'deadline' => $deadline,
                'user_id' => $user_id
            ];
            $result = $task->insert($data);
            return $result ? ['message' => 'Tarea creada correctamente', 'data' => $result] : ['error' => 'Error al crear la tarea'];
        } catch (\Exception $e) {
            return ['error' => 'Error al crear la tarea: ' . $e->getMessage()];
        }
    }

    public function update()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['id']) || !isset($data['title']) || !isset($data['description']) || !isset($data['status']) || !isset($data['deadline']) || !isset($data['user_id'])):
                return ['error' => 'Faltan datos de la tarea'];
            endif;

            $id = $data['id'];
            $title = $data['title'];
            $description = $data['description'];
            $status = $data['status'];
            $deadline = $data['deadline'];
            $user_id = $data['user_id'];

            $task = new Task();

            $data = [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'deadline' => $deadline,
                'user_id' => $user_id
            ];
            $result = $task->update($data, $id);
            return $result ? ['message' => 'Tarea actualizada correctamente', 'data' => $result] : ['error' => 'Error al actualizar la tarea'];
        } catch (\Exception $e) {
            return ['error' => 'Error al actualizar la tarea: ' . $e->getMessage()];
        }
    }

    public function delete()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!$data || !isset($data['id'])):
                return ['error' => 'Falta el ID de la tarea'];
            endif;

            $id = $data['id'];
            $task = new Task();
            if (!$task->find($id)):
                return ['error' => 'Tarea no encontrada'];
            endif;

            $result = $task->delete($id);
            return $result ? ['message' => 'Tarea eliminada correctamente'] : ['error' => 'Error al eliminar la tarea'];
        } catch (\Exception $e) {
            return ['error' => 'Error al eliminar la tarea: ' . $e->getMessage()];
        }
    }
}