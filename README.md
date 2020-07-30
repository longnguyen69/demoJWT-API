Setup web todo app:
- clone project: git clone https://github.com/longnguyen69/demoJWT-API.git
- update composer: composer update
- create file .env:  cp .env.example .env
- edit file ".env" as username and password MySql
- create key: php artisan key:generate
- create database as name: todoapp
- run migrations: php artisan migrate
=> run: php artisan serve
