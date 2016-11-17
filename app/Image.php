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
        "album_id",
        "user_id"
    ];
    protected $appends = [
        "path",
        "filename",
        "url",
        "thumbnail_url"
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getUrlAttribute()
    {
        return array_key_exists("url",$this->attributes) ?: route("image.raw",$this);
    }
    public function getThumbnailUrlAttribute()
    {
        return array_key_exists("thumbnail_url",$this->attributes) ?: route("image.thumbnail",$this);
    }
    public function getPathAttribute()
    {
        return storage_path("app/".$this->attributes["filename"]); //with the bcrypt signature we have, it should always be unique, and unreversible
    }
    public function setFilenameAttribute($value)
    {
        //make a hash out of the filename, album id, original filename and date
        $this->attributes["original_filename"] = $value;
        $this->attributes["filename"] = Str::slug(Hash::make($value.$value.Carbon::now()->toTimeString()));
    }

}
