<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\Formatter;
use App\Models\ParticipantChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private $plainToken;

    public function __construct()
    {
        $this->plainToken = env('PLAIN_TOKEN', 'infinity_pham_son');
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string',
            'date_of_birth' => 'required|date_format:Y-m-d H:i',
            'firebase_uid' => 'required|string',
        ]);

        $user = User::firstOrCreate([
            'phone' => $request->phone,
        ], [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Formatter::hash($request->password),
            'date_of_birth' => $request->date_of_birth,
            'firebase_uid' => $request->uid,
        ]);

//        $user = User::where('name', $request->name)->first();
//
//        if (!$user || !Hash::check($request->password, $user->password)) {
//            return response([
//                'message' => "wrong token"
//            ], 401);
//        }

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
            'content' => 'Chào mừng đến với ' . env('APP_NAME') . '!',
            'user_id' => 1,
            'chat_group_id' => $chatGoup->id,
        ]);

        return response($response);
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response([
                'message' => "Tài khoản chưa được tạo",
                'code' => 400,
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response([
                'message' => "Mật khẩu không đúng",
                'code' => 400,
            ], 400);
        }
        if ($user->user_status_id == 2) {
            return response()->json(['error' => 'Tài khoản của bạn đã bị khóa'], 405);
        }

        $token = $user->createToken($this->plainToken)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response);

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'success',
            'code' => 200,
        ]);
    }

    public function checkExist(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        if (!empty(User::where('phone', $request->phone)->first())) {
            return response()->json([
                'message' => $request->phone . " is exist",
                'code' => 200,
            ]);
        } else {
            return response()->json([
                'message' => $request->phone . " is not exist",
                'code' => 400,
            ], 400);
        }

    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'firebase_uid' => 'required|string',
            'new_password' => 'required|string',
        ]);

        $user = User::where('firebase_uid', $request->firebase_uid)->first();

        if (empty($user)) {
            return response()->json([
                'message' => "uid is not exist",
                'code' => 400,
            ], 400);
        }
        $user->update([
            'password' => Formatter::hash($request->password)
        ]);

        return response($user, 200);
    }

    public function updateAvatar(Request $request)
    {
        if (!$request->hasFile('feature_image')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $allowedfileExtension = ['jpg', 'png'];
        $file = $request->file('feature_image');
        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension, $allowedfileExtension);
        if (!$check) {
            return response()->json(['invalid_file_format'], 422);
        }

        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image', 'user');

        $dataUpdate = [];

        if (!empty($dataUploadFeatureImage)) {
            $dataUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $dataUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }

        auth()->user()->update($dataUpdate);
        return auth()->user();
    }

    public function update(Request $request)
    {
        $request->validate([
            'date_of_birth' => 'date_format:Y-m-d H:i',
        ]);

        $dataUpdate = [];

        if (!empty($request->name)) {
            $dataUpdate['name'] = $request->name;
        }

        if (!empty($request->date_of_birth)) {
            $dataUpdate['date_of_birth'] = $request->date_of_birth;
        }

        if (!empty($request->address)) {
            $dataUpdate['address'] = $request->address;
        }

        if (!empty($request->password)) {
            $dataUpdate['password'] = Formatter::hash($request->password);
        }

        auth()->user()->update($dataUpdate);

        return auth()->user();
    }


    public function delete()
    {
        auth()->user()->delete();
        return response()->json([
            'message' => 'deleted!',
            'code' => 200,
        ]);
    }
}
