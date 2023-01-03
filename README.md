-- Begin --

run chedule: php artisan schedule:run

-- End --

-- Begin -- 

** Create Model, Migrate, Seeder, Controller and View **

php artisan make:model Test -m
php artisan make:seed CreateTestSeeder
php artisan make:controller Admin/TestController --model=Test

php artisan make:viewadd Test
php artisan make:viewedit Test
php artisan make:viewindex Test
php artisan make:viewheader Test
php artisan make:viewsearch Test

php artisan migrate

-- End --
