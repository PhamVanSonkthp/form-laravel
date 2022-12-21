<?php

use App\Models\Image;
use App\Models\SingpleImage;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// ajax
Route::prefix('ajax/administrator')->group(function () {
    Route::group(['middleware' => ['auth']], function () {

        Route::prefix('upload-image')->group(function () {
            Route::post('/store', function (Request $request) {

                $dataUploadFeatureImage = StorageImageTrait::storageTraitUpload($request, 'image');

                $item = SingpleImage::updateOrCreate([
                    'relate_id' => $request->id,
                    'table' => $request->table,
                ],[
                    'relate_id' => $request->id,
                    'table' => $request->table,
                    'image_path' => $dataUploadFeatureImage['file_path'],
                    'image_name' => $dataUploadFeatureImage['file_name'],
                ]);
                $item->refresh();

                return response()->json($item);

            })->name('ajax,administrator.upload_image.store');
        });

        Route::prefix('upload-multiple-images')->group(function () {

            Route::post('/store', function (Request $request) {

                $image = Image::create([
                    'uuid' => $request->id,
                    'table' => $request->table,
                    'image_path' => "waiting",
                    'image_name' => "waiting",
                    'relate_id' => $request->relate_id ?? 0,
                ]);

                $dataUploadFeatureImage = StorageImageTrait::storageTraitUpload($request, 'image');

                $dataUpdate = [
                    'image_path' => $dataUploadFeatureImage['file_path'],
                    'image_name' => $dataUploadFeatureImage['file_name'],
                ];

                $image->update($dataUpdate);
                $image->refresh();

                return response()->json($image);

            })->name('ajax,administrator.upload_multiple_images.store');

            Route::delete('/delete', function (Request $request) {
                $image = Image::find($request->id);
                if (empty($image)){
                    $image = Image::where('uuid', $request->id)->first();
                }
                if (!empty($image)){
                    $image->delete();
                }
                return response()->json($image);
            })->name('ajax,administrator.upload_multiple_images.delete');

            Route::put('/sort', function (Request $request) {

                foreach ($request->ids as $index => $id){
                    $image = Image::find($id);
                    if (empty($image)){
                        $image = Image::where('uuid', $id)->first();
                    }

                    if (!empty($image)){
                        $image->update([
                            'index' => $index
                        ]);
                    }
                }

                return response()->json($request->ids);
            })->name('ajax,administrator.upload_multiple_images.sort');

        });
    });
});

