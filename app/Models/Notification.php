<?php

namespace App\Models;

use App\Notifications\FirebaseNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Notification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class , 'id' , 'notifiable_id' );
    }

    public function sendNotificationFirebase($user_id, $chat_group_id, $contents){

        if (env('FIREBASE_SERVER_NOTIFIABLE')){
            $getter = User::find($user_id);
            if (!empty($getter)) {
                $participantChat = ParticipantChat::where('chat_group_id', $chat_group_id)->where('user_id', $user_id)->first();

                if (!empty($participantChat) && $participantChat->status == 1) {
                    auth()->user()->notify(new FirebaseNotifications('Tin nhắn', $contents, $user_id . ""));
                }
            }
        }
    }

}
