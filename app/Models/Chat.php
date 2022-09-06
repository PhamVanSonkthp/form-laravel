<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Chat extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class , 'id', 'user_id');
    }

    public function images(){
        return $this->hasMany(ChatImage::class , 'chat_id' , 'id');
    }
}
