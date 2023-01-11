<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\ParticipantChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private $plainToken;

    /**
     * @param mixed $plainToken
     */
    public function __construct($plainToken)
    {
        $this->plainToken = env('PLAIN_TOKEN','infinity_pham_son');
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|string',
            'email' => 'string',
            'firebase_uid' => 'string',
        ]);

        User::firstOrCreate([
            'phone' => $request->phone,
        ], [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'firebase_uid' => $request->uid,
            'password' => bcrypt($request->password),
        ]);

        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => "wrong token"
            ], 401);
        }

        $token = $user->createToken($this->plainToken)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        $chatGoup = ChatGroup::create([
            'title' => 'First chat'
        ]);

        ParticipantChat::create(
            [
                'user_id' => $user->id,
                'chat_group_id' => $chatGoup->id,
            ]
        );

        ParticipantChat::create(
            [
                'user_id' => 1,
                'chat_group_id' => $chatGoup->id,
            ]
        );

        Chat::create([
            'content' => 'Chào mừng đến với WeMatch!',
            'user_id' => 1,
            'chat_group_id' => $chatGoup->id,
        ]);

        return response($response);
    }
}
