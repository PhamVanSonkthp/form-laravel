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
use Maatwebsite\Excel\Facades\Excel;
use function redirect;
use function view;

class AdminChatController extends Controller
{

    use DeleteModelTrait;

    private $user;
    private $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index(Request $request)
    {
        $query = ParticipantChat::where('user_id' , auth()->id());

        $items = $query->latest()->paginate(10)->appends(request()->query());

        return view('administrator.chat.index', compact('items'));
    }

    public function create()
    {
        $roles = $this->role->all();
        return view('administrator.chat.add', compact('roles'));
    }

    public function store(UserAddRequest $request)
    {

        $user = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_discord' => $request->user_discord,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender ? 1 : 0,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('administrator.chat.edit', ["id" => $user->id]);
    }

    public function edit($id)
    {
        $user = $this->user->find($id);
        return view('administrator.chat.edit', compact('user'));
    }

    public function update($id, UserEditRequest $request)
    {
        try {
            DB::beginTransaction();
            $updatetem = [
                'name' => $request->name,
                'phone' => $request->phone,
                'user_discord' => $request->user_discord,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender ? 1 : 0,
                'email_verified_at' => $request->verify_email ? now() : null,
            ];

            if (!empty($request->password)) {
                $updatetem['password'] = Hash::make($request->password);
            }

            $this->user->find($id)->update($updatetem);

            $user = $this->user->find($id);
            $user->roles()->sync($request->role_id);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
        }

        return back();
    }

    public function updateStatus($id, Request $request)
    {
        $updateItem = [
            'user_status_id' => $request->user_status_id ? 2 : 1,
            'user_suggestion_id' => $request->user_suggestion_id ? 1 : 2,
            'user_finder_find_id' => $request->user_finder_find_id ? 2 : 1
        ];

        $this->user->find($id)->update($updateItem);
        return back();

    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->user);
    }

    public function deleteProductOfUser($id)
    {
        return $this->deleteModelTrait($id, $this->productOfUser);
    }

    public function deleteTradingOfUser($id)
    {
        return $this->deleteModelTrait($id, $this->tradingOfUser);
    }

    public function deleteGift($id)
    {
        return $this->deleteModelTrait($id, $this->userGifts);
    }

    public function exportUser()
    {
        $search_query = "";
        $gender = "";
        $start = "";
        $end = "";
        $date_of_birth = "";

        if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
            $search_query = $_GET['search_query'];
        }

        if (isset($_GET['gender']) && (!empty($_GET['gender']) || strlen($_GET['gender']) > 0)) {
            $gender = $_GET['gender'];
        }

        if (isset($_GET['start']) && !empty($_GET['start'])) {
            $start = $_GET['start'];
        }

        if (isset($_GET['end']) && !empty($_GET['end'])) {
            $end = $_GET['end'];
        }

        if (isset($_GET['date_of_birth']) && !empty($_GET['date_of_birth'])) {
            $date_of_birth = $_GET['date_of_birth'];
        }

        return Excel::download(new UsersExport($search_query, $gender, $start, $end, $date_of_birth), 'Khách hàng.xlsx');
    }

    public function tradingOfUser($id)
    {

        $tradingOfUsers = $this->tradingOfUser->where('user_id', $id)->get();

        $datas = [];

        foreach ($tradingOfUsers as $tradingOfUserItem) {
            $datas[] = [
                "trading_id" => $tradingOfUserItem->trading->id,
                "real_price" => $tradingOfUserItem->trading->realPrice($tradingOfUserItem->trading->id) - $tradingOfUserItem->trading->realPriceUpgrade($tradingOfUserItem->trading->id, $id),
                "name" => $tradingOfUserItem->trading->name,
                "content" => $tradingOfUserItem->trading->content,
            ];
        }

        return response()->json([
            "code" => 200,
            "data" => $datas
        ]);
    }

    function sendEmail(Request $request)
    {
        $user = $this->user->where('email', $request->email_to)->first();
        $notificationData = [
            'body' => $request->contents,
        ];

        $user->notify(new Notifications($notificationData));

        return response()->json([
            "code" => 200,
            "message" => "success"
        ]);
    }

    public function changeSchoolYear($id, Request $request)
    {

        try {
            DB::beginTransaction();

            $userId = $request->user_id;
            $price = $request->price;
            $newProductId = $request->new_product_id;

            $productOfUser = $this->productOfUser->find($id);

            $oldInvoice = $this->invoice->find($productOfUser->invoice_id);

            $productIds = [
                "product_id" => [$newProductId],
                "combo_product_id" => [],
                "trading_id" => [],
            ];

            $priceIds = [
                "product_id" => [$price + (optional($oldInvoice)->price ?? 0)],
                "combo_product_id" => [],
                "trading_id" => [],
            ];

            $newInvoice = $this->invoice->create([
                'user_id' => $userId,
                'price' => $price + (optional($oldInvoice)->price ?? 0),
                'product_ids' => json_encode($productIds),
                'price_ids' => json_encode($priceIds),
                'content' => 'Chuyển đăng ký khóa học',
                'type_payment_id' => optional($oldInvoice)->type_payment_id ?? 0,
            ]);

            $this->productOfUser->create([
                'user_id' => $userId,
                'product_id' => $newProductId,
                'invoice_id' => $newInvoice->id,
                'created_at' => $productOfUser->created_at,
                'updated_at' => $productOfUser->updated_at,
            ]);

            $productOfUser->delete();
            optional($oldInvoice)->delete();


            DB::commit();

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
        }
        return response()->json([
            "code" => 500,
            "message" => "error"
        ], 500);
    }
}
