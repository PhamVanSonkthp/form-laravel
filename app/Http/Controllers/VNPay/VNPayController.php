<?php

namespace App\Http\Controllers\VNPay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function view;

class VNPayController extends Controller
{
    public function index(Request $request){
        return view('user.vnpay.index');
    }

    public function createPayment(Request $request){

//        include (app_path() . '/Plugin/vnpay_php/config.php');
        return view('user.vnpay.vnpay_create_payment');
    }

}
