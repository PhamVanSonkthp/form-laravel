<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\Formatter;
use App\Models\Helper;
use App\Models\Image;
use App\Models\News;
use App\Models\Role;
use App\Models\SingpleImage;
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
    private $table;
    private $relateImageTableId;
    private $imagePathSingple;
    private $imagePostUrl;
    private $imagesPath;
    private $imageMultiplePostUrl;
    private $imageMultipleDeleteUrl;
    private $imageMultipleSortUrl;

    public function __construct(News $model)
    {
        $this->model = $model;
        $this->table = $this->model->getTableName();

//        $this->prefixView = "news";
        $this->prefixView = $this->table;
        $this->prefixExport = $this->prefixView . "_" . Formatter::getDateTime(now());
//        $this->title = "Tin tức";
        $this->title = $this->prefixView;

        $this->relateImageTableId = Helper::getNextIdTable($this->table);

        $this->imagePathSingple = optional(SingpleImage::where('relate_id', Helper::getNextIdTable($this->table))->where('table', $this->table)->first())->image_path;
        $this->imagePostUrl = route('ajax,administrator.upload_image.store');

        $this->imagesPath = Image::where('relate_id', Helper::getNextIdTable($this->table))->where('table', $this->table)->orderBy('index')->get();
        $this->imageMultiplePostUrl = route('ajax,administrator.upload_multiple_images.store');
        $this->imageMultipleDeleteUrl = route('ajax,administrator.upload_multiple_images.delete');
        $this->imageMultipleSortUrl = route('ajax,administrator.upload_multiple_images.sort');

        View::share('title', $this->title);
        View::share('table', $this->table);
        View::share('relateImageTableId', $this->relateImageTableId);
        View::share('imagePathSingple', $this->imagePathSingple);
        View::share('imagePostUrl', $this->imagePostUrl);
        View::share('imagesPath', $this->imagesPath);
        View::share('imageMultiplePostUrl', $this->imageMultiplePostUrl);
        View::share('imageMultipleDeleteUrl', $this->imageMultipleDeleteUrl);
        View::share('imageMultipleSortUrl', $this->imageMultipleSortUrl);
    }

    public function index(Request $request)
    {
        $items = $this->model->searchByQuery($request);
        return view('administrator.' . $this->prefixView . '.index', compact('items'));
    }

    public function create()
    {
        return view('administrator.' . $this->prefixView . '.add');
    }

    public function store(Request $request)
    {
        $item = $this->model->storeByQuery($request);
        return redirect()->route('administrator.' . $this->prefixView . '.edit', ["id" => $item->id]);
    }

    public function edit($id)
    {
        $item = $this->model->find($id);
        return view('administrator.' . $this->prefixView . '.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = $this->model->updateByQuery($id, $request);
        return response()->json($item);
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }
}
