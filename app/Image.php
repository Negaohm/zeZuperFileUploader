<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Image extends Model
{
    protected $table = "images";
    protected $fillable = [
        "url",
        "filename"
    ];
    protected $attributes = [
        "path",
        "url",
        "filename",
        "folder"
    ];
    public function getPathAttribute()
    {
        return  $this->folder ."/". $this->filename;
    }
    public function getFilenameAttribute()
    {
        return Hash::make($this->id.$this->filename);
    }
    public function getFolderAttribute()
    {
        return $this->album()->path;
    }

}
