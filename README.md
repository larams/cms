# Larams

Installation: 

- `composer create-project larams/larams --stability dev --repository-url 'http://testit.lt/repo/web/' {{project_folder}}`
- Enter project folder and run `composer update`
- Enter DB logins in `.env` file
- Uncomment providers in `config/app.php` (somewhere around line 150) 
- `php artisan vendor:publish`
- `composer dump-autoload` 
- `php artisan migrate`
- `php artisan db:seed --class=StructureItemSeeder`
- `php artisan db:seed --class=StructureTypeSeeder`
- `php artisan db:seed --class=UsersTableSeeder`
- Go to `public` folder and run `bower install`
- Go to /admin link and try logging in with "dev" user and standard password


Usage:

- Create `resources/views/index.blade.php` for title page
- Create `resources/views/types/text.blade.php` for each content type you need