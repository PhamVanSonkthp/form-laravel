<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationContent;
use App\Models\PaymentStripe;
use App\Models\Source;
use App\Models\Topic;
use App\Traits\DeleteModelTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function redirect;
use function view;

class AdminNotificationController extends Controller
{
    use DeleteModelTrait;
    private $notification;
    private $notificationContent;

    public function __construct(Notification $notification, NotificationContent $notificationContent)
    {
        $this->notification = $notification;
        $this->notificationContent = $notificationContent;
    }

    public function index()
    {
        $notifications = $this->notification->latest()->paginate(10)->appends(request()->query());
        return view('administrator.notification.index' , compact('notifications'));
    }

    public function edit()
    {
        $notificationContent = $this->notificationContent->first();

        if(empty($notificationContent)){
            $notificationContent = $this->notificationContent->create([
                "thankyou"=> "Cảm ơn bạn đã sử dụng dịch vụ!"
            ]);
        }

        return view('administrator.notification.edit' , compact('notificationContent'));
    }

    public function update(Request $request)
    {
        $notificationContent = $this->notificationContent->first();

        if(empty($notificationContent)){
            $notificationContent = $this->notificationContent->create([
                "thankyou"=> "Cảm ơn bạn đã sử dụng dịch vụ!"
            ]);
        }

        $notificationContent->update([
            "thankyou" => $request->thankyou
        ]);

        return back();
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->notification);
    }
}
