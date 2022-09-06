<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Models\DateRating;
use App\Models\Level;
use App\Models\RestfulAPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use function auth;
use function view;

class UserController extends Controller
{
    public function listAgentSuggestion(Request $request){
        $queries = ["role_id" => 5, "user_status_id" => 2];
        return RestfulAPI::response(User::class , $request, $queries);
    }

}
