# Backend Authentication & Authors CRUD Plan

## Objetivo

Planificar e implementar la estructura de autenticación de un Backend en Laravel utilizando **Laravel Breeze con Blade**, protegiendo el dashboard y todo lo desarrollado (el CRUD de `authors`) dentro del backend autenticado.

---

## Decisiones Principales de Arquitectura e Implementación

1. **Autenticación con Laravel Breeze (Blade):**
   - Se utilizará la estructura de controladores, solicitudes HTTP (Form Requests) y rutas provistas por Laravel Breeze.
   - Para no sobreescribir la configuración ni los estilos actuales (Tailwind 4 / Vite / layout personalizado), se incorporará la lógica y stubs de Breeze de manera limpia y compatible.
   - Se mantendrán habilitadas las rutas de: Login, Logout, Solicitud de Restablecimiento de Contraseña y Restablecimiento de Contraseña. Se deshabilitará el registro público de usuarios y la confirmación/verificación por email para mantener el backend controlado.

2. **Protección del Backend:**
   - El grupo de rutas del Backend (incluyendo el dashboard y el CRUD completo de `authors`) estará protegido mediante el middleware `auth`.
   - Si un usuario no autenticado intenta acceder a cualquier ruta del CRUD de `authors` o al dashboard, será redirigido automáticamente a la pantalla de inicio de sesión (`/login`).

3. **Inclusión del CRUD de `authors` en el Backend:**
   - Se garantizará que el modelo `Author`, migraciones (`create_authors_table`), factory (`AuthorFactory`), seeder (`AuthorSeeder`), controladores (`AuthorController`) y Form Requests (`StoreAuthorRequest`, `UpdateAuthorRequest`) cumplan rigurosamente las buenas prácticas de Laravel.
   - Las vistas de `authors` se integrarán perfectamente en el layout principal del backend (con navegación lateral/sidebar, información del usuario logueado y botón de cierre de sesión).

4. **Usuario Único Inicial (Seeder):**
   - Se creará un Seeder (`UserSeeder`) que asegure la existencia de **únicamente un usuario**:
     - **usuario (name):** `jctp`
     - **email:** `torreal@hotmail.com`
     - **password:** `12345678` (almacenado estrictamente encriptado/hasheado con `Hash::make` o el cast de contraseña del modelo `User`).
   - Se eliminarán usuarios de prueba anteriores si los hubiera (ej. `test@example.com`) para garantizar que exista únicamente este usuario.

5. **Registro de Tareas Hechas y Verificadas:**
   - Se mantendrá y actualizará el archivo `tasks.md` dentro de la carpeta `C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\000-backend\` para registrar de forma incremental y detallada cada una de las tareas ejecutadas y verificadas.

---

## Fases del Plan

### Fase 1: Documentación y Tareas
- Verificar la existencia de la carpeta `C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\000-backend\`.
- Escribir y validar el archivo `plan.md` (este documento).
- Crear / actualizar el archivo `tasks.md` en `C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\000-backend\tasks.md` estructurado por fases y casillas de verificación para auditar las tareas hechas y probadas.

### Fase 2: Instalación y Estructura de Autenticación (Breeze)
- Revisar / instalar el paquete `laravel/breeze`.
- Crear los controladores de autenticación bajo `app/Http/Controllers/Auth/`:
  - `AuthenticatedSessionController.php` (para mostrar login, procesar login y logout).
  - `PasswordResetLinkController.php` (para solicitar link de reinicio de clave).
  - `NewPasswordController.php` (para procesar el reinicio de clave).
- Crear el Form Request para la autenticación: `app/Http/Requests/Auth/LoginRequest.php`.
- Definir las rutas de autenticación en `routes/auth.php` e incluirlas en `routes/web.php`.

### Fase 3: Usuario Único y Seeders
- Crear el seeder `UserSeeder.php` en `database/seeders/`.
- Configurar el seeder para limpiar usuarios existentes e insertar un único registro:
  - `name`: `jctp`
  - `email`: `torreal@hotmail.com`
  - `password`: `Hash::make('12345678')`
- Registrar `UserSeeder` en `DatabaseSeeder.php`.
- Probar el seeder con `php artisan db:seed --class=UserSeeder`.

### Fase 4: Estructura del CRUD de Authors y Backend
- Verificar/Crear los componentes del CRUD de `authors`:
  - Migración: `database/migrations/xxxx_xx_xx_xxxxxx_create_authors_table.php` (campos: `name`, `email`, `bio`, etc.).
  - Modelo: `app/Models/Author.php` con propiedades `$fillable` y castings correspondientes.
  - Factory: `database/factories/AuthorFactory.php`.
  - Seeder: `database/seeders/AuthorSeeder.php`.
  - Form Requests: `app/Http/Requests/StoreAuthorRequest.php` y `app/Http/Requests/UpdateAuthorRequest.php` para validar entradas de datos.
  - Controlador: `app/Http/Controllers/AuthorController.php` implementando los 7 métodos del recurso RESTful (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).
- Agrupar en `routes/web.php` el dashboard y las rutas de `authors` bajo el grupo con middleware `auth`:
  ```php
  Route::middleware('auth')->group(function () {
      Route::get('/dashboard', ...)->name('dashboard');
      Route::resource('authors', AuthorController::class);
  });
  ```

### Fase 5: Vistas Blade del Backend e Interfaz
- Crear las vistas Blade para la autenticación (`resources/views/auth/login.blade.php`, `forgot-password.blade.php`, `reset-password.blade.php`).
- Actualizar/crear las vistas Blade del CRUD de `authors` (`index`, `create`, `edit`, `show`) adaptándolas al layout del Backend.
- Integrar en el layout principal / sidebar del Backend:
  - Nombre del usuario autenticado (`auth()->user()->name`).
  - Correo electrónico del usuario autenticado (`auth()->user()->email`).
  - Botón o formulario de cierre de sesión (`POST /logout`).

### Fase 6: Pruebas Automáticas (Pest / PHPUnit)
- Actualizar los tests del CRUD de `authors` para ejecutar solicitudes autenticadas mediante `actingAs($user)`.
- Crear pruebas para la autenticación:
  - Verificación del inicio de sesión exitoso con `torreal@hotmail.com` / `12345678`.
  - Verificación del bloqueo a usuarios no autenticados en rutas protegidas.
  - Verificación del cierre de sesión.
  - Verificación de la existencia exclusiva del usuario `jctp`.
- Ejecutar la suite de pruebas con `php artisan test`.

### Fase 7: Verificación y Formato de Código
- Ejecutar el formateador de código Pint (`vendor/bin/pint --dirty --format agent`).
- Compilar los assets del frontend (`npm run build`).
- Verificar que el archivo `tasks.md` en `documentos-gen-ia/specs/000-backend/tasks.md` contenga el estado exacto de todas las tareas completadas y comprobadas.

