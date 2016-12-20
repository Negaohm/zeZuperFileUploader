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
        "user_id",
        "thumbnail_url",
        "url"
    ];
    protected $appends = [
        "path",
        "filename",
        "url",
        "thumbnail_url",
        "original_filename"
    ];
        /**
     * Create temporary URLs to your protected Amazon S3 files.
     *
     * @param string $key Your Amazon S3 access key
     * @param string $secret Your Amazon S3 secret key
     * @param string $bucket The bucket (bucket.s3.amazonaws.com)
     * @param string $path The target file path
     * @param int $expiry In minutes
     * @return string Temporary Amazon S3 URL
     * @see http://awsdocs.s3.amazonaws.com/S3/20060301/s3-dg-20060301.pdf
     */
    function getS3TemporaryUrl($path, $expiry = 30)
    {
        $key = config('filesystems.disks.s3.key');
        $secret = config('filesystems.disks.s3.secret');
        $bucket = config('filesystems.disks.s3.bucket');
        $expiry = time() + $expiry * 60;

        // Format the string to be signed
        $string = sprintf("GET\n\n\n%s\n/%s/%s", $expiry, $bucket, $path);

        // Generate an HMAC-SHA1 signature for it
        $signature = base64_encode(hash_hmac('sha1', $string, $secret, true));

        // Create the final URL
        return sprintf(
            "%s?%s",
            $path,
            http_build_query([
                'AWSAccessKeyId' => $key,
                'Expires' => $expiry,
                'Signature' => $signature
            ])
        );
    }

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
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function getUrlAttribute()
    {
        return array_key_exists("url",$this->attributes) && $this->attributes["url"] !== null ? $this->getS3TemporaryUrl($this->attributes["url"]) : route("image.raw",$this);
    }
    public function getThumbnailUrlAttribute()
    {
      return array_key_exists("thumbnail_url",$this->attributes)&& $this->attributes["thumbnail_url"] !== null ? $this->attributes["thumbnail_url"] : route("image.thumbnail",$this);
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
