<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\InvoiceTrading;
use App\Models\NotificationContent;
use App\Models\Product;
use App\Models\ProductOfUser;
use App\Models\TradingOfUser;
use App\Models\User;
use App\Notifications\Notifications;
use DateTime;
use Illuminate\Console\Command;

class Notification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notificationContent = NotificationContent::first();

        if (empty($notificationContent)) {
            $notificationContent = NotificationContent::create([
                "thankyou" => "Cảm ơn bạn đã sử dụng dịch vụ!"
            ]);
        }

//        $productOfUsers = ProductOfUser::all();
//        foreach ($productOfUsers as $productOfUserItem) {
//            if (ProductOfUser::isExpired($productOfUserItem->id, $productOfUserItem->user_id) && ProductOfUser::dateExpire($productOfUserItem->id, $productOfUserItem->user_id) > -10 && ProductOfUser::dateExpire($productOfUserItem->id, $productOfUserItem->user_id) <= 0) {
//                $user = $productOfUserItem->user;
//                $product = $productOfUserItem->product;
//
//                $notificationData = [
//                    'body' => 'Khóa học "' . $product->name . '" của bạn đã hết hạn, vui lòng truy cập "Khóa học của tôi" để gia hạn',
//                    'text' => 'Gia hạn ngay',
//                    'url' => route('user.sources'),
//                    'thankyou' => $notificationContent->thankyou,
//                ];
//
//                $user->notify(new Notifications($notificationData));
//            }
//        }

        $tradingOfUsers = TradingOfUser::all();
        foreach ($tradingOfUsers as $tradingOfUserItem) {
            if (TradingOfUser::isExpired($tradingOfUserItem->id, $tradingOfUserItem->user_id) && TradingOfUser::dateExpire($tradingOfUserItem->id, $tradingOfUserItem->user_id) > -10 && TradingOfUser::dateExpire($tradingOfUserItem->id, $tradingOfUserItem->user_id) <= 0) {
                $user = $tradingOfUserItem->user;
                $trading = $tradingOfUserItem->trading;

                $notificationData = [
                    'body' => 'Trading "' . $trading->name . '" của bạn đã hết hạn, vui lòng truy cập "VIP plan của tôi" để gia hạn',
                    'text' => 'Gia hạn ngay',
                    'url' => route('user.tradings'),
                    'thankyou' => $notificationContent->thankyou,
                ];

                $user->notify(new Notifications($notificationData));
            }
        }

    }
}
