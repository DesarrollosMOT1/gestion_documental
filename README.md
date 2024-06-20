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

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Guía Completa para Configurar y Utilizar el proyecto

Este documento proporciona una guía completa para configurar y utilizar el proyecto, con los comandos necesarios para clonar el repositorio, configurar el entorno, manejar migraciones, generar código con Artisan y utilizar algunas librerías comunes.

## Clonación del Repositorio

Primero, clona el repositorio de tu proyecto Laravel desde GitHub:

git clone https://github.com/DesarrollosMOT1/gestion_documental.git

## Configuración del Entorno
### 1. Instalar Dependencias de Composer
Asegúrate de tener Composer instalado. Luego, ejecuta el siguiente comando para instalar las dependencias de PHP:<br><br>
composer install
### 2. Configurar el Archivo .env
Copia el archivo de configuración de ejemplo y renómbralo a .env
### 3. Generar la Clave de la Aplicación
Laravel necesita una clave única para la aplicación. Genera esta clave con el siguiente comando:<br><br>
php artisan key:generate
### 4. Configurar la Base de Datos
Edita el archivo .env y configura las variables de entorno para la base de datos:
<br><br>
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

### 5. Migrar las Tablas de la Base de Datos
Ejecuta las migraciones para crear las tablas necesarias en tu base de datos: <br><br>
php artisan migrate
## Instalación y Actualización de NPM
Asegúrate de tener Node.js y npm instalados.
### 1. Instalar Dependencias de NPM
Instala las dependencias de npm especificadas en el archivo package.json: <br><br>
npm install
### 2. Compilar Recursos
Compila los recursos del frontend: <br><br>
npm run dev
<br><hr>
Para una compilación optimizada para producción, usa:<br><br>
npm run build
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
## Factories
### Crear una nueva factory: <br><br>
php artisan make:factory NombreFactory
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
### Limpiar la cache de la vista: <br><br>
php artisan view:clear
### Servidor de Desarrollo
### Iniciar el servidor de desarrollo: <br><br>
php artisan serve
