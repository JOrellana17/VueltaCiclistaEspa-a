# Funcionamiento del sistema

## 1. Objetivo del proyecto

Este proyecto implementa un sistema web en Laravel para administrar una Vuelta Ciclista. El sistema permite gestionar:

- Equipos
- Ciclistas
- Pruebas
- Participaciones de equipos en pruebas
- Asignacion de ganador por prueba
- Catalogo de nacionalidades

Ademas, el sistema incorpora reglas de negocio importantes:

- Un ciclista no puede crearse sin equipo.
- Un ciclista solo puede asociarse a un equipo activo.
- Las fechas de contrato del ciclista deben ser coherentes.
- Una participacion solo puede usar un equipo activo y una prueba activa.
- El ganador de una prueba debe pertenecer al equipo seleccionado.
- Solo puede existir un ganador por prueba.
- Equipos, ciclistas y participaciones se inactivan en lugar de borrarse logicamente en varios flujos.

## 2. Arquitectura general

El proyecto sigue la arquitectura MVC de Laravel:

- `Models`: representan las tablas y relaciones de base de datos.
- `Controllers`: contienen la logica de negocio y coordinan peticiones/respuestas.
- `Views`: plantillas Blade para renderizar la interfaz.
- `Migrations`: definen la estructura de la base de datos.
- `Routes`: conectan URLs con controladores.
- `Middleware`: aplican reglas transversales a las peticiones HTTP.
- `Providers`: registran y arrancan servicios del framework.

Flujo general de una peticion:

1. El usuario entra por una ruta.
2. Laravel pasa la peticion por el `Http\Kernel` y sus middleware.
3. La ruta resuelve el controlador correspondiente.
4. El controlador valida datos, consulta modelos y devuelve una vista o redireccion.
5. La vista Blade renderiza HTML usando relaciones cargadas desde Eloquent.

## 3. Base de datos y migraciones

### 3.1 `2026_03_15_031200_create_nacionalidades_table.php`

Tabla: `nacionalidades`

Columnas:

- `id_nacionalidad`: clave primaria.
- `codigo_iso`: codigo ISO de 3 caracteres, unico.
- `nombre`: nombre del pais, unico.
- `timestamps`.

Funcionamiento:

- Crea el catalogo de nacionalidades.
- Inserta un conjunto amplio de nacionalidades directamente en la migracion.

Metodo `up()`:

- Crea la tabla.
- Inserta los registros iniciales con `DB::table('nacionalidades')->insert(...)`.

Metodo `down()`:

- Elimina la tabla `nacionalidades`.

### 3.2 `2026_03_15_031225_create_equipos_table.php`

Tabla: `equipos`

Columnas:

- `id_equipo`: clave primaria.
- `nombre`: nombre del equipo.
- `director`: director del equipo.
- `id_nacionalidad`: FK a `nacionalidades.id_nacionalidad`.
- `estado`: enum `activo|inactivo`, por defecto `activo`.
- `timestamps`.

Funcionamiento:

- Representa la entidad base de los equipos.
- Cada equipo tiene una nacionalidad normalizada, no almacenada como texto libre.

Metodo `up()`:

- Crea la tabla y la FK a nacionalidades.

Metodo `down()`:

- Elimina la tabla `equipos`.

### 3.3 `2026_03_15_031312_create_ciclistas_table.php`

Tabla: `ciclistas`

Columnas:

- `id_ciclistas`: clave primaria.
- `id_equipo`: FK a `equipos.id_equipo`.
- `id_nacionalidad`: FK a `nacionalidades.id_nacionalidad`.
- `nombre`: nombre del ciclista.
- `fecha_nacimiento`: fecha de nacimiento.
- `fecha_inicio_contrato`: fecha de inicio del contrato actual del ciclista.
- `fecha_fin_contrato`: fecha de finalizacion del contrato actual.
- `estado_contrato`: enum `activo|inactivo`.
- `estado`: enum `activo|inactivo`.
- `timestamps`.

Funcionamiento:

- Esta tabla ya incorpora los datos contractuales del ciclista.
- El contrato ya no se gestiona en un modulo aparte.
- Cada ciclista siempre esta asociado a un equipo por FK.

Metodo `up()`:

- Crea la tabla con sus dos claves foraneas.
- Añade las fechas de contrato y el estado del contrato.

Metodo `down()`:

- Elimina la tabla `ciclistas`.

### 3.4 `2026_03_15_031319_create_pruebas_table.php`

Tabla: `pruebas`

Columnas:

- `id`: clave primaria.
- `nombre`: nombre de la prueba.
- `numero_etapas`: cantidad de etapas.
- `anio_edicion`: ano de edicion.
- `km_totales`: kilometros totales.
- `estado`: enum `activo|inactivo`.
- `timestamps`.

Funcionamiento:

- Define las pruebas sin almacenar ganador dentro de esta tabla.
- El ganador se maneja en la tabla `ganadores`.

Metodo `up()`:

- Crea la tabla `pruebas`.

Metodo `down()`:

- Elimina la tabla `pruebas`.

### 3.5 `2026_03_15_031333_create_participas_table.php`

Tabla: `participas`

Columnas:

- `id_participa`: clave primaria.
- `id_equipo`: FK a `equipos.id_equipo`.
- `id_prueba`: FK a `pruebas.id`.
- `fecha_inicio`: fecha de inicio de la participacion.
- `fin_contrato`: fecha final de la participacion.
- `estado`: enum `activo|inactivo`.
- `timestamps`.

Funcionamiento:

- Relaciona equipos con pruebas.
- Permite controlar vigencia temporal de la participacion.

Metodo `up()`:

- Crea la tabla con sus dos claves foraneas y estado embebido.

Metodo `down()`:

- Elimina la tabla `participas`.

### 3.6 `2026_03_19_100400_create_ganadores_table.php`

Tabla: `ganadores`

Columnas:

- `id_ganador`: clave primaria.
- `id_prueba`: FK unica a `pruebas.id`.
- `id_equipo`: FK a `equipos.id_equipo`.
- `id_ciclista`: FK a `ciclistas.id_ciclistas`.
- `timestamps`.

Funcionamiento:

- Separa la asignacion del ganador del resto de datos de la prueba.
- La columna `id_prueba` es unica, por lo que solo existe un ganador por prueba.

Metodo `up()`:

- Crea la tabla `ganadores`.
- Impone unicidad sobre la prueba.

Metodo `down()`:

- Elimina la tabla `ganadores`.

## 4. Modelos

### 4.1 `App\Models\Nacionalidad`

Archivo: `app/Models/Nacionalidad.php`

Responsabilidad:

- Representa el catalogo de nacionalidades.
- Centraliza el nombre del pais y su codigo ISO.

Atributos asignables:

- `codigo_iso`
- `nombre`

Metodos:

#### `equipos(): HasMany`

- Devuelve todos los equipos asociados a una nacionalidad.

#### `ciclistas(): HasMany`

- Devuelve todos los ciclistas asociados a una nacionalidad.

### 4.2 `App\Models\Equipo`

Archivo: `app/Models/Equipo.php`

Responsabilidad:

- Representa a cada escuadra ciclista.

Atributos asignables:

- `nombre`
- `director`
- `id_nacionalidad`
- `estado`

Metodos:

#### `nacionalidad(): BelongsTo`

- Devuelve la nacionalidad del equipo.

#### `ciclistas(): HasMany`

- Devuelve los ciclistas asociados actualmente al equipo mediante `id_equipo`.

#### `participaciones(): HasMany`

- Devuelve las participaciones del equipo en distintas pruebas.

### 4.3 `App\Models\Ciclista`

Archivo: `app/Models/Ciclista.php`

Responsabilidad:

- Representa a cada corredor del sistema.
- Incluye datos personales, equipo actual y datos contractuales.

Atributos asignables:

- `id_equipo`
- `id_nacionalidad`
- `nombre`
- `fecha_nacimiento`
- `fecha_inicio_contrato`
- `fecha_fin_contrato`
- `estado_contrato`
- `estado`

Metodos:

#### `equipo(): BelongsTo`

- Devuelve el equipo actual del ciclista.

#### `nacionalidad(): BelongsTo`

- Devuelve la nacionalidad del ciclista.

### 4.4 `App\Models\Prueba`

Archivo: `app/Models/Prueba.php`

Responsabilidad:

- Representa cada prueba o carrera.

Atributos asignables:

- `nombre`
- `numero_etapas`
- `anio_edicion`
- `km_totales`
- `estado`

Metodos:

#### `ganador(): HasOne`

- Devuelve el registro de ganador asociado a la prueba.
- No devuelve directamente un ciclista, sino la entidad `Ganador`.

#### `participaciones(): HasMany`

- Devuelve las participaciones de equipos en la prueba.

### 4.5 `App\Models\Participa`

Archivo: `app/Models/Participa.php`

Responsabilidad:

- Representa la participacion de un equipo en una prueba.

Atributos asignables:

- `id_equipo`
- `id_prueba`
- `fecha_inicio`
- `fin_contrato`
- `estado`

Metodos:

#### `equipo(): BelongsTo`

- Devuelve el equipo participante.

#### `prueba(): BelongsTo`

- Devuelve la prueba en la que participa el equipo.

### 4.6 `App\Models\Ganador`

Archivo: `app/Models/Ganador.php`

Responsabilidad:

- Representa la asignacion del ganador oficial de una prueba.

Atributos asignables:

- `id_prueba`
- `id_equipo`
- `id_ciclista`

Metodos:

#### `prueba(): BelongsTo`

- Devuelve la prueba asociada.

#### `equipo(): BelongsTo`

- Devuelve el equipo al que pertenece el ganador seleccionado.

#### `ciclista(): BelongsTo`

- Devuelve el ciclista ganador.

### 4.7 `App\Models\User`

Archivo: `app/Models/User.php`

Responsabilidad:

- Modelo estandar de autenticacion de Laravel.
- No participa en la logica principal del sistema de ciclismo.

## 5. Controladores

### 5.1 `App\Http\Controllers\Controller`

Archivo: `app/Http/Controllers/Controller.php`

Responsabilidad:

- Clase base para los demas controladores.
- Hereda soporte de autorizacion y validacion de Laravel.

No define metodos propios.

### 5.2 `App\Http\Controllers\EquipoController`

Archivo: `app/Http/Controllers/EquipoController.php`

Responsabilidad:

- Gestionar CRUD de equipos.
- Mostrar detalle del equipo y sus ciclistas.

Metodos:

#### `index()`

- Carga todos los equipos con su nacionalidad.
- Ordena por nombre.
- Devuelve la vista `equipo.index`.

#### `create()`

- Carga todas las nacionalidades para el formulario.
- Devuelve la vista `equipo.create`.

#### `store(Request $request)`

- Valida y crea un equipo.

Validaciones:

- `nombre`: requerido, string, maximo 50.
- `director`: requerido, string, maximo 50.
- `id_nacionalidad`: requerido, debe existir en `nacionalidades`.
- `estado`: requerido, solo `activo` o `inactivo`.

#### `show(string $id)`

- Busca un equipo por su id.
- Carga tambien `nacionalidad` y `ciclistas.nacionalidad`.
- Si no existe, redirige con error.
- Si existe, muestra `equipo.show`.

#### `edit(string $id)`

- Carga equipo y nacionalidades para edicion.
- Si no existe, redirige con error.

#### `update(Request $request, string $id)`

- Valida igual que `store()`.
- Actualiza el equipo existente.

#### `destroy(string $id)`

- No elimina fisicamente el registro.
- Cambia `estado` a `inactivo`.

### 5.3 `App\Http\Controllers\CiclistaController`

Archivo: `app/Http/Controllers/CiclistaController.php`

Responsabilidad:

- Gestionar CRUD de ciclistas.
- Aplicar reglas de integridad sobre el equipo y el contrato.

Metodos:

#### `index()`

- Carga ciclistas con `equipo` y `nacionalidad`.
- Ordena por nombre.
- Devuelve `ciclista.index`.

#### `create()`

- Carga solo equipos con estado `activo`.
- Carga todas las nacionalidades.
- Devuelve `ciclista.create`.

#### `store(Request $request)`

- Valida y crea un ciclista.

Validaciones:

- `id_equipo`: requerido y debe existir en `equipos` con `estado = activo`.
- `id_nacionalidad`: requerido y debe existir en `nacionalidades`.
- `nombre`: requerido, string, maximo 50.
- `fecha_nacimiento`: requerido, date.
- `fecha_inicio_contrato`: requerido, date.
- `fecha_fin_contrato`: requerido, date y debe ser mayor o igual que `fecha_inicio_contrato`.
- `estado_contrato`: requerido, `activo` o `inactivo`.
- `estado`: requerido, `activo` o `inactivo`.

Esta es la validacion que impide crear un ciclista sin equipo.

Explicacion puntual:

- El campo `id_equipo` es obligatorio.
- Ademas no basta con que exista cualquier id: debe existir un equipo real en la tabla `equipos`.
- Y no basta con que exista: la regla `Rule::exists(...)->where(...)` exige que ese equipo este activo.

En la practica esto evita tres errores:

1. Crear un ciclista sin seleccionar equipo.
2. Enviar manualmente un `id_equipo` inexistente.
3. Asociar el ciclista a un equipo inactivo.

#### `show(string $id)`

- Carga ciclista con `equipo` y `nacionalidad`.
- Si no existe, redirige con error.
- Si existe, devuelve `ciclista.show`.

#### `edit(string $id)`

- Busca el ciclista.
- Carga equipos activos o el equipo actual del ciclista.
- Esto permite editar registros historicos sin romper la seleccion si el equipo actual esta inactivo.
- Carga nacionalidades.

#### `update(Request $request, string $id)`

- Repite las validaciones de `store()`.
- Actualiza datos generales y contractuales del ciclista.

#### `destroy(string $id)`

- No borra fisicamente al ciclista.
- Cambia `estado` a `inactivo`.

### 5.4 `App\Http\Controllers\ParticipaController`

Archivo: `app/Http/Controllers/ParticipaController.php`

Responsabilidad:

- Gestionar la participacion de equipos en pruebas.
- Permitir habilitar e inhabilitar participaciones.

Metodos:

#### `index()`

- Carga participaciones con `equipo` y `prueba`.
- Ordena por id descendente.
- Devuelve `participa.index`.

#### `create()`

- Carga equipos activos.
- Carga pruebas activas.
- Devuelve `participa.create`.

#### `store(Request $request)`

- Valida y crea una participacion.

Validaciones:

- `id_equipo`: requerido y solo de equipos activos.
- `id_prueba`: requerido y solo de pruebas activas.
- `fecha_inicio`: requerido, date.
- `fin_contrato`: requerido, date, mayor o igual que `fecha_inicio`.
- `estado`: requerido, `activo` o `inactivo`.

#### `show(string $id)`

- Muestra una participacion concreta.

#### `edit(string $id)`

- Carga el registro.
- Carga equipos activos o el equipo actual del registro.
- Carga pruebas activas o la prueba actual del registro.
- Esto permite editar participaciones historicas sin perder consistencia visual.

#### `update(Request $request, string $id)`

- Repite validaciones.
- Permite mantener el equipo o prueba actual aunque uno de ellos haya quedado inactivo.

#### `destroy(string $id)`

- No elimina fisicamente.
- Cambia `estado` a `inactivo`.

#### `toggleEstado(string $id)`

- Alterna `estado` entre `activo` e `inactivo`.
- Es la accion usada por el boton de habilitar/inhabilitar del modulo.

### 5.5 `App\Http\Controllers\PruebaController`

Archivo: `app/Http/Controllers/PruebaController.php`

Responsabilidad:

- Gestionar CRUD de pruebas.
- Mantener la prueba separada de la asignacion de ganador.

Metodos:

#### `index()`

- Lista pruebas por `anio_edicion` descendente.
- Devuelve `prueba.index`.

#### `create()`

- Devuelve la vista `prueba.create`.

#### `store(Request $request)`

- Valida y crea la prueba.

Validaciones:

- `nombre`: requerido, string, maximo 50.
- `numero_etapas`: requerido, integer.
- `anio_edicion`: requerido, integer, entre 1900 y 2100.
- `km_totales`: requerido, integer.
- `estado`: requerido, `activo` o `inactivo`.

#### `show(string $id)`

- Muestra una prueba concreta.

#### `edit(string $id)`

- Carga la prueba para edicion.

#### `update(Request $request, string $id)`

- Repite validaciones de `store()`.
- Actualiza la prueba.

#### `destroy(string $id)`

- Elimina fisicamente la prueba con `delete()`.
- A diferencia de equipos y ciclistas, aqui no se inactiva: se borra.

### 5.6 `App\Http\Controllers\GanadorController`

Archivo: `app/Http/Controllers/GanadorController.php`

Responsabilidad:

- Gestionar la asignacion del ganador oficial de una prueba.

Metodos:

#### `index()`

- Carga todos los registros de `ganadores` con sus relaciones `prueba`, `equipo` y `ciclista`.
- Devuelve `ganador.index`.

#### `create(Request $request)`

- Carga pruebas activas.
- Carga equipos activos.
- Carga ciclistas activos.
- Lee `id_prueba` desde query string para preseleccionar una prueba en el formulario.

#### `store(Request $request)`

- Valida y asigna un ganador.

Validaciones:

- `id_prueba`: requerido, debe existir y estar activa.
- `id_equipo`: requerido, debe existir y estar activo.
- `id_ciclista`: requerido, debe existir, estar activo y pertenecer al equipo enviado.

Regla clave:

- La consulta `Rule::exists('ciclistas', 'id_ciclistas')->where(...)->where('id_equipo', $request->id_equipo)` obliga a que el ciclista seleccionado sea del equipo seleccionado.

Persistencia:

- Usa `Ganador::updateOrCreate(...)`.
- Si la prueba ya tiene ganador, se actualiza.
- Si no lo tiene, se crea.

## 6. Providers, kernels y manejo del framework

### 6.1 `App\Providers\AppServiceProvider`

Archivo: `app/Providers/AppServiceProvider.php`

Metodos:

#### `register()`

- Punto de registro de servicios de la aplicacion.
- Actualmente vacio.

#### `boot()`

- Punto de arranque de servicios.
- Actualmente vacio.

### 6.2 `App\Providers\AuthServiceProvider`

Archivo: `app/Providers/AuthServiceProvider.php`

Propiedad:

- `$policies`: actualmente vacia.

Metodo:

#### `boot()`

- Punto de carga de autorizaciones y politicas.
- Actualmente vacio.

### 6.3 `App\Providers\BroadcastServiceProvider`

Archivo: `app/Providers/BroadcastServiceProvider.php`

Metodo:

#### `boot()`

- Registra rutas de broadcast con `Broadcast::routes()`.
- Carga `routes/channels.php`.

### 6.4 `App\Providers\EventServiceProvider`

Archivo: `app/Providers/EventServiceProvider.php`

Propiedad:

- `$listen`: asocia `Registered::class` con `SendEmailVerificationNotification::class`.

Metodos:

#### `boot()`

- Punto de arranque de eventos.
- Actualmente sin logica propia.

#### `shouldDiscoverEvents(): bool`

- Devuelve `false`.
- Desactiva descubrimiento automatico de listeners.

### 6.5 `App\Providers\RouteServiceProvider`

Archivo: `app/Providers/RouteServiceProvider.php`

Constante:

- `HOME = '/home'`

Metodo:

#### `boot()`

- Configura el limitador `api` a 60 peticiones por minuto por usuario o IP.
- Registra las rutas `api.php` bajo prefijo `api`.
- Registra las rutas `web.php` con middleware `web`.

### 6.6 `App\Console\Kernel`

Archivo: `app/Console/Kernel.php`

Metodos:

#### `schedule(Schedule $schedule)`

- Punto para programar tareas cron.
- Actualmente vacio.

#### `commands()`

- Carga comandos desde `app/Console/Commands`.
- Carga `routes/console.php`.

### 6.7 `App\Exceptions\Handler`

Archivo: `app/Exceptions/Handler.php`

Propiedad:

- `$dontFlash`: evita reenviar a sesion los campos sensibles:
  - `current_password`
  - `password`
  - `password_confirmation`

Metodo:

#### `register()`

- Registra callbacks de excepciones reportables.
- Actualmente no contiene logica personalizada.

### 6.8 `App\Http\Kernel`

Archivo: `app/Http/Kernel.php`

Responsabilidad:

- Orquestar todos los middleware de la aplicacion.

Propiedades:

#### `$middleware`

- Middleware global aplicable a todas las peticiones.
- Incluye proxies, CORS, mantenimiento, tamano de peticion y normalizacion de strings.

#### `$middlewareGroups`

- Grupo `web`:
  - cookies
  - sesiones
  - CSRF
  - `SubstituteBindings`

- Grupo `api`:
  - `ThrottleRequests:api`
  - `SubstituteBindings`

#### `$middlewareAliases`

- Expone alias como `auth`, `guest`, `signed`, `throttle`, etc.

## 7. Middleware

### 7.1 `Authenticate`

Archivo: `app/Http/Middleware/Authenticate.php`

Metodo:

#### `redirectTo(Request $request): ?string`

- Si la peticion no espera JSON, redirige a la ruta `login`.
- Si espera JSON, devuelve `null`.

### 7.2 `EncryptCookies`

Archivo: `app/Http/Middleware/EncryptCookies.php`

Propiedad:

- `$except`: vacia.

Funcionamiento:

- No excluye cookies del cifrado.

### 7.3 `PreventRequestsDuringMaintenance`

Archivo: `app/Http/Middleware/PreventRequestsDuringMaintenance.php`

Propiedad:

- `$except`: vacia.

Funcionamiento:

- No define rutas exentas durante mantenimiento.

### 7.4 `RedirectIfAuthenticated`

Archivo: `app/Http/Middleware/RedirectIfAuthenticated.php`

Metodo:

#### `handle(Request $request, Closure $next, string ...$guards): Response`

- Si el usuario ya esta autenticado, lo redirige a `RouteServiceProvider::HOME`.
- Si no, deja continuar la peticion.

### 7.5 `TrimStrings`

Archivo: `app/Http/Middleware/TrimStrings.php`

Propiedad:

- `$except`: no recorta espacios de:
  - `current_password`
  - `password`
  - `password_confirmation`

### 7.6 `TrustHosts`

Archivo: `app/Http/Middleware/TrustHosts.php`

Metodo:

#### `hosts(): array`

- Devuelve los subdominios confiables de la aplicacion.

### 7.7 `TrustProxies`

Archivo: `app/Http/Middleware/TrustProxies.php`

Propiedades:

- `$proxies`: proxies confiables.
- `$headers`: conjunto de cabeceras `X-Forwarded-*` y AWS ELB.

### 7.8 `ValidateSignature`

Archivo: `app/Http/Middleware/ValidateSignature.php`

Propiedad:

- `$except`: lista vacia de query params ignorables en firmas.

### 7.9 `VerifyCsrfToken`

Archivo: `app/Http/Middleware/VerifyCsrfToken.php`

Propiedad:

- `$except`: vacia.

Funcionamiento:

- Todas las rutas web siguen protegidas por CSRF, salvo las que se agreguen manualmente aqui.

## 8. Rutas y funciones/closures

### 8.1 `routes/web.php`

Responsabilidad:

- Define toda la navegacion principal del sistema.

Funciones y rutas:

#### Closure de `/`

- Devuelve la vista `index`.

#### `Route::resource('ciclista', CiclistaController::class)`

- Crea las rutas CRUD de ciclistas.

#### `Route::resource('equipo', EquipoController::class)`

- Crea las rutas CRUD de equipos.

#### `Route::resource('participa', ParticipaController::class)`

- Crea las rutas CRUD de participaciones.

#### `Route::resource('prueba', PruebaController::class)`

- Crea las rutas CRUD de pruebas.

#### `Route::patch('participa/{id}/estado', ...)`

- Ruta especifica para alternar el estado de una participacion.

#### `Route::get('ganador', ...)`

- Lista los ganadores.

#### `Route::get('ganador/create', ...)`

- Muestra el formulario de asignacion del ganador.

#### `Route::post('ganador', ...)`

- Guarda o actualiza el ganador de una prueba.

### 8.2 `routes/api.php`

Contiene una closure:

#### `Route::middleware('auth:sanctum')->get('/user', function (Request $request) { ... })`

- Devuelve el usuario autenticado por API.
- No se usa en la logica principal del sistema de ciclismo.

### 8.3 `routes/channels.php`

Contiene una closure:

#### `Broadcast::channel('App.Models.User.{id}', function ($user, $id) { ... })`

- Autoriza escuchar un canal privado solo si el usuario autenticado coincide con el id del canal.

### 8.4 `routes/console.php`

Contiene un comando de consola por closure:

#### `Artisan::command('inspire', function () { ... })`

- Muestra una frase inspiradora usando `Inspiring::quote()`.

## 9. Vistas Blade

### 9.1 Layout principal

Archivo: `resources/views/layouts/app.blade.php`

Responsabilidad:

- Estructura comun de toda la aplicacion.
- Renderiza barra superior, navegacion, panel de temporada, mensajes flash y contenido del modulo.

Elementos clave:

- `@yield('title')`
- `@yield('eyebrow')`
- `@yield('page_title')`
- `@yield('content')`

Tambien muestra:

- mensajes `success`
- mensajes `error`
- errores de validacion

### 9.2 Vistas de `equipo`

- `equipo/index.blade.php`: tabla de equipos.
- `equipo/create.blade.php`: formulario de alta.
- `equipo/edit.blade.php`: formulario de edicion.
- `equipo/show.blade.php`: detalle del equipo y tabla de ciclistas asociados, mostrando:
  - nombre
  - nacionalidad
  - fecha inicio contrato
  - fecha fin contrato
  - estado del contrato
  - estado general

### 9.3 Vistas de `ciclista`

- `ciclista/index.blade.php`: tabla de ciclistas con columnas personales y contractuales.
- `ciclista/create.blade.php`: formulario de alta con equipo, nacionalidad y fechas del contrato.
- `ciclista/edit.blade.php`: formulario de edicion con mismos campos.
- `ciclista/show.blade.php`: ficha detallada del ciclista.

### 9.4 Vistas de `participa`

- `participa/index.blade.php`: lista con boton de habilitar/inhabilitar.
- `participa/create.blade.php`: formulario de alta.
- `participa/edit.blade.php`: formulario de edicion.
- `participa/show.blade.php`: ficha de la participacion.

### 9.5 Vistas de `prueba`

- `prueba/index.blade.php`: lista de pruebas.
- `prueba/create.blade.php`: alta de prueba.
- `prueba/edit.blade.php`: edicion de prueba.
- `prueba/show.blade.php`: detalle de prueba.

### 9.6 Vistas de `ganador`

- `ganador/index.blade.php`: lista de ganadores registrados.
- `ganador/create.blade.php`: formulario para seleccionar prueba, equipo y ciclista.

### 9.7 Vistas generales

- `index.blade.php`: portada principal con tarjetas de acceso a modulos.

## 10. Funciones Javascript y frontend

### 10.1 `resources/js/app.js`

Contenido:

- Importa `./bootstrap`.

Funcionamiento:

- Es el punto de entrada del bundle frontend de Vite.

### 10.2 `resources/js/bootstrap.js`

Funcionamiento:

- Importa `axios`.
- Asigna `window.axios = axios`.
- Define el header `X-Requested-With = XMLHttpRequest`.

### 10.3 Script en `resources/views/ganador/create.blade.php`

Este archivo contiene la unica funcion JS propia del proyecto actual.

#### `document.addEventListener('DOMContentLoaded', function () { ... })`

- Espera a que el DOM este cargado antes de manipular los selects.

Dentro de esa closure:

- Obtiene `equipoSelect`.
- Obtiene `ciclistaSelect`.
- Construye `allOptions` con todas las opciones de ciclistas.
- Recupera `oldValue` para mantener la seleccion tras un error de validacion.

#### `filtrarCiclistas()`

Funcionamiento:

1. Lee el equipo seleccionado.
2. Limpia el select de ciclistas.
3. Inserta un placeholder dinamico.
4. Filtra solo los ciclistas cuyo atributo `data-equipo` coincide con el equipo elegido.
5. Clona e inserta esas opciones.
6. Restaura el valor anterior si venia de `old(...)`.

Por que existe:

- Evita que el usuario vea o elija ciclistas de otro equipo en el formulario de ganador.

#### `equipoSelect.addEventListener('change', filtrarCiclistas)`

- Recalcula los ciclistas cada vez que cambia el equipo.

#### `filtrarCiclistas()` al final

- Ejecuta un filtrado inicial cuando la vista carga.

## 11. Validaciones funcionales del negocio

### 11.1 Evitar crear un ciclista sin equipo

Se aplica en `CiclistaController::store()` y `CiclistaController::update()`.

La regla es:

```php
'id_equipo' => [
    'required',
    Rule::exists('equipos', 'id_equipo')->where(fn ($query) => $query->where('estado', 'activo')),
]
```

Esto significa:

- El campo es obligatorio.
- El id debe existir realmente en la tabla `equipos`.
- El equipo debe estar activo.

Consecuencia:

- No se puede crear el registro sin equipo.
- No se puede enviar un valor manual inventado.
- No se puede asociar a un equipo inactivo.

### 11.2 Evitar contratos incoherentes en ciclistas

Se aplica con:

```php
'fecha_inicio_contrato' => 'required|date'
'fecha_fin_contrato' => 'required|date|after_or_equal:fecha_inicio_contrato'
```

Consecuencia:

- La fecha final no puede ser anterior a la fecha inicial.

### 11.3 Evitar participaciones con equipo o prueba inactiva

Se aplica en `ParticipaController::store()`:

- `id_equipo` solo acepta equipos activos.
- `id_prueba` solo acepta pruebas activas.

Consecuencia:

- No se registran participaciones de entidades fuera de servicio.

### 11.4 Permitir edicion de registros historicos

En `edit()` y `update()` de algunos controladores se usa una estrategia importante:

- Se cargan activos o el valor actual del registro.

Ejemplo conceptual:

- si un equipo esta inactivo pero ya esta asociado al registro, se permite mantenerlo en edicion.

Esto evita romper datos historicos.

### 11.5 Validar que el ganador pertenezca al equipo

Se aplica en `GanadorController::store()`.

Regla:

- el `id_ciclista` debe existir como ciclista activo
- y ademas tener `id_equipo = request.id_equipo`

Consecuencia:

- No se puede seleccionar un equipo A y un ciclista del equipo B.

### 11.6 Garantizar un solo ganador por prueba

Se aplica en dos niveles:

1. Base de datos:
   - `id_prueba` en `ganadores` es `unique()`.
2. Aplicacion:
   - `Ganador::updateOrCreate(...)`.

Consecuencia:

- Nunca se crean dos ganadores para la misma prueba.

### 11.7 Inactivacion en lugar de borrado

Se aplica en:

- `EquipoController::destroy()`
- `CiclistaController::destroy()`
- `ParticipaController::destroy()`
- `ParticipaController::toggleEstado()`

Funcionamiento:

- En vez de `delete()`, se cambia el campo `estado`.
- Esto conserva el historial del registro.

## 12. Relaciones entre modulos

Dependencias principales:

- `Nacionalidad` -> `Equipo`
- `Nacionalidad` -> `Ciclista`
- `Equipo` -> `Ciclista`
- `Equipo` -> `Participa`
- `Prueba` -> `Participa`
- `Prueba` -> `Ganador`
- `Equipo` -> `Ganador`
- `Ciclista` -> `Ganador`

Implicaciones de negocio:

- Para crear un ciclista, primero debe existir un equipo y una nacionalidad.
- Para crear una participacion, primero debe existir un equipo activo y una prueba activa.
- Para asignar un ganador, primero deben existir una prueba activa, un equipo activo y un ciclista activo de ese equipo.

## 13. Estado actual y notas tecnicas

### 13.1 Estado operativo principal

Los modulos activos y funcionales del sistema son:

- Equipos
- Ciclistas
- Participaciones
- Pruebas
- Ganadores
- Nacionalidades

### 13.2 Elementos fuera del flujo principal

Tras la limpieza realizada, no quedan modulos ni vistas residuales documentadas dentro del proyecto activo.

### 13.3 Resumen final del flujo de negocio

1. Se crean nacionalidades.
2. Se crean equipos asociados a una nacionalidad.
3. Se crean ciclistas asociados a un equipo activo, con nacionalidad y datos de contrato.
4. Se crean pruebas.
5. Se registran participaciones de equipos activos en pruebas activas.
6. Se asigna un ganador eligiendo una prueba activa, un equipo activo y un ciclista activo perteneciente a ese equipo.

Con esto, el sistema asegura consistencia basica de negocio desde formulario, controlador, Eloquent y base de datos.