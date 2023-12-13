<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Formatter;
use App\Models\Helper;
use App\Models\Image;
use App\Models\Opportunity;
use App\Models\OpportunityCategory;
use App\Models\RestfulAPI;
use App\Models\Slider;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{

    private $model;

    public function __construct(Opportunity $model)
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

        if (empty($request->opportunity_category_id)){
            $request->request->remove('opportunity_category_id');
        }

        $results = RestfulAPI::response($this->model, $request);
        return response()->json($results);
    }

    public function listByUser(Request $request)
    {
        $queries = ['user_id' => auth()->id()];
        $results = RestfulAPI::response($this->model, $request, $queries);
        return response()->json($results);
    }

    public function create(Request $request)
    {

        $request->validate([
            'client_name' => 'required',
            'client_phone' => 'required',
            'opportunity_category_id' => 'required|exists:opportunity_categories,id',
        ]);


        $result = $this->model->create([
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'opportunity_status_id' => 1,
            'opportunity_category_id' => $request->opportunity_category_id,
            'cost' => Formatter::formatNumberToDatabase($request->cost),
            'user_id' => auth()->id(),
        ]);

        if (is_array($request->images)){
            foreach ($request->images as $image) {

                $item = Image::create([
                    'uuid' => Helper::getUUID(),
                    'table' => $this->model->getTableName(),
                    'image_path' => "waiting",
                    'image_name' => "waiting",
                    'relate_id' => $result->id,
                ]);


                $dataUploadFeatureImage = StorageImageTrait::storageTraitUpload($request, $image,  'opportunities', $item->id);

                $dataUpdate = [
                    'image_path' => $dataUploadFeatureImage['file_path'],
                    'image_name' => $dataUploadFeatureImage['file_name'],
                ];

                $item->update($dataUpdate);

            }
        }


        $result->refresh();

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'opportunity_status_id' => 'required|exists:opportunity_statuses,id',
        ]);

        $result = $this->model->where(['id' => $id,'user_id' => auth()->id()])->first();

        if (empty($result)) return abort(404);

        $result->update([
            'opportunity_status_id' => $request->opportunity_status_id
        ]);

        $result->refresh();

        return response()->json($result);
    }
}
