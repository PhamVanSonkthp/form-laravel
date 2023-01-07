<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use function redirect;
use function view;

class ProductController extends Controller
{

    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {

        $query = $this->model;

        if (isset($_GET['search_query'])) {
            $query = $query->where('name', 'LIKE', "%{$_GET['search_query']}%")->orWhere('code', '=', "{$_GET['search_query']}")->orWhere('bar_code', '=', "{$_GET['search_query']}");
        }

        $items = $query->latest()->paginate((int)filter_var($request->limit ?? '10', FILTER_SANITIZE_NUMBER_INT))->appends(request()->query());

        return view('administrator.product.index', compact('items'));
    }

    public function create()
    {
        return view('administrator.product.add');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $dataCreate = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'content' => $request->contents,
                'inventory' => $request->inventory,
                'price' => $request->price,
                'unit' => $request->unit,
                'category_id' => $request->category_id,
                'code' => $request->code ?? Str::uuid()->getHex(),
                'bar_code' => $request->bar_code,
            ];

            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');
            if (!empty($dataUploadFeatureImage)) {
                $dataCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $item = $this->model->create($dataCreate);

            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMultiple($fileItem, 'product');
                    $item->images()->create([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name'],
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('administrator.product.edit', ["id" => $item->id]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
            dd($exception->getMessage());
        }
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        return view('administrator.product.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $updateItem = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'content' => $request->contents,
                'inventory' => $request->inventory,
                'price' => $request->price,
                'unit' => $request->unit,
                'category_id' => $request->category_id,
                'code' => $request->code ?? Str::uuid()->getHex(),
                'bar_code' => $request->bar_code,
            ];

            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

            if (!empty($dataUploadFeatureImage)) {
                $updateItem['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $updateItem['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $this->model->find($id)->update($updateItem);
            $item = $this->model->find($id);
            if ($request->hasFile('image_path')) {
                foreach ($request->image_path as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMultiple($fileItem, 'product');
                    $item->images()->create([
                        'image_path' => $dataProductImageDetail['file_path'],
                        'image_name' => $dataProductImageDetail['file_name'],
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
        }

        return back();
    }

    public function export(Request $request)
    {
        $search_query = '';

        if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
            $search_query = $_GET['search_query'];
        }

        return Excel::download(new ProductExport($request, $search_query), 'san_pham.xlsx');
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }

    public function deleteManyByIds(Request $request)
    {
        return $this->model->deleteManyByIds($request, $this->forceDelete);
    }
}
