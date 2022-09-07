<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait StorageImageTrait
{
    public static function storageTraitUpload($request, $fieldName, $folderName)
    {

        if ($request->hasFile($fieldName)) {
            $folderName = "/assets/images/" . $folderName;
            $file = $request->$fieldName;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $filePath = $request->file($fieldName)->storeAs($folderName . '/original', $fileNameHash, ['disk' => 'public']);
            $dataUpluadTrait = [
                'file_name' => $fileNameOrigin,
//                'file_path' => Storage::url($filePath),
                'file_path' => '/' . $filePath,
            ];

            // for save thumnail image
            $ImageUpload = Image::make($file);
            $ImageUpload->save(public_path() . $folderName . '/original/' . $fileNameHash);

            $ImageUpload = Image::make($file);
            $ImageUpload->fit(300, 300);
            $ImageUpload->save(public_path() . $folderName . '/300x300/' . $fileNameHash);

            $ImageUpload = Image::make($file);
            $ImageUpload->fit(100, 100);
            $ImageUpload->save(public_path() . $folderName . '/100x100/' . $fileNameHash);

            $ImageUpload = Image::make($file);
            $ImageUpload->fit(500, 500);
            $ImageUpload->save(public_path() . $folderName . '/500x500/' . $fileNameHash);

            $ImageUpload = Image::make($file);
            $ImageUpload->fit(200, 200);
            $ImageUpload->save(public_path() . $folderName . '/200x200/' . $fileNameHash);

            $ImageUpload = Image::make($file);
            $ImageUpload->fit(1000, 1000);
            $ImageUpload->save(public_path() . $folderName . '/1000x1000/' . $fileNameHash);

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
