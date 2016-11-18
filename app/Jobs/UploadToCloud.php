<?php

namespace App\Jobs;
use App\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\File;
use Aws\S3\Exception\S3Exception;
class UploadToCloud implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
    * @var $file Image
    */
    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $file)
    {

        $this->file= $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      try{
        //TODO handle job failure.... because now it will fail...no aws
        $path = \Storage::cloud()->putFileAs($this->file->filename,new File($this->file->path),"public");
        $this->file->url = Storage::cloud()->url($path);
        $path = ImageManipulation::createThumbnail($this->file->path);//create the thumbnail
        $path = \Storage::cloud()->putFileAs($this->file->filename,new File($this->file->path),"public");
        $this->file->thumbnail_url = Storage::cloud()->url($path);
        $this->file->save();
      }
      catch(S3Exception $e)
      {
        return ;
      }

    }
}
