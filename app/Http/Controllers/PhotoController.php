<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function image($fileName){
        $path = Storage::disk('public') .'/images/'.$fileName;
        return Response::download($path);        
    }
}