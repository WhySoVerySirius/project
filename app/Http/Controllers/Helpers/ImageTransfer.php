<?php

namespace App\Http\Controllers\Helpers;

use App\Events\ImageDelete;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageTransfer extends Controller
{
    public static function transfer(
        $object,
        UploadedFile $file,
        string $storeLocation
    ): bool|string {
        if ($object->file) {
            try {
                Storage::delete($object->image);
            } catch (\Throwable $th) {
                ImageDelete::dispatch($th);
            }
        }
        if ($path = Storage::putFile($storeLocation, $file)) {
            return $path;
        };
        return false;
    }
}
