<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\News;
use App\Models\Role;
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

class AdminNewsController extends Controller
{

    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;
    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(News $model)
    {
        $this->model = $model;

        $this->prefixView = "news";
        $this->prefixExport = "news_" . date('Y-m-d H:i:s');
        $this->title = "Tin tức";
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
        return redirect()->route('administrator.'.$this->prefixView.'.edit' , ["id" => $item->id]);
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        return view('administrator.'.$this->prefixView.'.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = $this->model->updateByQuery($id,$request);
        return response()->json($item);
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }
}
