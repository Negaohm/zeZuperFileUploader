<?php

namespace App\Http\Controllers;

use App\Album;
use App\Events\FileWasUploaded;
use App\Http\Requests\AvatarUploadRequest;
use App\Http\Requests\FileUploadRequest;
use App\Image;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use Storage;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    public function upload(FileUploadRequest $request)
    {
        $f = $request->file("file");
        if($request->has("avatar"))
            $album = null;
        else
            $album = Album::findOrFail($request->get("album"));

        $image = new Image();
        $image->filename = $f->getClientOriginalName();
        $image->album_id = $album->id;
        $image->user_id = Auth::user()->id;
        $image->save();
        Storage::put($image->filename, file_get_contents($f->getRealPath()));
        $this->uploadFileToS3($image);
        if($request->ajax())
            return $image;//just return the model
        return redirect()->to(route("album.show",$album->id))->with("message","Image uploaded successfully");
    }
    public function avatar(FileUploadRequest $request)
    {
      abort(403,"not now yet");
    }

    public function uploadFileToS3($image){
      $s3 = \Storage::disk('s3');
      $filePath =  '/joel/'.$image->filename;
      $s3->put($filePath, file_get_contents($image->path));
      $image->url = \Storage::url($filePath);
      $image->save();
    }

    public function s3details()
    {
      return response()->json(\App\Lib\S3Helpers::getS3Details());
    }

}
