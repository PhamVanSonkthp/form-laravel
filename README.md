-- Begin --

run chedule: php artisan schedule:run

* Chạy cron mỗi phút để gửi email và thông báo

-- End --

-- Begin -- 

** Create Model, Migration, Seeder, Controller, Policy and View **

php artisan make:model Test -m
php artisan make:seed CreateTestSeeder
php artisan make:controller Admin/TestController --model=Test

php artisan make:viewadd Test
php artisan make:viewedit Test
php artisan make:viewindex Test
php artisan make:viewheader Test
php artisan make:viewsearch Test

php artisan make:_policy Test

php artisan migrate

* Chạy file batch "mcv.bat"
* Thêm permission vào file "config/permissions"
* Thêm check permession vào file "Services/PermissionGateAndPolicyAccess"
* Thêm route và middleware "routes/administrator/index"

-- End --
