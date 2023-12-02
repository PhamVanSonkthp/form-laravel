-- Begin --
* Chạy cron mỗi phút để gửi email và thông báo

run chedule: php artisan schedule:run
-- End --

-- Begin --
** Create Model, Migration, Seeder, Controller, Policy and View **

* Chạy file batch "mcv.bat"

php artisan make:model Test -m
php artisan make:seed CreateTestSeeder
php artisan make:controller Admin/TestController --model=Test

php artisan make:viewadd Test
php artisan make:viewedit Test
php artisan make:viewindex Test
php artisan make:viewheader Test
php artisan make:viewsearch Test
php artisan make:_policy Test

* Thêm quyền vào file "config/permissions"
* Thêm check permission vào file "app/Services/PermissionGateAndPolicyAccess"
* Thêm route và middleware "routes/administrator/index"
* Thêm menu vào view "resources/views/administrator/components/slidebars.blade"
* Thêm các trường bảng migration
* Sau dó chạy

php artisan migrate
php artisan db:seed --class=CreatePermissionSeeder
-- End --

-- Begin --
* Đối với App có sử dụng thông báo, cần đăng ký topic "app" khi vào app

* Thư viện Laravel-attribute lỗi, thay đổi ở đây "vendor/rinvex/laravel-attributes/src/Events"  
&& ($values = \Illuminate\Support\Collection::wrap($entity->getRelationValue($relation))) && ! $values->isEmpty()) {

* Thư viện Laravel-File-Manager lỗi, thay đổi ở đây "vendor/unisharp/laravel-filemanager/src/Lfm.php"
$rInput = [];
if ($this->isRunningOnWindows()) {
    // $input = iconv('UTF-8', mb_detect_encoding($input), $input);

    if (is_array($input)) {
        foreach ($input as $k => $i) {
            $rInput[] = iconv('UTF-8', mb_detect_encoding($i), $i);
        }
    } else {
        $rInput = $input;
    }
} else {
    $rInput = $input;
}
return $rInput;
// return $input;

* Thư viện Laravel-File-Manager lỗi, thay đổi ở đây "vendor/unisharp/laravel-filemanager/src/Controllers/DeleteController.php"
//                    array_push($errors, parent::error('delete-folder'));
//                    continue;

-- End --

need doing
bình luận facebook
