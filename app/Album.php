<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    protected $table = "albums";
    protected $fillable = [
        "name",
        "description"
    ];
    protected $hidden = [
        "slug"
    ];
    protected $attributes = [
        "slug"
    ];
    protected function getSlugAttribute($value)
    {
        return Str::camel($this->attributes["name"]);
    }
    protected function user()
    {
        return $this->belongsTo(User::class);
    }
}
