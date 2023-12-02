<?php

namespace App\Models;

use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use App\Traits\UserTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use UserTrait;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use \Awobaz\Compoships\Compoships;
    use DeleteModelTrait;
    use StorageImageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // begin

    public function logoutAllDevices(){
        DB::table('sessions')->where('user_id', $this->id)->delete();
        $this->tokens()->delete();
    }

    public function textTimeOnline(){
        if (Cache::has('user-is-online-' . $this->id)){
            return "Online";
        }

        return $this->last_seen;
    }

    public function textStatusOnline(){
        if (Cache::has('user-is-online-' . $this->id)){
            return "Online";
        }

        return "Offline";
    }

    public static function htmlStatus($input)
    {
        if ($input == "Đang giữ chỗ") {
            return "<span style=\"display: flex;align-items: center;background-color: #fffcf9;padding: 5px;border-radius: 15px;color: #ffc500;\"><a class='ms-1 me-1'>{$input}</a><i class=\"fa-solid fa-rotate\"></i></span>";
        } else if ($input == "Thành công") {
            return "<span style=\"display: flex;align-items: center;background-color: #d0ffef;padding: 5px;border-radius: 15px;color: #03a900;\"><a class='ms-1 me-1'>{$input}</a><i class=\"fa-solid fa-rotate\"></i></span>";
        } else {
            return "<span style=\"display: flex;align-items: center;background-color: #ffdbdb;padding: 5px;border-radius: 15px;color: #ff0000;\"><a class='ms-1 me-1'>{$input}</a><i class=\"fa-solid fa-rotate\"></i></span>";
        }
    }

    public function exchangePointToAmount($point)
    {

        $point = Formatter::getOnlyNumber($point);

        $item = Setting::first();

        $pointSetting = $item->point;
        $amountSetting = $item->amount;

        $exchanged = round(($point / $pointSetting) * $amountSetting);

        $this->addPoint(-$point, "Đổi " . $point . " điểm thành " . $exchanged . " vnđ");

        $this->addAmount($exchanged, "Đổi " . $point . " điểm thành " . $exchanged . " vnđ");

    }

    public function addPoint($point, $description)
    {
        $point = Formatter::getOnlyNumber($point);

        UserPoint::create([
            'user_id' => $this->id,
            'point' => $point,
            'description' => $description,
        ]);

        $this->increment('point', $point);
    }

    public function addAmount($amount, $description)
    {

        $amount = Formatter::getOnlyNumber($amount);
        $amountNow = $this->amount + ($amount);

        UserTransaction::create([
            'user_id' => $this->id,
            'amount' => $amount,
            'description' => $description,
            'amount_now' => $amountNow,
        ]);

        $this->increment('amount', $amount);
    }

    // số lượng người giới thiệu
    public function numberInvited()
    {
        return User::where('referral_id', $this->id)->count();
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referral_id', 'id');
    }

    public function referralIDs()
    {
        return User::where('referral_id', $this->id)->pluck('id');
    }

    public function status()
    {
        return $this->hasOne(UserStatus::class, 'id', 'user_status_id');
    }

    public function userType(){
        return $this->hasOne(UserType::class,'id','user_type_id');
    }

    public function membership()
    {

        $from = Carbon::parse($this->created_at)->toDateString();
        $to = Carbon::parse($this->created_at)->addYear()->toDateString();

        $numberTicketSuccess = 0;

        $memberships = Membership::orderBy('require_number_ticket', 'DESC')->get();

        foreach ($memberships as $membership) {
            if ($numberTicketSuccess >= $membership->require_number_ticket) {
                return $membership;
            }
        }

        return [
            "id" => 0,
            "name" => "Bạn chưa có hạng",
            "require_number_ticket" => 0,
            "created_at" => "2023-08-04T08:20:22.000000Z",
            "updated_at" => "2023-10-21T02:52:55.000000Z",
            "image_path_avatar" => "/assets/multiple/1/36/100x100/LOTcD7WmeqBiYMG0Tbtx.png",
            "path_images" => [
                [
                    "id" => 36,
                    "uuid" => "75b1309d-d783-492f-b970-075ce49a3faf",
                    "image_path" => "/assets/multiple/1/36/original/LOTcD7WmeqBiYMG0Tbtx.png",
                    "image_name" => "rank-dong-doan.png",
                    "table" => "memberships",
                    "relate_id" => 1,
                    "index" => 0,
                    "status_image_id" => 0,
                    "created_at" => "2023-08-04T08:28:33.000000Z",
                    "updated_at" => "2023-08-04T08:28:34.000000Z"
                ]
            ]
        ];
    }

    public function city()
    {
        return $this->belongsTo(RegisterCity::class);
    }

    public function district()
    {
        return $this->belongsTo(RegisterDistrict::class);
    }

    public function ward()
    {
        return $this->belongsTo(RegisterWard::class);
    }

    // end

    public function getTableName()
    {
        return Helper::getTableName($this);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['image_path_avatar'] = $this->avatar();
        $array['path_images'] = $this->images;
        $array['user_type'] = $this->userType;
        $array['status'] = $this->status;
        $array['membership'] = $this->membership();
        $array['city'] = $this->city;
        $array['district'] = $this->district;
        $array['ward'] = $this->ward;
        $array['text_status_online'] = $this->textStatusOnline();
        return $array;
    }

    public function avatar($size = "100x100"){
        $image = $this->image;
        if (!empty($image)){
            return Formatter::getThumbnailImage($image->image_path,$size);
        }

        return config('_my_config.default_avatar');
    }

    public function image(){
        return $this->hasOne(SingleImage::class,'relate_id','id')->where('table' , $this->getTable());
    }

    public function images(){
        return $this->hasMany(Image::class,'relate_id','id')->where('table' , $this->getTable())->orderBy('index');
    }

    public function gender()
    {
        return $this->belongsTo(GenderUser::class);
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function checkPermissionAccess($permissionCheck)
    {
        if (optional(auth()->user())->is_admin == 2) return true;

        $roles = optional(auth()->user())->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            if ($permissions->contains('key_code', $permissionCheck)) {
                return true;
            }
        }
        return false;
    }

    public function isAdmin(){
        return auth()->check() && optional(auth()->user())->is_admin == 2;
    }

    public function isEmployee(){
        return auth()->check() && optional(auth()->user())->is_admin != 0;
    }

    public function searchByQuery($request, $queries = [])
    {
        return Helper::searchByQuery($this, $request, $queries);
    }

    public function storeByQuery($request)
    {
        $dataInsert = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_type_id' => $request->user_type_id ?? 0,
            'date_of_birth' => $request->date_of_birth,
            'gender_id' => $request->gender_id ?? 1,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ];

        if ($this->isAdmin()){
            $dataInsert['role_id'] = $request->role_id ?? 0;
            $dataInsert['is_admin'] = $request->is_admin ?? 0;
        }

        $item = Helper::storeByQuery($this, $request, $dataInsert);

        if (!empty($request->is_admin && $request->is_admin == 1 && isset($request->role_ids))){
            $item->roles()->attach($request->role_ids);
        }

        return $this->findById($item->id);
    }

    public function updateByQuery($request, $id)
    {
        $dataUpdate = [
            'name' => $request->name,
            'user_type_id' => $request->user_type_id ?? 0,
        ];

        if (!empty($request->date_of_birth)){
            $dataUpdate['date_of_birth'] = $request->date_of_birth;
        }

        if (!empty($request->email)){
            $dataUpdate['email'] = $request->email;
        }

        if (!empty($request->phone)){
            $dataUpdate['phone'] = $request->phone;
        }

        if (!empty($request->gender_id)){
            $dataUpdate['gender_id'] = $request->gender_id;
        }

        if (!empty($request->password)) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        $item = Helper::updateByQuery($this, $request, $id, $dataUpdate);

        if ($item->is_admin != 0 && isset($request->role_ids)){
            $item->roles()->sync($request->role_ids);
        }

        return $item;
    }

    public function deleteByQuery($request, $id, $forceDelete = false)
    {
        return Helper::deleteByQuery($this, $request, $id, $forceDelete);
    }

    public function deleteManyByIds($request, $forceDelete = false)
    {
        return Helper::deleteManyByIds($this, $request, $forceDelete);
    }

    public function findById($id)
    {
        $item = $this->find($id);
        $item->gender;
        $item->role;
        return $item;
    }
}
