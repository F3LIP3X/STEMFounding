<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# STEMFounding

## Sobre STEMFounding

STEMFounding es una plataforma desarrollada con Laravel que tiene como objetivo fomentar proyectos de ciencia, tecnología, ingeniería y matemáticas (STEM). Ofrecemos herramientas para gestionar iniciativas, conectar con patrocinadores y asegurar la financiación de proyectos innovadores.

## Características

- [Sistema de autenticación seguro](https://laravel.com/docs/authentication).
- [Gestión avanzada de usuarios y roles](https://laravel.com/docs/authorization).
- Integración con pasarelas de pago para financiación de proyectos.
- Sistema de publicación y administración de proyectos.
- [API REST segura y escalable](https://laravel.com/docs/passport).
- Notificaciones en tiempo real con [Laravel Echo](https://laravel.com/docs/broadcasting).

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tuusuario/stemfounding.git
   cd stemfounding
   ```
2. Instala las dependencias:
   ```bash
   composer install
   ```
3. Configura el entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configura la base de datos en el archivo `.env` y luego ejecuta:
   ```bash
   php artisan migrate --seed
   ```
5. Inicia el servidor:
   ```bash
   php artisan serve
   ```

## Aprender Laravel

Para aprender más sobre Laravel, consulta la [documentación oficial](https://laravel.com/docs) o prueba el [Laravel Bootcamp](https://bootcamp.laravel.com).

## Contribuir

Si deseas contribuir al desarrollo de STEMFounding, revisa nuestras pautas en `CONTRIBUTING.md` y haz un Pull Request.

## Seguridad

Si encuentras una vulnerabilidad de seguridad, repórtala a nuestro equipo enviando un correo a [seguridad@stemfounding.com](mailto:seguridad@stemfounding.com).

## Licencia

STEMFounding es un software de código abierto licenciado bajo la [MIT License](https://opensource.org/licenses/MIT).
