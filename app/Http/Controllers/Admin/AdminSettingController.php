<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Bank;
use App\Models\CashOut;
use App\Models\Category;
use App\Models\News;
use App\Models\Receipt;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use function redirect;
use function view;

class AdminSettingController extends Controller
{

    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;
    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(Setting $model)
    {
        $this->model = $model;

        $this->prefixView = "setting";
        $this->prefixExport = "Setting" . date('Y-m-d H:i:s');
        $this->title = "Setting";
        View::share('title', $this->title);
    }

    public function index(Request $request)
    {
        $items = $this->model->searchByQuery($request);
        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }

    public function create()
    {
        return view('administrator.'.$this->prefixView.'.add');
    }

    public function store(Request $request)
    {
        $item = $this->model->storeByQuery($request);
        return redirect()->route('administrator.'.$this->prefixView.'.edit', ["id" => $item->id]);
    }

    public function edit($id)
    {
        $item = $this->model->findById($id);
        return view('administrator.'.$this->prefixView.'.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $this->model->updateByQuery($id,$request);
        return back();
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }
}
