<?php

namespace App\Listeners;

use App\Events\FileWasUploaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class MoveToCloud implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FileWasUploaded  $event
     * @return void
     */
    public function handle(FileWasUploaded $event)
    {
        return;
        $path = Storage::drive("s3")->put($event->file->path,new File($event->file->path));
        $event->file->url = Storage::drive("s3")->url($path);
        $event->file->save();
    }
}
