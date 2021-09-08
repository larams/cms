# Larams - Content Management System for Laravel

## Installation

There are two ways to create new project. If you just create new git repository start with clean installation. If you have cloned from git repo with existing sources continue with the second method.

### 1. Clean installation

You might need to add `COMPOSER_MEMORY_LIMIT=-1` before all composer commands

- `composer create-project --prefer-dist laravel/laravel {{project_folder}}`
- `composer require larams/cms`
- Enter DB logins in `.env` file (if file is missing create one from `.env.example`)
- Delete `docker-compose.yml` file (it is used for Laravel Sail)
- Delete migrations from `database/migrations` from year 2014
- `php artisan vendor:publish` and select `[10] ....\LaramsServiceProvider`
- `composer dump-autoload`
- Modify `docker/httpd/vhosts.conf` and change `ServerName` variables to match your `XDEBUG_SERVER_NAME` variable in .env file
- If you are using docker on remote server, follow guide below
- Create empty database with Sequel Pro or any other tool
- `php artisan migrate`
- `php artisan db:seed --class=StructureTypeSeeder`
- `php artisan db:seed --class=PermissionsTableSeeder`
- `php artisan db:seed --class=UsersTableSeeder`
- `php artisan db:seed --class=StructureItemSeeder`
- If you need admin interface: Go to `public` folder, create `bower.json` with content below and run `bower install`
- If you are using standard cms:
Add cms middleware classes for "web" in `app/Http/Kernel.php` 
`\Larams\Cms\Http\Middleware\LocaleDetection::class,
\Larams\Cms\Http\Middleware\LayoutBuilder::class`
- Add middlewares to routeMiddleware 
`'auth.user' => \App\Http\Middleware\Authenticate::class, 
'auth.admin' => \App\Http\Middleware\Authenticate::class,
'auth.custom' => \Larams\Cms\Http\Middleware\AuthenticateApi::class,`
- Change user model to `\Larams\Cms\Model\User::class` in `config/auth.php`
- Go to /admin link and try logging in with "dev" user and generated password

- `php artisan passport:install` 

- Change `config/auth.php` guards.api.driver to `passport`


### Docker setup on remote server

-  Delete `storage/..` and `docker/..` folders in `.rsync-exclude`
-  Run `autosync {project_folder}`
-  Run `xdebug`
-  Enter project folder `/srv/www/{project_folder}`
-  Run `docker-compose up -d`
-  Restore `.rsync-exclude` to its previous state
-  Run `docker exec -it {container_name} bash`
-  Return to previous list where you left off and continue with next commands in docker

### 2. When cloning git repository

- Clone files
- Enter project folder and run `composer install --no-scripts`
- Enter DB logins in `.env` file (if file is missing create one from `.env.example`)
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed --class=StructureTypeSeeder`
- `php artisan db:seed --class=PermissionsTableSeeder`
- `php artisan db:seed --class=UsersTableSeeder`
- `php artisan db:seed --class=StructureItemSeeder`
- Go to root project folder and run `npm install`
- Go to sample.domain.com/admin link and try logging in with "dev" user and standard password

## Additional .env variables

```
CONTAINER_NAME_API=server-api
CONTAINER_NAME_DB=server-db

MYSQL_CONTAINER_PORT=3306
MYSQL_ROOT_PASSWORD=

XDEBUG_HOST=docker.for.mac.localhost  # Used for mac
XDEBUG_HOST=172.17.0.1   # Used for docker in remote server
XDEBUG_SERVER_NAME=api.dev.domain.lt
```

## Usage

- Create `resources/views/index.blade.php` for title page
- Create `resources/views/types/text.blade.php` for each content type you need
- You may use app/Providers/LayoutServiceProvider.php for common stuff that is used in layout

## Sass

- `webpack.mix.js` change `postCss` to `sass`
- `npm i sass-loader --save`
- `npm i sass --save` 


## Bower.json

```
{
  "name": "bower_components",
  "authors": [
    "Tomas Talandis <tomas@talandis.lt>"
  ],
  "description": "",
  "main": "",
  "moduleType": [],
  "license": "MIT",
  "homepage": "",
  "ignore": [
    "**/.*",
    "node_modules",
    "bower_components",
    "test",
    "tests"
  ],
  "dependencies": {
    "bootstrap": "~3.3.5",
    "bootstrap-datepicker": "~1.5.0",
    "ckeditor": "~4.5.4",
    "dropzone": "~4.2.0",
    "jquery": "~2.1.4",
    "jquery-ui": "~1.11.4",
    "jstree": "~3.2.1",
    "slick-carousel": "^1.8.1",
    "chosen": "^1.8.7"
  }
}

```
