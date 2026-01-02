# Laravel Community Platform

Plataforma de comunidad desarrollada con Laravel 12, Livewire y Flux para gestión de preguntas, respuestas, blogs y comentarios.

## Descripción

Sistema de gestión de contenido comunitario que permite a los usuarios:
- Publicar y responder preguntas organizadas por categorías
- Crear y compartir artículos de blog
- Comentar en publicaciones
- Sistema de "hearts" (me gusta)
- Autenticación completa con verificación de email y 2FA

## Stack Tecnológico

### Backend
- **Laravel 12** - Framework PHP
- **Livewire 3** + **Flux** - Componentes reactivos server-side
- **Laravel Fortify** - Autenticación y seguridad
- **Eloquent ORM** - Gestión de base de datos

### Frontend
- **Tailwind CSS 4** - Estilos utility-first
- **Alpine.js** - Interactividad ligera
- **Vite** - Build tool y hot reload

### Base de Datos
- **SQLite** (desarrollo)
- Preparado para MySQL/PostgreSQL (producción)

## Modelos del Sistema

### Estructura de Datos

```
Users (usuarios autenticados)
  └── Questions (preguntas)
  │     └── Answers (respuestas)
  │     └── Comments (comentarios)
  │     └── Hearts (me gusta)
  │
  └── Blogs (artículos)
        └── Comments (comentarios)
        └── Hearts (me gusta)

Categories (clasificación de contenido)
  └── Questions
  └── Blogs
```

### Modelos Disponibles

- **User** - Usuarios con autenticación 2FA
- **Category** - Categorías para organizar contenido
- **Question** - Preguntas de la comunidad
- **Answer** - Respuestas a preguntas
- **Blog** - Artículos/posts
- **Comment** - Comentarios en preguntas/blogs
- **Heart** - Sistema de reacciones (likes)

## Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM o Yarn
- SQLite (incluido) o MySQL/PostgreSQL

## Instalación

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd web-laravel
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Configurar el entorno

```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar base de datos

El proyecto está configurado para SQLite por defecto. El archivo de base de datos se encuentra en:
```
database/database.sqlite
```

Para usar MySQL/PostgreSQL, edita el archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Ejecutar migraciones

```bash
php artisan migrate
```

### 6. Instalar dependencias de Node.js

```bash
npm install
```

### 7. Compilar assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

## Desarrollo

### Servidor de desarrollo

Opción 1: Servidor Laravel con Vite
```bash
composer run dev
```
Este comando ejecuta concurrentemente:
- Servidor Laravel (`php artisan serve`)
- Worker de colas (`php artisan queue:listen`)
- Vite dev server con HMR

Opción 2: Comandos separados
```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Vite (hot reload)
npm run dev
```

La aplicación estará disponible en:
- Laravel: `http://localhost:8000`
- Vite HMR: `http://web-laravel.test`

### Comandos Artisan Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Crear modelo con migración y factory
php artisan make:model NombreModelo -mf

# Crear componente Livewire
php artisan make:livewire NombreComponente

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Ver logs en tiempo real
php artisan pail

# Ejecutar tests
php artisan test
```

### Seeders y Factories

El proyecto incluye factories para generar datos de prueba:

```bash
# Ejecutar seeders
php artisan db:seed

# Generar datos específicos con tinker
php artisan tinker
>>> User::factory()->count(10)->create()
>>> Question::factory()->count(20)->create()
>>> Blog::factory()->count(15)->create()
```

## Estructura del Proyecto

```
web-laravel/
├── app/
│   ├── Actions/              # Lógica reutilizable
│   ├── Http/
│   │   └── Controllers/      # Controladores HTTP
│   ├── Livewire/            # Componentes Livewire
│   │   ├── Actions/
│   │   └── Settings/        # Componentes de configuración
│   ├── Models/              # Modelos Eloquent
│   └── Providers/           # Service providers
│
├── database/
│   ├── factories/           # Factories para testing
│   ├── migrations/          # Migraciones de BD
│   └── seeders/            # Datos de prueba
│
├── resources/
│   ├── css/                # Estilos (Tailwind)
│   ├── js/                 # JavaScript (Alpine.js)
│   └── views/              # Templates Blade
│       └── livewire/       # Vistas Livewire
│
├── routes/
│   ├── web.php             # Rutas web (con sesión)
│   ├── api.php             # Rutas API (stateless)
│   └── console.php         # Comandos artisan
│
├── public/                 # Archivos públicos (punto de entrada)
├── storage/                # Archivos generados (logs, cache)
├── tests/                  # Tests PHPUnit
└── vendor/                 # Dependencias Composer
```

## Características de Seguridad

- Autenticación con Laravel Fortify
- Verificación de email
- Autenticación de dos factores (2FA)
- Protección CSRF
- Validación de formularios server-side
- Rate limiting en rutas API
- Contraseñas hasheadas con bcrypt

## Testing

```bash
# Ejecutar todos los tests
php artisan test

# Tests específicos
php artisan test --filter=NombreTest

# Con coverage
php artisan test --coverage
```

## Despliegue

### Preparar para producción

```bash
# Optimizar autoloader
composer install --optimize-autoloader --no-dev

# Cachear configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Compilar assets
npm run build
```

### Variables de entorno importantes

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

# Base de datos de producción
DB_CONNECTION=mysql
DB_HOST=tu-host
DB_DATABASE=tu-base-datos

# Mail (configurar para notificaciones)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
```

## Rutas Principales

### Públicas
- `/` - Página de inicio
- `/login` - Iniciar sesión
- `/register` - Registro de usuario

### Autenticadas
- `/dashboard` - Panel de usuario
- `/settings/profile` - Editar perfil
- `/settings/password` - Cambiar contraseña
- `/settings/appearance` - Configuración de apariencia
- `/settings/two-factor` - Autenticación 2FA

## Contribuir

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am "Add nueva funcionalidad"`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## Convenciones de Código

- Seguir PSR-12 para código PHP
- Usar Laravel Pint para formatear código: `./vendor/bin/pint`
- Nombres de variables en camelCase
- Nombres de clases en PascalCase
- Nombres de métodos descriptivos

## Solución de Problemas

### Error de migraciones

```bash
# Rollback y volver a migrar
php artisan migrate:fresh

# Con seeders
php artisan migrate:fresh --seed
```

### Error de permisos en storage

```bash
chmod -R 775 storage bootstrap/cache
```

### Vite no actualiza cambios

```bash
# Limpiar cache de Vite
rm -rf node_modules/.vite
npm run dev
```

## Licencia

Este proyecto está bajo la licencia MIT.

## Soporte

Para reportar bugs o solicitar funcionalidades, abre un issue en el repositorio.

---

**Desarrollado con Laravel 12 + Livewire + Flux**
