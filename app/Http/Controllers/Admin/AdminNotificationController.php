<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use function view;

class AdminNotificationController extends Controller
{
    use DeleteModelTrait;
    use StorageImageTrait;

    private $model;

    private $prefixView;
    private $prefixExport;
    private $title;

    public function __construct(Notification $model)
    {
        $this->model = $model;

        $this->prefixView = "notification";
        $this->prefixExport = "Notification_" . date('Y-m-d H:i:s');
        $this->title = "Notification";
        View::share('title', $this->title);
    }

    public function index(Request $request)
    {
        $items = $this->model->searchByQuery($request);
        return view('administrator.'.$this->prefixView.'.index', compact('items'));
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }
}
