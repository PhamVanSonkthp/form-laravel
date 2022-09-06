<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\Formatter;
use App\Models\ParticipantChat;
use App\Models\RestfulAPI;
use App\Models\User;
use App\Models\UserAddress;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use StorageImageTrait;

    private $plainToken = 'infinity_pham_son';

    public function register(Request $request)
    {
        $fields = $request->validate([
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

    public function edit(Request $request)
    {
        $dataUpdate = [];

        foreach ($request->all() as $key => $item) {
            if (isset($item) || strlen($item) > 0) {
                if ($key != 'password') {
                    $dataUpdate[$key] = $request->$key;
                }
            }
        }

        $isUpdated = auth()->user()->update($dataUpdate);

        if (!$isUpdated) {
            return response()->json([
                'message' => 'error',
                'code' => 400,
            ], 400);
        }

        return auth()->user();
    }

    public function getReferral(Request $request)
    {
        $user = User::where('referral_code', 'like', $request->search)->first();
        if (!$user) return response('Mã giới thiệu không chính xác', 400);
        else return $user;
    }

    public function referral(Request $request)
    {
        $isUpdated = auth()->user()->update([
            'referral_id' => (int)$request->id
        ]);

        if (!$isUpdated) {
            return response()->json([
                'message' => 'error',
                'code' => 400,
            ], 400);
        }

        return auth()->user();
    }

    public function updateImage(Request $request)
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

    public function signin(Request $request)
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
        $user->defaultAddress;
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'success',
            'code' => 200,
        ];
    }

    public function list(Request $request)
    {
        $user = User::where([['name', 'like', '%' . $request->search . '%'], ['is_admin', '=', 0]])->orWhere([['phone', 'like', '%' . $request->search . '%'], ['is_admin', '=', 0]])->get();
        foreach ($user as $child) {
            $child->defaultAddress;
        }
        return response($user, 200);
    }

    public function address()
    {
        return auth()->user()->listAddress;
    }

    public function addAddress(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $address = UserAddress::find($request->id);
            $address->update([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address ?? '',
                'detail' => $request->detail ?? ''
            ]);
            if ($request->def == 1) {
                auth()->user()->update([
                    'address_id' => (int)$address->id
                ]);
            }
            return response($address);
        } else {
            $address = UserAddress::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address ?? '',
                'detail' => $request->detail ?? ''
            ]);
            if ($request->def == 1 || auth()->user()->listAddress->count() == 1) {
                auth()->user()->update([
                    'address_id' => (int)$address->id
                ]);
            }
            return response($address);
        }

    }

    public function delAddress($id)
    {
        UserAddress::find($id)->delete();
        return response('Success', 200);
    }

    public function checkExist(Request $request)
    {
        if (!empty(User::where('firebase_uid', '=', $request->uid)->first()))
            return response('Success', 200);
        else return response('Fail', 400);

    }

    public function checkPhone(Request $request)
    {

        if (!empty(User::where('phone', '=', $request->phone)->first()))
            return response('Success', 200);
        else return response('Fail', 400);

    }

    public function rsPassword(Request $request)
    {
        $user = User::where('firebase_uid', '=', $request->uid)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return response($user, 200);
    }

    public function changePassword(Request $request)
    {

        if (Hash::check($request->oldPass, auth()->user()->password)) {
            auth()->user()->update([
                'password' => Hash::make($request->newPass)
            ]);
            return response(auth()->user(), 200);
        } else {
            return response('Mật khẩu cũ không chính xác', 400);
        }
    }

    public function deleteAccount()
    {
        UserAddress::where('user_id','=',auth()->id())->delete();
        auth()->user()->forceDelete();
        return response('Success', 200);
    }
}

