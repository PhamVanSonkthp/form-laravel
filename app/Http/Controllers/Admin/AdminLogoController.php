<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogoAddRequest;
use App\Models\Logo;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\View;
use function view;

class AdminLogoController extends Controller
{
    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;

    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(Logo $model)
    {
        $this->model = $model;

        $this->prefixView = "logo";
        $this->prefixExport = "Logo_" . date('Y-m-d H:i:s');
        $this->title = "Logo";

        View::share('title', $this->title);
    }

    public function create(){
        $logo = $this->model->first();
        return view('administrator.'.$this->prefixView.'.add' , compact('logo'));
    }

    public function store(LogoAddRequest $request){

        $dataCreate = [];

        $dataUploadImage = $this->storageTraitUpload($request, 'image_path', 'logo');

        if (!empty($dataUploadImage)) {
            $dataCreate['image_name'] = $dataUploadImage['file_name'];
            $dataCreate['image_path'] = $dataUploadImage['file_path'];
        }

        $logo = $this->model->first();

        if(empty($logo)){
            $this->model->create($dataCreate);
        }else{
            $logo->update($dataCreate);
        }

        return back();
    }

}
