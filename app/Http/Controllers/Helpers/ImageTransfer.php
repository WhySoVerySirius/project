<?php

namespace App\Http\Controllers\Helpers;

use App\Events\ImageDelete;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageTransfer extends Controller
{
    public static function transfer($model, UploadedFile $file): bool|string
    {
        if ($model->file) {
            try {
                Storage::delete($model->image);
            } catch (\Throwable $th) {
                ImageDelete::dispatch($th);
            }
        }
        if ($path = Storage::putFile('photos', $file)) {
            return $path;
        };
        return false;
    }
}
