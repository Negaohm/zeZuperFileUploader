<?php

use App\Image;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadFile extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFileUpload()
    {
        Auth::onceUsingId(1);
        $before = Image::all()->count();
        $this->visit("/upload/image")
            ->attach(new File(storage_path("tests/img.jpg")),"image")
            ->press("upload");
        $this->assertResponseOk();

        $after = Image::all()->count();
        $this->assertGreaterThan($after,$before);
        $last = Image::all()->last();
        $this->assertFileExists(storage_path($last->path));


    }
}
