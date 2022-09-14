<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use function auth;
use function view;

class AdminHistoryDataController extends Controller
{
    public function index(){
        $title = "Lịch sử dữ liệu";
        $items = Audit::latest()->paginate(10)->appends(request()->query());
        return view('administrator.history_data.index' , compact('items','title'));
    }
}
