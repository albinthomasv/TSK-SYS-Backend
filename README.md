# Laravel Project Setup Guide

## Prerequisites
Ensure you have the following installed:
- PHP 8.3
- Composer
- MySQL
- Laravel 11

## Installation & Setup

### 1. Clone the Repository
```sh
git clone https://github.com/your-repo/your-project.git
cd your-project
```

### 2. Install Dependencies
```sh
composer update
```

### 3. Configure Environment Variables
Rename `.env.example` to `.env` and update the following variables:

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:zRK+rq0slPRDR4xmdGyrQcNIXNYBXMs0Yon45EhZxSo=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=haatch-sys
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

JWT_SECRET=0M6DRGdgv3IP2SIq3sFFK8pwYaWbIRC80TnSo2Sb8gmOhyK8y6gRCFHZwobRx6yr
JWT_ALGO=HS256
```

### 4. Run Database Migrations
```sh
php artisan migrate
```

### 5. Create a Super User
```sh
php artisan create:superuser {name} {email} {password}
```
Replace `{name}`, `{email}`, and `{password}` with actual values.

### 6. Run Laravel Development Server
```sh
php artisan serve
```

## Additional Commands
- To generate a new application key:
  ```sh
  php artisan key:generate
  ```
- To clear cache:
  ```sh
  php artisan cache:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```

## Usage
Once the server is running, open your browser and navigate to:
```
http://localhost:8000
```

Enjoy your Laravel application!

