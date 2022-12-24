<?php

namespace App\Models;

use App\Traits\UserTrait;
use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements MustVerifyEmail
{
    use UserTrait;
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    use \Awobaz\Compoships\Compoships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guarded = [
//        'is_admin',
    ];

//    protected $guarded = [];

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

    public function avatar($size = "100x100"){
        $image = $this->image;
        if (!empty($image)){
            return Formatter::getThumbnailImage($image->image_path,$size);
        }

        return config('_my_config.default_avatar');
    }

    public function image(){
        return $this->hasOne(SingpleImage::class,'relate_id','id')->where('table' , $this->getTable());
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

    public function searchByQuery($request, $queries = [], $isApi = false)
    {
        $query = $this->query();

        foreach ($request->all() as $key => $item) {
            if ($key == "search_query") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where(function ($query) use ($item) {
                        $query->orWhere('name', 'LIKE', "%{$item}%");
                    });
                }
            } else if ($key == "gender_id") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where('gender_id', $item);
                }
            } else if ($key == "start") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '>=', $item);
                }
            } else if ($key == "end") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '<=', $item);
                }
            }
        }

        foreach ($queries as $key => $item) {
            if ($key == "search_query") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where(function ($query) use ($item) {
                        $query->orWhere('name', 'LIKE', "%{$item}%");
                    });
                }
            } else if ($key == "gender_id") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where('gender_id', $item);
                }
            } else if ($key == "start") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '>=', $item);
                }
            } else if ($key == "end") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '<=', $item);
                }
            } else {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where($key, $item);
                }
            }
        }

        return $query->latest()->paginate(Formatter::getLimitRequest($request->limit))->appends(request()->query());
    }

    public function isAdmin(){
        return auth()->check() && optional(auth()->user())->is_admin == 2;
    }

    public function storeByQuery($request, $isApi = false)
    {
        $dataInsert = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender_id' => $request->gender_id ?? 1,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ];

        if ($this->isAdmin()){
            $dataInsert['role_id'] = $request->role_id ?? 0;
            $dataInsert['is_admin'] = $request->is_admin ?? 0;
        }

        $item = $this->create($dataInsert);

        if (!empty($request->is_admin && $request->is_admin == 1 && isset($request->role_ids))){
            $item->roles()->attach($request->role_ids);
        }

        return $this->findById($item->id);
    }

    public function updateByQuery($id, $request, $isApi = false)
    {
        try {
            DB::beginTransaction();
            $updatetem = [
                'name' => $request->name,
                'phone' => $request->phone,
            ];

            if (!empty($request->date_of_birth)){
                $updatetem['date_of_birth'] = $request->date_of_birth;
            }

            if (!empty($request->gender_id)){
                $updatetem['gender_id'] = $request->gender_id;
            }

            if (!empty($request->password)) {
                $updatetem['password'] = Hash::make($request->password);
            }

            $item = $this->find($id);

            $item->update($updatetem);

            $item->refresh();

            if ($item->is_admin != 0 && isset($request->role_ids)){
                $item->roles()->sync($request->role_ids);
            }
            DB::commit();

            return $item;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
            return null;
        }
    }

    public function findById($id, $isApi = false)
    {
        $item = $this->find($id);
        $item->gender;
        $item->role;
        return $item;
    }
}
