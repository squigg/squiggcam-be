<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VideoController extends Controller
{

    public function video($filename = '')
    {
        str_replace('/modet/', '', $filename);
        $path = storage_path('video/motion/' . $filename);
        if (!\File::exists($path)) {
            throw new NotFoundHttpException('File does not exist: ' . $path);
        }
        return response()->file($path);
    }
}
