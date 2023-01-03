echo Ten bang cua ban la gi?
Set /p table=
echo OKAY! dang tao du lieu %table% ...

php artisan make:model Test -m
php artisan make:seed CreateTestSeeder
php artisan make:controller Admin/TestController --model=Test

php artisan make:viewadd Test
php artisan make:viewedit Test
php artisan make:viewindex Test
php artisan make:viewheader Test
php artisan make:viewsearch Test

echo DONE!
echo ---PhamSon---