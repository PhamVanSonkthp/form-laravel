<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait StorageImageTrait
{
    public static function storageTraitUpload($request, $fieldName, $folderName = null)
    {

        if ($request->hasFile($fieldName)) {
            $folderName = "/assets/images";
            $file = $request->$fieldName;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $dataUpluadTrait = [
                'file_name' => $fileNameOrigin,
                'file_path' => $folderName . '/original/' . $fileNameHash,
            ];

            // for save thumnail image
            $ImageUpload = Image::make($file);
            if (!file_exists(public_path() . $folderName . '/original/')) {
                mkdir(public_path() . $folderName . '/original/', config('_images_cut_sizes.permission'), true);
            }
            $ImageUpload->save(public_path() . $folderName . '/original/' . $fileNameHash);

            foreach(config('_images_cut_sizes.sizes') as $size){

                $width = (int)explode("x",$size)[0];
                $height = (int)explode("x",$size)[1];

                $ImageUpload = Image::make($file);
                $ImageUpload->fit($width, $height);
                if (!file_exists(public_path() . $folderName . '/'.$width .'x'. $height .'/')) {
                    mkdir(public_path() . $folderName . '/'.$width .'x'. $height .'/', config('_images_cut_sizes.permission'), true);
                }
                $ImageUpload->save(public_path() . $folderName . '/'.$width .'x'. $height .'/' . $fileNameHash);
            }

            return $dataUpluadTrait;
        }

        return null;
    }

    public static function storageTraitUploadMultiple($file, $folderName)
    {

        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($folderName . '/' . auth()->id(), $fileNameHash, ['disk' => 'public']);
        $dataUpluadTrait = [
            'file_name' => $fileNameOrigin,
            'file_path' => Storage::url($filePath),
        ];

        return $dataUpluadTrait;
    }
}
