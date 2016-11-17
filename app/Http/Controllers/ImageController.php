<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageRequest;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth",["except"=>["raw","thumbnail"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view("image.index",["images"=>$request->user()->images()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('image.create');
    }

    /**
     * Should never come here, moved to UploadController@upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateImageRequest $request)
    {
        return abort(403);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view("image.show",$image);
    }

    /**
     * Returns the iamge content from s3
     * @param Image $image
     */
    public function raw(Image $image)
    {
        //dd($image->filename);
        //then go to local storage
        if(Storage::drive("local")->exists($image->filename))
            return response()->file(storage_path("app/".$image->filename));
        //first try out the cloud
        if(Storage::drive("s3")->exists($image->path))
            return response()->file(Storage::disk('s3')->get($image->path));
        abort(404);//not found
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        if(!$this->checkUserOnModel($image))
            abort(403);
        return view('image.edit',$image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(403,"you should have never came here");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        if(!$this->checkUserOnModel($image))
            abort(403);
        Storage::disk("s3")->delete($image->path);
        $image->delete();
        return redirect()->to("/images");
    }
    public function thumbnail(Request $request, Image $image)
    {
        $storage = \Storage::drive(env("FILESYSTEM_DRIVER",'local'));
        $path = storage_path("app/".$image->filename."_thumb");
        if(!$storage->exists($path))//if thumbnail doesnt exist, create it
        {
            $thumb = \Image::make(storage_path("app/".$image->filename));
            $thumb->fit(200,200);
            $thumb->save($path);
        }

        return response()->file($path);
    }

}
