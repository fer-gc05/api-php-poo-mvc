<?php

use lib\Route;
use src\Controllers\HomeController;
use src\Controllers\UsersController;
use src\Controllers\TasksController;

// Rutas de autenticación
Route::get('/', [HomeController::class, 'index']); // Vista principal
Route::post('/authenticate', [HomeController::class, 'authenticate']); // Autenticar usuario
Route::post('/logout', [HomeController::class, 'logout']); // Cerrar sesión
Route::post('/store', [UsersController::class, 'store']); // Registrar usuario

// Rutas de gestión de usuarios
Route::get('/users/all', [UsersController::class, 'getAll']);  // Obtener todos los usuarios
Route::get('/user/byId', [UsersController::class, 'getById']); // Obtener usuario por ID
Route::get('/user/byEmail', [UsersController::class, 'getByEmail']); // Obtener usuario por email
Route::get('/user/byName', [UsersController::class, 'getByName']); // Obtener usuario por nombre
Route::post('/user/update', [UsersController::class, 'update']); // Actualizar usuario
Route::post('/user/delete', [UsersController::class, 'delete']); // Eliminar usuario

// Rutas de gestión de tareas
Route::get('/tasks/all', [TasksController::class, 'getAll']); // Obtener todas las tareas
Route::get('/task/byId', [TasksController::class, 'getById']); // Obtener tarea por ID
Route::get('/task/byTitle', [TasksController::class, 'getByTitle']); // Obtener tarea por título
Route::get('/task/byUser', [TasksController::class, 'getByUser']); // Obtener tarea por ID de usuario
Route::get('/task/byStatus', [TasksController::class, 'getByStatus']); // Obtener tarea por estado
Route::post('/task/store', [TasksController::class, 'store']); // Crear tarea
Route::post('/task/update', [TasksController::class, 'update']); // Actualizar tarea
Route::post('/task/delete', [TasksController::class, 'delete']); // Eliminar tarea

Route::dispatch();
