<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Formatter;
use App\Models\Opportunity;
use App\Models\OpportunityCategory;
use App\Models\RestfulAPI;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class MembershipController extends Controller
{

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function get(Request $request, $id)
    {
        $result = $this->model->findOrFail($id);
        return response()->json($result);
    }

    public function list(Request $request)
    {
        $queries = ['is_admin' => 0];

        $results = RestfulAPI::response($this->model, $request, $queries);
        return response()->json($results);
    }

}
