<?php

namespace App\Http\Controllers;

use App\Album;
use App\Events\FileWasUploaded;
use App\Http\Requests\AvatarUploadRequest;
use App\Http\Requests\FileUploadRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function __construct()
    {
    }
    public function upload(FileUploadRequest $request)
    {
        $f = $request->file("image");
        if($request->has("avatar"))
            $album = null;
        else
            $album = Album::findOrFail($request->get("album"));

        $user = Auth::user();
        $image = new Image();
        $image->user = $user;
        $image->filename = $f->getFilename();

        $image->album()->save($album);
        $image->save();

        $f->storeAs($image->folder,$image->filename);
        event(new FileWasUploaded($image));
        if($request->ajax())
            return $image;//just return the model
        return redirect()->to("/home");
    }


}
