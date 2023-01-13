<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\Formatter;
use App\Models\News;
use App\Models\Notification;
use App\Models\ParticipantChat;
use App\Models\Product;
use App\Models\RestfulAPI;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{
    private $modelNew;

    public function __construct(UserNotification $new)
    {
        $this->modelNew = $new;
    }

    public function list(Request $request)
    {
        $queries = [];

        if (!env('CODE_DEBUG')){
            $queries['user_id'] = auth()->id();
        }

        $results = RestfulAPI::response($this->modelNew, $request, $queries);

        return response()->json($results);
    }

    public function read(Request $request, $id)
    {
        $item = UserNotification::findOrFail($id);

        if (!env('CODE_DEBUG')){
            if ($item->user_id != auth()->id()) return abort(404);
        }

        $item->update([
            'read_at' => now()
        ]);

        return response()->json($item);
    }
}
