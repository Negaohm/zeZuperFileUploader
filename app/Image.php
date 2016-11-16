<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Image extends Model
{
    use SoftDeletes;
    protected $table = "images";
    protected $fillable = [
        "url",
        "filename",

    ];
    protected $attributes = [
        "path",
        "url"
    ];
    
    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function getUrlAttribute($value)
    {
        return $this->attributes["url"] !== null ?: route("image.raw",$this);
    }
    public function getPathAttribute($value)
    {
        return $this->attributes["filename"];
    }
    public function setFilenameAttribute($value)
    {
        //make a hash out of the filename, album id, original filename and date
        return $this->attributes["filename"] = Hash::make($this->attributes["filename"].$this->album()->id.$value.$value.Carbon::now());
    }



}
