# Plan de implementación: CRUD de Authors (Laravel 13 + Blade)

## 0. Regla obligatoria: crear y mantener `tasks.md`

Antes de escribir código, el ejecutor **debe crear `tasks.md` en la misma carpeta de la especificación** y actualizarlo durante toda la ejecución.

Ruta obligatoria de ambos archivos:

```text
C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\001-Autors_CRUD\plan.md
C:\inetpub\wwwroot\app2\documentos-gen-ia\specs\001-Autors_CRUD\tasks.md
```

Reglas de `tasks.md`:

- Debe escribirse en español, manteniendo en inglés los nombres técnicos (clases, rutas, comandos, archivos y campos).
- Cada tarea debe marcarse como `[x]` **solo después de haber sido ejecutada y verificada**.
- No se permite marcar una tarea como completada “porque debería funcionar”; debe existir una verificación real (test, comando o comprobación manual registrada).
- Debe incluir una tabla de verificación con el comando ejecutado y su resultado.
- Debe registrarse cualquier desviación del plan, decisión tomada o pendiente encontrado.
- `tasks.md` debe actualizarse al terminar cada fase, no solo al final.

Plantilla mínima sugerida:

```markdown
# Tareas: CRUD de Authors

## Estado

- [ ] Pendiente
- [x] Hecha y verificada

## Implementación

- [ ] Preflight del proyecto y base de datos
- [ ] Migración, modelo, factory y seeder
- [ ] Form Requests
- [ ] Controlador, rutas y dashboard
- [ ] Layout, navegación y modo oscuro
- [ ] Vistas de Authors
- [ ] Modal de eliminación
- [ ] Tests con Pest
- [ ] Verificación final

## Verificación

| Comando | Resultado |
| --- | --- |
| `vendor/bin/pint --dirty --format agent` | Pendiente |
| `php artisan test --compact tests/Feature/AuthorTest.php` | Pendiente |
| `npm run build` | Pendiente |
| `php artisan route:list --name=authors` | Pendiente |

## Notas

- Pendiente.
```

---

## 1. Contexto real del proyecto (hallazgos)

Antes de planificar se revisó el repositorio. Estado actual:

- Laravel Framework **13.42.0**, PHP **8.5**, Tailwind CSS **4**, Pest **5**, Blade.
- El proyecto es un **esqueleto Laravel limpio**. No existe starter kit instalado.
- No existe autenticación, dashboard, sidebar, layout de panel, componentes Blade de UI, Wayfinder, Inertia ni React.
- Solo existe:
  - `routes/web.php` con la ruta `/` hacia `welcome`.
  - `app/Models/User.php`.
  - `resources/views/welcome.blade.php`.
  - Migraciones y factory de `users`.
  - Tests de ejemplo.
- La base de datos configurada en `.env` es MySQL con nombre `app2`, pero esa base **no existe todavía** en el servidor local.
- Los tests usan SQLite en memoria mediante `phpunit.xml`.
- `tests/Pest.php` no tiene activado `RefreshDatabase` globalmente.

### Consecuencia para el plan

Como no hay starter kit ni dashboard, **no se puede “reutilizar” una navegación existente**. Para cumplir el requisito de integración se creará un shell mínimo de panel administrativo con Blade + Tailwind, siguiendo convenciones Laravel. No se instalarán dependencias nuevas ni se introducirá Inertia/React/Wayfinder.

El shell debe ser pequeño y reutilizable, no un segundo framework interno.

---

## 2. Objetivo y alcance

### Incluido

- Migración, modelo, factory y seeder de `authors`.
- Form Requests para `store` y `update`.
- Controlador resourceful de `authors`.
- Rutas RESTful limpias.
- Dashboard mínimo de bienvenida para integrar la navegación.
- Layout Blade reutilizable con sidebar, topbar móvil, modo claro/oscuro y flash messages.
- Vistas Blade:
  - `authors.index`
  - `authors.create`
  - `authors.edit`
- Modal de confirmación reutilizable para eliminar, basado en `<dialog>` nativo y JavaScript sin dependencias.
- Navegación de `Authors` integrada al panel, con estado activo.
- Tests Pest para listar, crear, actualizar, eliminar y validar.
- `tasks.md` con tareas ejecutadas y verificadas.

### Fuera de alcance

- Autenticación, login, registro o policies.
- Relaciones con `books` o `categories` (se desarrollarán en módulos posteriores).
- Búsqueda, filtros o exportaciones.
- API JSON.
- Wayfinder, Inertia o React.
- Instalación de nuevas dependencias de Composer o npm.
- Cambios de infraestructura distintos de crear la base de datos local si hace falta.

---

## 3. Decisiones técnicas

### 3.1 Nombres de campos

El enunciado usa `First_name` y `Last_name`. Para seguir las convenciones de Laravel y SQL, se normalizan a:

- `first_name`
- `last_name`
- `phrase`

Los labels visibles en la UI serán `First name`, `Last name` y `Phrase`. Todo el código, rutas, clases, variables y textos del sistema quedan en inglés.

### 3.2 Rutas

Definir en `routes/web.php`:

```php
Route::get('/dashboard', DashboardController::class)->name('dashboard');

Route::resource('authors', AuthorController::class)->except(['show']);
```

Rutas resultantes:

| Método | URI | Acción | Nombre |
| --- | --- | --- | --- |
| GET | `/dashboard` | `DashboardController` | `dashboard` |
| GET | `/authors` | `index` | `authors.index` |
| GET | `/authors/create` | `create` | `authors.create` |
| POST | `/authors` | `store` | `authors.store` |
| GET | `/authors/{author}/edit` | `edit` | `authors.edit` |
| PUT/PATCH | `/authors/{author}` | `update` | `authors.update` |
| DELETE | `/authors/{author}` | `destroy` | `authors.destroy` |

Se usa `->except(['show'])` porque el alcance solicitado no incluye una pantalla de detalle. No se usará `show` para evitar una ruta sin implementación.

### 3.3 Sin Wayfinder

Wayfinder no está instalado. Se usa el helper `route()` en Blade y controladores, tal como recomienda `AGENTS.md`. No se instala Wayfinder.

### 3.4 Sin autenticación

No existe scaffold de autenticación. Las rutas quedarán públicas en este módulo. No se instala Breeze/Jetstream/Fortify. Si en el futuro se agrega autenticación, las rutas deberán envolverse con `auth` middleware.

### 3.5 Modo oscuro

Tailwind 4 usa `prefers-color-scheme` por defecto. Para permitir un toggle manual y que el panel se vea consistente en ambos temas:

- Agregar en `resources/css/app.css`:

```css
@custom-variant dark (&:where(.dark, .dark *));
```

- Crear `resources/views/partials/theme-init.blade.php` con un script inline que lea `localStorage` y `prefers-color-scheme` y agregue `.dark` a `<html>` antes del render, evitando flash visual.
- Incluir ese partial en el layout del panel y en `welcome.blade.php` para no romper el modo oscuro existente de esa página.
- Agregar un botón de tema en el sidebar y en la topbar móvil, con icono sol/luna, `aria-label` y persistencia en `localStorage`.
- Todo componente nuevo debe incluir variantes `dark:`.

### 3.6 Modal de eliminación

No se usará `confirm()` del navegador.

Se creará un único componente reutilizable `resources/views/components/confirm-delete-modal.blade.php` basado en `<dialog>`:

- Título: `Delete author`.
- Mensaje: `Are you sure you want to delete {name}? This action cannot be undone.`
- Botones: `Cancel` y `Delete author`.
- Formulario interno con `@csrf` y `@method('DELETE')`; el `action` se asigna por JavaScript desde atributos `data-*`.
- Cierre con `Escape`, botón `Cancel` y clic en el backdrop.
- Estilos correctos en light/dark mode.
- `aria-labelledby`, `aria-describedby` y foco inicial en `Cancel`.

### 3.7 Flash messages

El controlador redirigirá con `with('success', ...)`:

- `Author created successfully.`
- `Author updated successfully.`
- `Author deleted successfully.`

El layout mostrará un banner de éxito consistente en light/dark mode cuando exista `session('success')`.

---

## 4. Sistema visual y UI/UX

### 4.1 Paleta y superficies

Usar Tailwind de forma consistente:

- Fondo general: `bg-slate-50 dark:bg-slate-950`.
- Superficies/cards: `bg-white dark:bg-slate-900`.
- Bordes: `border-slate-200 dark:border-slate-800`.
- Texto principal: `text-slate-900 dark:text-slate-100`.
- Texto secundario: `text-slate-500 dark:text-slate-400`.
- Acento primario: `indigo-600` / `indigo-500` en dark.
- Peligro: `red-600` / `red-500`.
- Éxito: `emerald-600` / `emerald-400`.

### 4.2 Espaciado y contenedores

- Contenido principal: `mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 py-8 lg:py-10`.
- Formularios: contenedor `max-w-3xl` para evitar campos demasiado anchos.
- Cards: `rounded-2xl`, `border`, `shadow-sm`, padding `p-6 sm:p-8`.
- Separación entre secciones: `space-y-6` o `gap-6`.
- Botones e inputs: `rounded-lg`.
- Nunca pegar contenido a los bordes.

### 4.3 Componentes reutilizables a crear

- `x-layouts.app`: shell del panel con sidebar, topbar móvil, contenido y flash messages.
- `x-nav-link`: item de navegación con icono, label, estado activo y `aria-current`.
- `x-page-header`: título, descripción y slot de acciones alineadas.
- `x-form-field`: label, input, placeholder, `old()`, error de validación y estilos consistentes.
- `x-confirm-delete-modal`: modal reutilizable de eliminación.

No crear un sistema de diseño completo. Solo estos componentes, justificados por reutilización real.

### 4.4 Accesibilidad

- Skip link al contenido principal.
- `aria-current="page"` en el nav activo.
- Labels asociados a inputs.
- `scope="col"` en encabezados de tabla.
- Mensajes de error junto al campo correspondiente.
- Foco visible: `focus-visible:outline-2 focus-visible:outline-offset-2`.
- Iconos decorativos con `aria-hidden="true"`.
- Contraste correcto en ambos temas.
- Modal con foco, `Escape` y cierre por backdrop.

### 4.5 Textos de UI (inglés)

- Navegación: `Dashboard`, `Authors`, `Toggle theme`, `Open navigation`, `Close navigation`.
- Index: `Authors`, `Manage the authors in your library.`, `New author`, `All authors`, `First name`, `Last name`, `Phrase`, `Actions`, `Edit`, `Delete`, `No authors yet`, `Get started by creating your first author.`
- Create: `Create author`, `Add a new author to your library.`, `Author details`, `Add the author's name and an optional short phrase.`, `Save`, `Cancel`.
- Edit: `Edit author`, `Update the author's details.`, `Save`, `Cancel`.
- Modal: `Delete author`, `Are you sure you want to delete {name}? This action cannot be undone.`, `Cancel`, `Delete author`.

---

## 5. Archivos a crear y modificar

### Creados

```text
database/migrations/*_create_authors_table.php
app/Models/Author.php
database/factories/AuthorFactory.php
database/seeders/AuthorSeeder.php
app/Http/Requests/StoreAuthorRequest.php
app/Http/Requests/UpdateAuthorRequest.php
app/Http/Controllers/AuthorController.php
app/Http/Controllers/DashboardController.php
resources/views/components/layouts/app.blade.php
resources/views/components/nav-link.blade.php
resources/views/components/page-header.blade.php
resources/views/components/form-field.blade.php
resources/views/components/confirm-delete-modal.blade.php
resources/views/partials/theme-init.blade.php
resources/views/dashboard.blade.php
resources/views/authors/index.blade.php
resources/views/authors/create.blade.php
resources/views/authors/edit.blade.php
resources/views/authors/partials/form.blade.php
tests/Feature/AuthorTest.php
documentos-gen-ia/specs/001-Autors_CRUD/tasks.md
```

### Modificados

```text
routes/web.php
resources/css/app.css
resources/js/app.js
database/seeders/DatabaseSeeder.php
resources/views/welcome.blade.php   (solo incluir theme-init para conservar su modo oscuro)
```

No se modifican `composer.json`, `package.json`, `.env` ni dependencias.

---

## 6. Fases de ejecución

## Fase 0 — Preflight y base de datos

1. Verificar versiones y estado:

```bash
php -v
php artisan --version
php artisan route:list --except-vendor
```

2. Revisar que no exista un `Author` previo para no duplicar archivos.
3. Verificar conexión a MySQL. Si la base `app2` no existe, crearla usando las credenciales ya configuradas en `.env`, sin escribir credenciales en el repositorio ni en `tasks.md`:

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS app2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

4. Si MySQL no está disponible, usar temporalmente SQLite local para verificación visual:

```text
DB_CONNECTION=sqlite
DB_DATABASE=C:\inetpub\wwwroot\app2\database\database.sqlite
```

Esta modificación de `.env` es local y no debe commitearse. Registrar la decisión en `tasks.md`.

5. Ejecutar la migración existente para confirmar que la base responde:

```bash
php artisan migrate --no-interaction
```

**Verificación de fase:** `php artisan migrate:status` responde sin errores de conexión.

---

## Fase 1 — Backend: migración, modelo, factory y seeder

1. Generar archivos con Artisan:

```bash
php artisan make:model Author --migration --factory --seed --no-interaction
```

2. Editar la migración generada para crear `authors`:

```php
Schema::create('authors', function (Blueprint $table) {
    $table->id();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('phrase')->nullable();
    $table->timestamps();

    $table->index(['last_name', 'first_name']);
});
```

3. Implementar `down()` con `Schema::dropIfExists('authors');`.
4. Crear `app/Models/Author.php` siguiendo el estilo del `User` existente:

```php
#[Fillable(['first_name', 'last_name', 'phrase'])]
class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory;
}
```

5. Implementar `AuthorFactory`:

```php
public function definition(): array
{
    return [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'phrase' => fake()->catchPhrase(),
    ];
}
```

6. Implementar `AuthorSeeder` con datos de demostración:

```php
Author::factory(8)->create();
```

7. Registrar el seeder en `DatabaseSeeder`:

```php
$this->call(AuthorSeeder::class);
```

No eliminar la creación del usuario de prueba existente.

8. Ejecutar migración y seeding:

```bash
php artisan migrate --no-interaction
php artisan db:seed --no-interaction
```

**Verificación de fase:**

```bash
php artisan tinker --execute 'App\Models\Author::count();'
```

Debe devolver un número mayor que cero si se ejecutó el seeder.

---

## Fase 2 — Form Requests, controlador y rutas

### 2.1 Form Requests

Crear:

```bash
php artisan make:request StoreAuthorRequest --no-interaction
php artisan make:request UpdateAuthorRequest --no-interaction
```

Ambos deben tener:

```php
public function authorize(): bool
{
    return true;
}

/** @return array<string, array<int, string>> */
public function rules(): array
{
    return [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'phrase' => ['nullable', 'string', 'max:255'],
    ];
}
```

`phrase` es opcional según el requisito (`string|max:255`, sin `required`).

### 2.2 Controlador `AuthorController`

Crear:

```bash
php artisan make:controller AuthorController --resource --model=Author --no-interaction
```

Implementar:

- `index`: orden determinista y paginación.

```php
$authors = Author::query()
    ->orderBy('last_name')
    ->orderBy('first_name')
    ->orderBy('id')
    ->paginate(10)
    ->withQueryString();

return view('authors.index', ['authors' => $authors]);
```

- `create`: retorna `view('authors.create')`.
- `store`: `Author::create($request->validated())`, redirige a `authors.index` con `success`.
- `edit(Author $author)`: retorna `view('authors.edit', ['author' => $author])`.
- `update(UpdateAuthorRequest $request, Author $author)`: `$author->update($request->validated())`, redirige a `authors.index` con `success`.
- `destroy(Author $author)`: `$author->delete()`, redirige a `authors.index` con `success`.

Usar route model binding implícito. No hacer `findOrFail` manual.

### 2.3 Controlador del dashboard

Crear:

```bash
php artisan make:controller DashboardController --invokable --no-interaction
```

Implementar `__invoke()` con un resumen mínimo:

```php
return view('dashboard', [
    'totalAuthors' => Author::count(),
    'authorsThisMonth' => Author::where('created_at', '>=', now()->startOfMonth())->count(),
    'latestAuthor' => Author::query()->latest('id')->first(),
    'recentAuthors' => Author::query()->latest('id')->take(5)->get(),
]);
```

El dashboard es mínimo: existe para que `Authors` sea una sección real del panel, no una pantalla aislada.

### 2.4 Rutas

Agregar en `routes/web.php`:

```php
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', DashboardController::class)->name('dashboard');

Route::resource('authors', AuthorController::class)->except(['show']);
```

No modificar la ruta `/` existente.

**Verificación de fase:**

```bash
php artisan route:list --name=authors
php artisan route:list --name=dashboard
```

Deben aparecer las rutas con los nombres esperados.

---

## Fase 3 — Shell del panel, navegación, modo oscuro y JS

### 3.1 Componente de layout

Crear el componente anónimo:

```bash
php artisan make:component layouts.app --view --no-interaction
```

`resources/views/components/layouts/app.blade.php` debe incluir:

- `<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">`.
- `@include('partials.theme-init')` dentro de `<head>`.
- `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- Sidebar fijo en desktop (`lg:fixed lg:inset-y-0 lg:w-72`).
- Contenido con `lg:pl-72`.
- Topbar móvil `lg:hidden` con botón de menú y toggle de tema.
- Overlay móvil para cerrar el sidebar.
- Marca del panel usando `config('app.name')` con fallback `Library`.
- Navegación:
  - Dashboard (`route('dashboard')`, activo con `request()->routeIs('dashboard')`).
  - Authors (`route('authors.index')`, activo con `request()->routeIs('authors.*')`).
- Botón de tema en sidebar y topbar móvil.
- Banner de `session('success')` con icono y estilos light/dark.
- Slot principal con el contenedor de ancho máximo y espaciado definido.
- Skip link al contenido.

Uso esperado en las vistas:

```blade
<x-layouts.app title="Authors">
    ...
</x-layouts.app>
```

### 3.2 Componentes auxiliares

Crear con Artisan:

```bash
php artisan make:component nav-link --view --no-interaction
php artisan make:component page-header --view --no-interaction
php artisan make:component form-field --view --no-interaction
php artisan make:component confirm-delete-modal --view --no-interaction
```

Requisitos:

- `x-nav-link`: recibe `href`, `active` y slot; aplica estilos activos/inactivos y `aria-current="page"` cuando corresponde.
- `x-page-header`: recibe `title` y `description`; renderiza slot de acciones alineado a la derecha en desktop y debajo en móvil.
- `x-form-field`: recibe `name`, `label`, `value`, `type`, `placeholder`, `required`; usa `old()`, `@error`, `id`, `name`, `autocomplete` y clases consistentes.
- `x-confirm-delete-modal`: implementa el `<dialog>` descrito en la sección 3.6.

Usar `$attributes->merge()` en los componentes cuando corresponda.

### 3.3 Tema oscuro

1. Agregar en `resources/css/app.css`:

```css
@import 'tailwindcss';

@custom-variant dark (&:where(.dark, .dark *));

@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';

@theme {
    --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji',
        'Segoe UI Symbol', 'Noto Color Emoji';
}
```

2. Crear `resources/views/partials/theme-init.blade.php`:

```html
<script>
    (function () {
        const storedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
            document.documentElement.classList.add('dark');
        }
    })();
</script>
```

3. Incluir ese partial en el `<head>` del layout y de `welcome.blade.php`.

### 3.4 JavaScript

Editar `resources/js/app.js` con JavaScript nativo, sin dependencias:

- Toggle de tema:
  - Escuchar `[data-theme-toggle]`.
  - Alternar `.dark` en `document.documentElement`.
  - Guardar `theme` en `localStorage`.
- Sidebar móvil:
  - Abrir/cerrar con `[data-sidebar-toggle]`.
  - Alternar clases de traducción y overlay.
  - Actualizar `aria-expanded`.
- Modal de eliminación:
  - Escuchar `[data-delete-author]`.
  - Asignar `form.action` desde `data-delete-url`.
  - Escribir el nombre del autor en `[data-delete-author-name]`.
  - Abrir con `showModal()`.
  - Cerrar con `[data-modal-cancel]`, `Escape` y clic en el backdrop.

No usar `confirm()` ni librerías externas.

**Verificación de fase:**

```bash
npm run build
```

Debe compilar sin errores y generar el manifest de Vite.

---

## Fase 4 — Vistas de Authors y dashboard

### 4.1 `resources/views/authors/index.blade.php`

Estructura:

1. `<x-layouts.app title="Authors">`.
2. `<x-page-header title="Authors" description="Manage the authors in your library.">` con acción principal:
   - Enlace `New author` a `route('authors.create')`, con icono `+`.
3. Card contenedora de la tabla:
   - Header de card con `All authors` y contador (`{total} author(s)`).
   - Tabla semántica dentro de `overflow-x-auto`.
   - Columnas: `First name`, `Last name`, `Phrase` (oculta en móvil con `hidden md:table-cell`), `Actions`.
   - Filas con hover suave.
   - Acciones alineadas a la derecha: `Edit` (enlace) y `Delete` (botón que abre el modal).
4. Estado vacío elegante si `$authors->isEmpty()`:
   - Icono de usuarios.
   - Título `No authors yet`.
   - Texto `Get started by creating your first author.`
   - CTA `New author`.
5. Paginación con `{{ $authors->links() }}` solo si `hasPages()`.
6. `<x-confirm-delete-modal />` al final.

Los botones de eliminar deben incluir:

```blade
data-delete-author
data-delete-url="{{ route('authors.destroy', $author) }}"
data-author-name="{{ $author->first_name }} {{ $author->last_name }}"
```

No usar `onclick="confirm(...)"`.

### 4.2 `resources/views/authors/create.blade.php`

- `<x-layouts.app title="Create author">`.
- `<x-page-header title="Create author" description="Add a new author to your library." />`.
- Contenedor `max-w-3xl`.
- Card con header interno:
  - `Author details`.
  - `Add the author's name and an optional short phrase.`
- Formulario:

```blade
<form method="POST" action="{{ route('authors.store') }}">
    @csrf
    @include('authors.partials.form', ['author' => null, 'submitLabel' => 'Save'])
</form>
```

### 4.3 `resources/views/authors/edit.blade.php`

- `<x-layouts.app title="Edit author">`.
- `<x-page-header title="Edit author" description="Update the author's details." />`.
- Card con header interno.
- Formulario:

```blade
<form method="POST" action="{{ route('authors.update', $author) }}">
    @csrf
    @method('PUT')
    @include('authors.partials.form', ['author' => $author, 'submitLabel' => 'Save'])
</form>
```

### 4.4 `resources/views/authors/partials/form.blade.php`

- Grid `md:grid-cols-2` con:
  - `first_name` (required, `autocomplete="given-name"`, placeholder `Jane`).
  - `last_name` (required, `autocomplete="family-name"`, placeholder `Austen`).
  - `phrase` a ancho completo, opcional, placeholder `A short memorable phrase`, `maxlength="255"`.
- Usar `<x-form-field>` para los tres campos.
- Acciones separadas con `border-t` y padding:
  - `Cancel` como enlace a `route('authors.index')`.
  - Botón principal `{{ $submitLabel }}` con estilo primario.
- En móvil, acciones apiladas; en desktop, alineadas a la derecha.
- Errores de validación visibles debajo de cada campo.

### 4.5 `resources/views/dashboard.blade.php`

- `<x-layouts.app title="Dashboard">`.
- `<x-page-header title="Dashboard" description="An overview of your library.">` con acción `New author`.
- Grid de 3 stat cards:
  - `Total authors` con `{{ $totalAuthors }}`.
  - `New this month` con `{{ $authorsThisMonth }}`.
  - `Latest author` con el nombre o `—`.
- Card `Recent authors`:
  - Lista/tabla simple con los últimos 5 autores y enlace `View all` a `authors.index`.
  - Empty state con CTA si no hay autores.

**Verificación de fase:**

- Abrir `/dashboard` y `/authors` con el servidor local.
- Comprobar navegación, estado activo, light/dark, responsive, empty state, formularios y modal.
- Si no hay datos, ejecutar el seeder o crear autores desde la UI.

---

## Fase 5 — Tests con Pest

Crear:

```bash
php artisan make:test --pest AuthorTest --no-interaction
```

Archivo: `tests/Feature/AuthorTest.php`.

Requisitos:

```php
use App\Models\Author;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

beforeEach(function () {
    $this->withoutVite();
});

describe('authors', function () {
    // tests
});
```

`withoutVite()` evita que los tests dependan de que exista un build de Vite. El build se verificará aparte para la UI real.

Tests mínimos:

1. `renders the authors index page`
   - Crear un autor con factory.
   - `get(route('authors.index'))->assertOk()`.
   - `assertSee($author->first_name)` y `assertSee($author->last_name)`.
2. `renders the create author page`
   - `get(route('authors.create'))->assertOk()`.
   - `assertSee('Create author')`.
3. `creates an author`
   - `post(route('authors.store'), [...])`.
   - `assertRedirect(route('authors.index'))`.
   - `assertSessionHas('success', 'Author created successfully.')`.
   - `assertDatabaseHas('authors', [...])`.
4. `returns validation errors when creating an author`
   - `post(route('authors.store'), [])`.
   - `assertSessionHasErrors(['first_name', 'last_name'])`.
   - `assertDatabaseCount('authors', 0)`.
5. `updates an author`
   - Crear autor con factory.
   - `put(route('authors.update', $author), [...])`.
   - `assertRedirect(route('authors.index'))`.
   - `assertSessionHas('success', 'Author updated successfully.')`.
   - `assertDatabaseHas('authors', ['id' => $author->id, ...])`.
6. `returns validation errors when updating an author`
   - `put(route('authors.update', $author), ['first_name' => '', 'last_name' => ''])`.
   - `assertSessionHasErrors(['first_name', 'last_name'])`.
7. `deletes an author`
   - Crear autor con factory.
   - `delete(route('authors.destroy', $author))`.
   - `assertRedirect(route('authors.index'))`.
   - `assertSessionHas('success', 'Author deleted successfully.')`.
   - `assertModelMissing($author)`.

Opcional recomendado:

8. `creates an author without a phrase`
   - Verifica que `phrase` sea nullable y que se cree correctamente.

**Verificación de fase:**

```bash
php artisan test --compact tests/Feature/AuthorTest.php
```

Todos los tests deben pasar.

---

## Fase 6 — Verificación final, `tasks.md` y resumen

### 6.1 Comandos obligatorios

```bash
vendor/bin/pint --dirty --format agent
php artisan test --compact tests/Feature/AuthorTest.php
php artisan route:list --name=authors
npm run build
```

Si se modificó `welcome.blade.php` o el layout, verificar también:

```bash
php artisan test --compact tests/Feature/ExampleTest.php
```

Opcional, si el tiempo lo permite:

```bash
php artisan test --compact
```

### 6.2 Revisión manual de UI

Con `npm run build` (o `npm run dev`) y el servidor local:

- `/dashboard` carga con sidebar y contenido.
- `/authors` muestra header, tabla, contador, acciones y paginación.
- `/authors?page=2` funciona si hay suficientes registros.
- `/authors/create` muestra card, labels, placeholders y errores.
- `/authors/{id}/edit` carga valores existentes.
- El botón `Delete` abre el modal, muestra el nombre correcto y no usa `confirm()`.
- Cancelar en el modal cierra sin borrar.
- Confirmar elimina y muestra flash message.
- El modo claro y oscuro se ven correctamente en sidebar, tabla, formularios, botones y modal.
- El layout es responsive: sidebar off-canvas en móvil, tabla con scroll horizontal.
- No hay contenido pegado a los bordes ni botones desalineados.

### 6.3 Actualizar `tasks.md`

Antes de finalizar:

- Marcar `[x]` solo las tareas verificadas.
- Registrar los comandos ejecutados y sus resultados.
- Registrar tests ejecutados y cantidad.
- Registrar cualquier desviación del plan.
- Registrar pendientes conocidos (por ejemplo, autenticación fuera de alcance).

### 6.4 Resumen final (en español)

El ejecutor debe entregar un resumen breve con:

- Archivos creados.
- Archivos modificados.
- Comandos ejecutados.
- Tests ejecutados y resultado.
- Notas relevantes (por ejemplo, “no se usó Wayfinder porque no está instalado”).
- Confirmación de que `tasks.md` fue creado y actualizado.

No hacer commit salvo que el usuario lo solicite explícitamente.

---

## 7. Checklist de aceptación

- [ ] Existe migración `authors` con `first_name`, `last_name`, `phrase` nullable y timestamps.
- [ ] Existe modelo `Author` con `#[Fillable]` y factory.
- [ ] Existe seeder de autores y `DatabaseSeeder` lo invoca.
- [ ] Existen `StoreAuthorRequest` y `UpdateAuthorRequest` con las reglas acordadas.
- [ ] Existe `AuthorController` con `index`, `create`, `store`, `edit`, `update`, `destroy`.
- [ ] Las rutas usan `authors.index`, `authors.create`, `authors.store`, `authors.edit`, `authors.update`, `authors.destroy`.
- [ ] `/dashboard` existe y está integrado al layout.
- [ ] El sidebar muestra `Dashboard` y `Authors` con estado activo.
- [ ] El panel funciona en light y dark mode, con toggle persistente.
- [ ] El index tiene header, descripción, CTA, tabla, contador, acciones, paginación y empty state.
- [ ] Create y Edit usan cards, labels, placeholders, errores y acciones `Save`/`Cancel`.
- [ ] Delete usa modal de confirmación, nunca `confirm()` del navegador.
- [ ] Los flash messages de éxito se muestran correctamente.
- [ ] Los tests de Pest cubren index, create, update, delete y validación.
- [ ] `vendor/bin/pint --dirty --format agent` pasa.
- [ ] `npm run build` pasa.
- [ ] `tasks.md` existe y registra tareas hechas y verificadas.
- [ ] No se agregaron dependencias ni se introdujo Inertia/React/Wayfinder.
