# Tareas del Backend de Autenticación y CRUD de Authors

Este documento registra las tareas planificadas, ejecutadas y verificadas para la implementación del backend con autenticación Laravel Breeze (Blade) y el CRUD de `authors`.

---

## Fase 1: Documentación y Planificación
- [x] Crear / actualizar el archivo de planificación `plan.md` en `C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\000-backend\plan.md`.
- [x] Crear / actualizar el archivo de tareas `tasks.md` en `C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\000-backend\tasks.md`.

## Fase 2: Configuración de Autenticación Laravel Breeze
- [ ] Verificar la dependencia de `laravel/breeze` en `composer.json`.
- [ ] Crear los controladores de autenticación (`AuthenticatedSessionController`, `PasswordResetLinkController`, `NewPasswordController`).
- [ ] Crear el Form Request para login (`LoginRequest.php`).
- [ ] Configurar las rutas de autenticación en `routes/auth.php` y enlazarlas en `routes/web.php`.

## Fase 3: Creación de Usuario Único (Seeder y Hash)
- [ ] Crear el seeder `UserSeeder.php` que inserte únicamente el usuario:
  - usuario: `jctp`
  - email: `torreal@hotmail.com`
  - password: `12345678` (almacenado con `Hash::make`).
- [ ] Asegurar que no existan otros usuarios en la tabla `users`.
- [ ] Registrar `UserSeeder` en `DatabaseSeeder.php` y ejecutar la siembra de base de datos.

## Fase 4: Integración del CRUD de Authors al Backend
- [ ] Verificar la migración de `authors` (`create_authors_table`).
- [ ] Verificar el modelo `Author` y su factory/seeder.
- [ ] Crear / Verificar Form Requests para la creación y actualización de autores (`StoreAuthorRequest`, `UpdateAuthorRequest`).
- [ ] Verificar / Actualizar `AuthorController` siguiendo las mejores prácticas de Laravel.
- [ ] Proteger el grupo de rutas del backend (`dashboard` y recurso `authors`) con el middleware `auth`.

## Fase 5: Vistas Blade del Backend
- [ ] Crear / actualizar la vista de inicio de sesión (`resources/views/auth/login.blade.php`).
- [ ] Crear / actualizar las vistas de recuperación de contraseña.
- [ ] Integrar en la barra lateral (sidebar) del backend los datos del usuario logueado (`jctp` / `torreal@hotmail.com`) y la opción de cerrar sesión (Logout).
- [ ] Asegurar la coherencia de estilos Blade en el CRUD de `authors`.

## Fase 6: Pruebas y Verificación
- [ ] Actualizar/crear pruebas automatizadas con Pest para verificar autenticación, protección de rutas y CRUD de `authors`.
- [ ] Formatear código PHP con Laravel Pint (`vendor/bin/pint --dirty --format agent`).
- [ ] Ejecutar compilación de assets con Vite (`npm run build`).
- [ ] Verificar que sólo exista el usuario `jctp` con su contraseña encriptada correctamente.
- [ ] Marcar todas las tareas completadas y verificadas en este archivo.

