<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Guía Completa para Configurar y Utilizar el proyecto

Este documento proporciona una guía completa para configurar y utilizar el proyecto, con los comandos necesarios para clonar el repositorio, configurar el entorno, manejar migraciones, generar código con Artisan y utilizar algunas librerías comunes.

## Clonación del Repositorio

Primero, clona el repositorio de tu proyecto Laravel desde GitHub:

git clone https://github.com/DesarrollosMOT1/gestion_documental.git

### 0. Habilitar la extensión GD y ZIP en PHP
En C:\xampp\php\php.ini Busca estas líneas y quitar el ";"
;extension=gd 
; extension=zip

## Configuración del Entorno
### 1. Instalar Dependencias de Composer
Asegúrate de tener Composer instalado. Luego, ejecuta el siguiente comando para instalar las dependencias de PHP:<br><br>
composer install
### 2. Configurar el Archivo .env
Copia el archivo de configuración de ejemplo y renómbralo a .env
### 3. Generar la Clave de la Aplicación
Laravel necesita una clave única para la aplicación. Genera esta clave con el siguiente comando:<br><br>
php artisan key:generate
### 4. Configurar environment
En el archivo .env modifica lo siguiente:
<br><br>
Nombre de la app:
<br>
APP_NAME=GestionDocumental
<br>

Zona Horaria:
<br>
APP_TIMEZONE=America/Bogota

Idioma:
<br>
APP_LOCALE=es
<br>
APP_FALLBACK_LOCALE=es
<br>
APP_FAKER_LOCALE=es_ES
<br>

Base de datos:
<br>
DB_CONNECTION=mysql
<br>
DB_HOST=127.0.0.1
<br>
DB_PORT=3306
<br>
DB_DATABASE=gestion_documental
<br>
DB_USERNAME=root
<br>
DB_PASSWORD=

Configuracion de correo:
<br>
MAIL_MAILER=smtp
<br>
MAIL_HOST=smtp.gmail.com
<br>
MAIL_PORT=587
<br>
MAIL_USERNAME=sistemasmaestri@gmail.com
<br>
MAIL_PASSWORD=ugtdrarcnbgsxnbu
<br>
MAIL_ENCRYPTION=tls
<br>
MAIL_FROM_ADDRESS=sistemasmaestri@gmail.com
<br>
MAIL_FROM_NAME=GestionDocumental
<br>

### 5. Migrar las Tablas de la Base de Datos
Ejecuta las migraciones para crear las tablas necesarias en tu base de datos: <br><br>
php artisan migrate
## Instalación y Actualización de NPM
Asegúrate de tener Node.js y npm instalados.
### 1. Instalar Dependencias de NPM
Instala las dependencias de npm especificadas en el archivo package.json: <br><br>
npm install
### 2. Compilar Recursos
Para una compilación optimizada para producción, usa:<br><br>
npm run build
<br><hr>
Compila los recursos del frontend en desarrollo: <br><br>
npm run dev
<br>
## Comandos de Migraciones de Base de Datos
### Migraciones
Crear una nueva migración:<br><br>
php artisan make:migration create_nombre_tabla_table
### Ejecutar todas las migraciones pendientes:
php artisan migrate
### Otras Operaciones con Migraciones
Retroceder la última migración:<br><br>
php artisan migrate:rollback <br><hr>
Reejecutar todas las migraciones:<br><br>
php artisan migrate:refresh <br><hr>
Eliminar todas las tablas y migrar desde cero: <br><br>
php artisan migrate:fresh
### Ejecutar migraciones específicas: <br><br>
php artisan migrate --path=/database/migrations/nombre_archivo_migracion.php
## Generación de Código con Artisan
## Controladores
### Crear un nuevo controlador: <br><br>
php artisan make:controller NombreControlador
## Modelos
### Crear un nuevo modelo: <br><br>
php artisan make:model NombreModelo
## Seeders
### Crear un nuevo seeder: <br><br>
php artisan make:seeder NombreSeeder
### Ejecutar seeders: <br><br>
php artisan db:seed
### Ejecutar un seeder específico: <br><br>
php artisan db:seed --class=NombreSeeder
### Crear Trait: <br><br>
php artisan make:trait NombreTrait
### Crear componente laravel: <br><br>
php artisan make:component NombreComponent  
## Factories
### Crear una nueva factory: <br><br>
php artisan make:factory NombreFactory
### Crear una nueva politica: <br><br>
php artisan make:policy NombrePolicy
## Requests
### Crear una nueva request: <br><br>
php artisan make:request NombreRequest
### Generación de CRUD con Artisan
Usando el paquete crud-generator, puedes generar rápidamente un CRUD completo, para generar un CRUD para un modelo (asegúrate de tener las tablas migradas): <br><br>
php artisan make:crud nombre_tabla
## Importación y Exportación con Laravel Excel
### Crear una Clase de Importación <br><br>
php artisan make:import NombreModeloImport --model=NombreModelo
### Crear una Clase de Exportación <br><br>
php artisan make:export NombreModeloExport --model=NombreModelo <br>
## Otros Comandos Útiles de Artisan
## Limpiar Cache
### Limpiar la cache de configuración: <br><br>
php artisan config:cache
### Limpiar la cache de la ruta: <br><br>
php artisan route:cache
### Lista de rutas: <br><br>
php artisan route:list
### Limpiar la cache de la vista: <br><br>
php artisan view:clear
### herramienta útil para mantener tu aplicación Laravel actualizada y con un buen rendimiento
php artisan optimize:clear
### Servidor de Desarrollo
### Iniciar el servidor de desarrollo: <br><br>
php artisan serve
### Iniciar el servidor de desarrollo en la red local por medio del puerto IPv4: <br><br>
php artisan serve --host=192.168.0.0 --port=8000     
