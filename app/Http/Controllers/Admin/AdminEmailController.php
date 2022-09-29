<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ParticipantChat;
use App\Models\Role;
use App\Models\User;
use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use function view;

class AdminEmailController extends Controller
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

        $this->prefixView = "email";
        $this->prefixExport = "Email_" . date('Y-m-d H:i:s');
        $this->title = "Email";

        View::share('title', $this->title);
    }

    public function index(Request $request)
    {
        return view('administrator.'.$this->prefixView.'.index');
    }

    public function delete($id)
    {
        return $this->deleteModelTrait($id, $this->model);
    }

}
