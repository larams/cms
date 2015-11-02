# Larams

Installation: 

1. composer create-project talandis/larams --stability dev --repository-url 'http://testit.lt/repo/web/' {{project_folder}}
2. composer update
3. Enter DB logins in .env file
4. php artisan migrate
5. php artisan db:seed
6. Go to /admin link and try logging in with "dev" user and standard password