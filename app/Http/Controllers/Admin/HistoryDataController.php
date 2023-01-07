<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Traits\BaseControllerTrait;
use Illuminate\Http\Request;
use function view;

class HistoryDataController extends Controller
{
    use BaseControllerTrait;

    public function __construct(Audit $model)
    {
        $this->initBaseModel($model);
        $this->shareBaseModel($model);
    }

    public function index(Request $request){
        $items = $this->model->searchByQuery($request);
        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }
}
