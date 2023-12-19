<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\User;
use Illuminate\Http\Request;
use function auth;
use function view;

class DashboardController extends Controller
{
    public function index(Request $request){
        if(auth()->check()){

            $users = User::latest()->get();

            $from = request('from');
            $to = request('to');

            $counterOpportunity1 = 0;
            $costOpportunity1 = 0;
            $counterOpportunity2 = 0;
            $costOpportunity2 = 0;

            if (!empty($from) || !empty($to)){
                if (!empty($from)){
                    $counterOpportunity1 = Opportunity::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('opportunity_status_id', '2');
                    if (!empty($request->user_id)){
                        $counterOpportunity1 = $counterOpportunity1->where('user_id', $request->user_id);
                    }

                    $costOpportunity1 = $counterOpportunity1->sum('cost');
                    $counterOpportunity1 = $counterOpportunity1->count();

                    $counterOpportunity2 = Opportunity::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('opportunity_status_id', '1');
                    if (!empty($request->user_id)){
                        $counterOpportunity2 = $counterOpportunity2->where('user_id', $request->user_id);
                    }

                    $costOpportunity2 = $counterOpportunity2->sum('cost');
                    $counterOpportunity2 = $counterOpportunity2->count();

                    $opportunities = Opportunity::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
                    if (!empty($request->user_id)){
                        $opportunities = $opportunities->where('user_id', $request->user_id);
                    }
                    $opportunities = $opportunities->latest()->get();
                }
            }else{
                return redirect()->route('administrator.dashboard.index', ['from' => \Carbon\Carbon::now()->toDateString(), 'to' => \Carbon\Carbon::now()->toDateString()]);
            }

            return view('administrator.dashboard.index', compact('users','counterOpportunity1','counterOpportunity2','opportunities','costOpportunity1','costOpportunity2'));
        }



        return redirect()->to('/admin');
    }
}
