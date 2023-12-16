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
            $to = request('from');

            $counterOpportunity1 = 0;
            $counterOpportunity2 = 0;

            if (!empty($from) || !empty($to)){
                if (!empty($from)){
                    $counterOpportunity1 = Opportunity::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('opportunity_status_id', '2');
                    if (!empty($request->user_id)){
                        $counterOpportunity1 = $counterOpportunity1->where('user_id', $request->user_id);
                    }
                    $counterOpportunity1 = $counterOpportunity1->count();

                    $counterOpportunity2 = Opportunity::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->where('opportunity_status_id', '1');
                    if (!empty($request->user_id)){
                        $counterOpportunity2 = $counterOpportunity2->where('user_id', $request->user_id);
                    }
                    $counterOpportunity2 = $counterOpportunity2->count();

                    $opportunities = Opportunity::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
                    if (!empty($request->user_id)){
                        $opportunities = $opportunities->where('user_id', $request->user_id);
                    }
                    $opportunities = $opportunities->latest()->get();
                }
            }else{
                $counterOpportunity1 = Opportunity::whereDate('created_at', now())->where('opportunity_status_id', '2');
                if (!empty($request->user_id)){
                    $counterOpportunity1 = $counterOpportunity1->where('user_id', $request->user_id);
                }
                $counterOpportunity1 = $counterOpportunity1->count();

                $counterOpportunity2 = Opportunity::whereDate('created_at', now())->where('opportunity_status_id', '1');
                if (!empty($request->user_id)){
                    $counterOpportunity2 = $counterOpportunity2->where('user_id', $request->user_id);
                }
                $counterOpportunity2 = $counterOpportunity2->count();

                $opportunities = Opportunity::whereDate('created_at', now());
                if (!empty($request->user_id)){
                    $opportunities = $opportunities->where('user_id', $request->user_id);
                }
                $opportunities = $opportunities->latest()->get();
            }

            return view('administrator.dashboard.index', compact('users','counterOpportunity1','counterOpportunity2','opportunities'));
        }



        return redirect()->to('/admin');
    }
}
