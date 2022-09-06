<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleAddRequest;
use App\Http\Requests\RoleEditRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use function redirect;
use function view;

class AdminRoleController extends Controller
{
    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;
    private $premission;
    private $roles;

    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(Role $model, Permission $premission)
    {
        $this->model = $model;
        $this->roles = Role::all();
        $this->premission = $premission;

        $this->prefixView = "role";
        $this->prefixExport = "Vai trò_" . date('Y-m-d H:i:s');
        $this->title = "Vai trò";

        View::share('title', $this->title);
        View::share('roles', $this->roles);
    }

    public function index(Request $request){
        $items = $this->model->searchByQuery($request);
        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }

    public function create(){
        $premissionsParent = $this->premission->where('parent_id' , 0)->orderBy('display_name')->get();
        return view('administrator.role.add' , compact('premissionsParent'));
    }

    public function store(RoleAddRequest $request){
        $role = $this->role->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);
        $role->permissions()->attach($request->permission_id);
        return redirect()->route('administrator.roles.index');
    }

//    public function edit($id){
//        $premissionsParent = $this->premission->where('parent_id' , 0)->orderBy('display_name')->get();
//        $role = $this->role->find($id);
//        $permissionsChecked = $role->permissions;
//        return view('administrator.role.edit' , compact('premissionsParent'  , 'role' , 'permissionsChecked'));
//    }

    public function update($id , RoleEditRequest $request){
        $this->role->find($id)->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        $role = $this->role->find($id);

        $role->permissions()->sync($request->permission_id);
        return back();
    }

    public function delete($id){
        return $this->deleteModelTrait($id, $this->role);
    }
}
