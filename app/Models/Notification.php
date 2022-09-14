<?php

namespace App\Models;

use App\Notifications\FirebaseNotifications;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class Notification extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $guarded = [];

    public function sender(){
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

        return $this->findById($item->id);
    }

    public function updateByQuery($id, $request, $isApi = false)
    {
        try {
            DB::beginTransaction();
            $updatetem = [
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'date_of_birth' => $request->date_of_birth,
                'gender_id' => $request->gender_id ?? 1,
                'email_verified_at' => $request->verify_email ? now() : null,
            ];

            if (!empty($request->password)) {
                $updatetem['password'] = Hash::make($request->password);
            }

            $this->find($id)->update($updatetem);
            $item = $this->find($id);
            $item->roles()->sync($request->role_id);
            DB::commit();

            return $this->findById($item->id);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
            return null;
        }
    }

    public function findById($id, $isApi = false)
    {
        $item = $this->find($id);
        return $item;
    }
}
