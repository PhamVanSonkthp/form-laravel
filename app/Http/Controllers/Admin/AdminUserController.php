<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use function view;

class AdminUserController extends Controller
{
    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;
    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(User $model, Role $role)
    {
        $this->model = $model;
        $this->role = $role;
        $this->prefixView = "user";
        $this->prefixExport = "Khách hàng_" . date('Y-m-d H:i:s');
        $this->title = "Khách hàng";
        View::share('title', $this->title);
    }

    public function index(Request $request)
    {
        $items = $this->model->searchByQuery($request, ['is_admin' => 0]);
        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }

    public function get(Request $request, $id)
    {
        return $this->model->findById($id);
    }

    public function create()
    {
        $roles = $this->role->all();
        return view('administrator.'.$this->prefixView.'.add', compact('roles'));
    }

    public function store(UserAddRequest $request)
    {
        $item = $this->model->storeByQuery($request);
        return redirect()->route('administrator.users.index');
    }

    public function edit($id)
    {
        $item = $this->model->findById($id);
        return view('administrator.'.$this->prefixView.'.edit', compact('item'));
    }

    public function update($id, UserEditRequest $request)
    {
        $item = $this->model->updateByQuery($id,$request);
        return redirect()->route('administrator.users.index');
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }

    public function export(Request $request)
    {
        return Excel::download(new UsersExport($request), $this->prefixExport . '.xlsx');
    }

}
