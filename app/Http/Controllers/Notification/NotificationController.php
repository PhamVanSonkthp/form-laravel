<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class NotificationController extends Controller
{
    public function index(Request $request){
        return view('user.home.index');
    }

    public function sms(Request $request){
        $basic  = new \Vonage\Client\Credentials\Basic("343c3ed1", "NFWw2IsoFA5S7wQj");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("84378115213", "BRAND_NAME", 'A text message sent using the Nexmo SMS API')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }

    }

}
