<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Chat;
use App\Models\Date;
use App\Models\ParticipantChat;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Notifications;
use App\Traits\DeleteModelTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use function redirect;
use function view;

class AdminChatController extends Controller
{

    use DeleteModelTrait;

    private $user;
    private $role;

    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;

        $this->prefixView = "chat";
        $this->prefixExport = "Chat_" . date('Y-m-d H:i:s');
        $this->title = "Chat";

        View::share('title', $this->title);
    }

    public function index(Request $request)
    {
        $query = ParticipantChat::where('user_id' , auth()->id());

        $items = $query->latest()->paginate(10)->appends(request()->query());

        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->user);
    }

}
