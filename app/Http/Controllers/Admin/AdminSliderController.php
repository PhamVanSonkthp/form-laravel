<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Role;
use App\Models\Slider;
use App\Models\User;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function redirect;
use function view;

class AdminSliderController extends Controller
{

    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;

    public function __construct(Slider $model)
    {
        $this->model = $model;
    }

    public function index()
    {

        $query = $this->model;

        if (isset($_GET['search_query'])) {
            //$query = $query->where('name', 'LIKE', "%{$_GET['search_query']}%");
        }

        $items = $query->latest()->paginate(10)->appends(request()->query());

        return view('administrator.slider.index', compact('items'));
    }

    public function create()
    {
        return view('administrator.slider.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $dataCreate = [
                'link' => $request->link,
            ];

            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'slider');
            if (!empty($dataUploadFeatureImage)) {
                $dataCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }
            $item = $this->model->create($dataCreate);

            DB::commit();

            return redirect()->route('administrator.slider.edit', ["id" => $item->id]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
        }

        return redirect()->route('administrator.slider.index');
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        return view('administrator.slider.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $updateItem = [
                'link' => $request->link,
            ];

            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

            if (!empty($dataUploadFeatureImage)) {
                $updateItem['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $updateItem['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $this->model->find($id)->update($updateItem);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
        }

        return back();
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }
}
