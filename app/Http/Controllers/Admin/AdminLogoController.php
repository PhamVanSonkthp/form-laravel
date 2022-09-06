<?php

namespace App\Http\Controllers\Admin;

use App\Components\MenuRecusive;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogoAddRequest;
use App\Http\Requests\MenuAddRequest;
use App\Http\Requests\MenuEditRequest;
use App\Http\Requests\PostAddRequest;
use App\Http\Requests\PostEditRequest;
use App\Models\Logo;
use App\Models\Menu;
use App\Models\Post;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Str;
use function redirect;
use function view;

class AdminLogoController extends Controller

{
    use DeleteModelTrait;
    use StorageImageTrait;
    private $logo;

    public function __construct(Logo $logo)
    {
        $this->logo = $logo;
    }

    public function create(){
        $logo = $this->logo->first();
        return view('administrator.logo.add' , compact('logo'));
    }

    public function store(LogoAddRequest $request){

        $dataCreate = [];

        $dataUploadImage = $this->storageTraitUpload($request, 'image_path', 'logo');

        if (!empty($dataUploadImage)) {
            $dataCreate['image_name'] = $dataUploadImage['file_name'];
            $dataCreate['image_path'] = $dataUploadImage['file_path'];
        }

        $logo = $this->logo->first();

        if(empty($logo)){
            $this->logo->create($dataCreate);
        }else{
            $logo->update($dataCreate);
        }

        return redirect()->route('administrator.logo.add');
    }

}
