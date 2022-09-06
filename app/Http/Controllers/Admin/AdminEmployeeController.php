<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmployeeExport;
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

class AdminEmployeeController extends Controller
{
    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;
    private $roles;

    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->roles = Role::all();
        $this->prefixView = "employees";
        $this->prefixExport = "Nhân viên_" . date('Y-m-d H:i:s');
        $this->title = "Nhân viên";
        View::share('title', $this->title);
        View::share('roles', $this->roles);
    }

    public function index(Request $request)
    {
        $items = $this->model->searchByQuery($request, ['is_admin' => 1]);
        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }

    public function get(Request $request, $id)
    {
        return $this->model->findById($id);
    }

    public function create()
    {
        return view('administrator.employees.add');
    }

    public function store(UserAddRequest $request)
    {
        $item = $this->model->storeByQuery($request);
        return response()->json($item);
    }

    public function edit($id)
    {
        $item = $this->model->findById($id);
        return view('administrator.'.$this->prefixView.'.edit', compact('item'));
    }

    public function update($id, UserEditRequest $request)
    {
        $item = $this->model->updateByQuery($id,$request);
        return response()->json($item);
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }

    public function export(Request $request)
    {
        return Excel::download(new EmployeeExport($request), $this->prefixExport . '.xlsx');
    }
}
