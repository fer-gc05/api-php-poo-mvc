# API PHP POO MVC

Una API REST escalable construida con PHP, implementando Programación Orientada a Objetos (POO) y el patrón de arquitectura Modelo-Vista-Controlador (MVC). Esta API proporciona endpoints para gestión de usuarios y tareas, a esta le puedes implementar el manejo de sesiones y hacer uso preciso de la capacidad de autentificacion.

## 🚀 Características

- Arquitectura MVC limpia y modular
- Documentación de API completa
- Sistema de logging integrado

## 📁 Estructura del Proyecto

```
api-php-poo-mvc/
├── config/             # Configuraciones de la aplicación
│   ├── database.php   # Configuración de base de datos
│       
├── lib/              
│   └── Router.php     # Sistema de enrutamiento
├── public/            # Archivos públicos
│   └── index.php      # Punto de entrada
├── resources/         # Recursos estáticos
├── routes/            # Definición de rutas    
│   └── web.php
├── src/               # Código fuente principal
│   ├── Controllers/   # Controladores
│   ├── Models/        # Modelos
└── vendor/
    └── autoload.php 
```

## 💻 Requisitos

- PHP 7.4 o superior
- MySQL

## 🛠️ Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/usuario/api-php-poo-mvc.git
   cd api-php-poo-mvc
   ```
3. **Configurar el entorno**

4. **Configurar la base de datos**

## 🚦 Uso

### Iniciar el servidor web o el servido propio de php. 

```bash
php -S localhost:8000 -t public
```

## 📡 API Endpoints

### Autenticación

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| POST | `/authenticate` | Iniciar sesión | No |
| POST | `/logout` | Cerrar sesión | Sí |
| POST | `/store` | Registrar usuario | No |

### Usuarios

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/users/all` | Listar usuarios | Sí |
| GET | `/user/byId` | Obtener usuario por ID | Sí |
| GET | `/user/byEmail` | Buscar por email | Sí |
| POST | `/user/update` | Actualizar usuario | Sí |
| DELETE | `/user/delete` | Eliminar usuario | Sí |

### Tareas

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/tasks/all` | Listar tareas | Sí |
| GET | `/task/byId` | Obtener tarea | Sí |
| GET | `/task/byUser` | Tareas por usuario | Sí |
| POST | `/task/store` | Crear tarea | Sí |
| PUT | `/task/update` | Actualizar tarea | Sí |
| DELETE | `/task/delete` | Eliminar tarea | Sí |


## 🛡️ Seguridad

- Validación de entrada en todos los endpoints
- Sanitización de datos
- Encriptación de contraseñas con bcrypt
