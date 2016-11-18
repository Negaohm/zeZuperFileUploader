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
        "thumbnail_url",
        "original_filename"
    ];
    public function scopeLastTen($query)
    {
        return $query->orderBy("created_at","desc")->take(10);
    }
    public function scopeFromToday($query)
    {
        return $query->where("created_at",">=",Carbon::today())->orderBy("created_at","desc")->take(10);
    }
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
      return storage_path("app/".$this->attributes["filename"]);
    }
    public function setFilenameAttribute($value)
    {
        $this->attributes["original_filename"] = $value;
        //make a hash out of the filename, album id, original filename and date
        $this->attributes["filename"] = Str::slug(Hash::make($value.$value.Carbon::now()->toTimeString()));
    }
    public function getFilenameAttribute()
    {
        return $this->attributes["filename"];
    }
    public function getOriginalFilenameAttribute()
    {
        return $this->attributes["original_filename"];
    }

}
