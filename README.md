# Sistema de Registro de Primera Comunión — Laravel 12

Aplicación web basada en los documentos de Ingeniería de Software del TESVB. Requiere PHP 8.2+, Composer, MySQL 8+ o MariaDB, y extensiones PHP habituales de Laravel (pdo_mysql, mbstring, openssl, tokenizer, xml, fileinfo).

## Instalación

1. Extrae el ZIP y abre una terminal dentro de la carpeta `primera_comunion_laravel`.
2. Crea la base de datos ejecutando `database/crear_base.sql` en MySQL o phpMyAdmin.
3. Ejecuta `composer install` (necesita conexión a internet la primera vez).
4. Copia `.env.example` como `.env` y ajusta `DB_USERNAME` y `DB_PASSWORD`.
5. Ejecuta `php artisan key:generate`.
6. Ejecuta `php artisan migrate --seed`.
7. Ejecuta `php artisan serve` y visita `http://127.0.0.1:8000`.

**Acceso inicial:** `admin@comunion.local` / `Admin12345!`. Cambia la contraseña del administrador antes de usar información real (puedes cambiarla desde Tinker o ampliar el módulo de usuarios). Nunca publiques `.env`.

## Funciones

- Autenticación con sesión, CSRF y contraseñas con hash.
- Roles: administrador, encargado, coordinador, catequista. El catequista solo puede consultar aspirantes; el administrador gestiona documentos y usuarios.
- Aspirantes: alta, consulta, edición, eliminación, búsqueda y filtro por estado.
- Tutor: nombre, parentesco, teléfono, domicilio.
- Documentos: catálogo, entrega y pendientes; bloqueo de confirmación si faltan documentos obligatorios.
- Grupos con asignación de catequista.
- Detección de duplicados por nombre exacto + fecha de nacimiento.
- Exportación CSV de aspirantes.

## Notas de alcance

Esta entrega usa **Laravel web** en lugar de la propuesta original Java Swing, por petición del usuario. Los documentos no definen una política exacta de roles, documentos obligatorios, reglas de duplicidad ni objetivos numéricos de calidad; se implementaron valores iniciales configurables. No se incluye `vendor/` ni `composer.lock`: `composer install` obtiene dependencias. La instalación requiere un entorno Laravel/MySQL; no se ha ejecutado una prueba de integración de extremo a extremo en este entorno.

## Seguridad

La cuenta inicial es únicamente para instalación local. No usar datos reales de menores hasta configurar HTTPS, copias de seguridad, políticas de privacidad, gestión segura de credenciales y permisos de acceso adecuados. La exportación CSV está disponible para usuarios autenticados y debe restringirse según la política de la parroquia.
