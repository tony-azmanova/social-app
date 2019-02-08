<?php

namespace Tests\Unit;

use \Mockery;
use Tests\TestCase;
use App\Services\ImageService;
use App\Http\Controllers\GalleryController;

class GalleryTest extends TestCase
{
    protected $mockedImageService;
    protected $galleryController;

    public function setUp()
    {
        parent::setUp();

        $this->mockedImageService = Mockery::mock(ImageService::class);
        $this->app->instance(ImageService::class, $this->mockedImageService);
        $this->galleryController = new GalleryController($this->mockedImageService);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    protected function jsonResponseSuccessFaker($myFakeMassage, $fakeData)
    {
        $jsonResponseSuccessFaker = new \stdClass();
        $jsonResponseSuccessFaker->success = true;
        $jsonResponseSuccessFaker->status = "success";
        $jsonResponseSuccessFaker->message = $myFakeMassage;
        $jsonResponseSuccessFaker->data = $fakeData;

        return $jsonResponseSuccessFaker;
    }

    protected function jsonResponseErrorFaker($myFakeMassage)
    {
        $jsonResponseErrorFaker = new \stdClass();
        $jsonResponseErrorFaker->success = false;
        $jsonResponseErrorFaker->status = "error";
        $jsonResponseErrorFaker->message = $myFakeMassage;

        return $jsonResponseErrorFaker;
    }

    protected function getFakeFile()
    {
        $fakeFile = new \stdClass();
        $fakeFile->id = 1;
        $fakeFile->originalName = "nature1.jpg";
        $fakeFile->pathToFile = "files/images/avatars/141/kEm3Ldy9jc2PYvTfw21H9FO1nLzFGBWpxe1akzGn.jpeg";
        $fakeFile->mimeType = "image/jpeg";
        $fakeFile->user_id = 141;
        $fakeFile->created_at = "2018-12-12 15:40:19";
        $fakeFile->updated_at = "2018-12-12 15:40:19";

        return $fakeFile;
    }

    protected function getFakeFiles()
    {
        $fakeFiles = new \stdClass();
        $fakeFiles->storagePath = "storage/files/images/default/no_image_found.png";
        $fakeFiles->name = "nature1.jpg";
        $fakeFiles->info = $this->getFakeFile();
        $fakeFiles->thumbnail = "/storage/files/images/avatars/141/thumbnails/kEm3Ldy9jc2PYvTfw21H9FO1nLzFGBWpxe1akzGn_200.jpeg";
        $filesResults = new \stdClass();
        $filesResults->image[] = $fakeFiles;

        return $filesResults;
    }

    protected function getFakeGallery()
    {
        $fakeGallery = new \stdClass();
        $fakeGallery->name = 'Test gallery name';
        $fakeGallery->user_id = 1;

        return $fakeGallery;
    }

    protected function getFakeImage()
    {
        $fakeImage = new \stdClass();
        $fakeImage->gallery_id = 1;
        $fakeImage->file_id = 1;

        return $fakeImage;
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function user_can_see_galleries()
    {
        $fakeGallery = $this->getFakeGallery();
        $fakeGalleryResults = $this->getFakeGallery();

        $galleryModelFaker = Mockery::mock('overload:'.\App\Gallery::class)->makePartial();
        $galleryModelFaker
            ->shouldReceive('get')
            ->andReturn(collect($fakeGallery));
        $galleryModelFaker
            ->shouldReceive('where')
            ->andReturn($galleryModelFaker);
        $galleryModelFaker
            ->shouldReceive('isEmpty')
            ->andReturn(false);

        $galleryResourceFaker = Mockery::mock('overload:'.\App\Http\Resources\Gallery::class)->makePartial();
        $galleryResourceFaker
            ->shouldReceive('collection')
            ->andReturn($fakeGallery);

        $actual = $this->galleryController->index()->getContent();

        $expected = json_encode($this->jsonResponseSuccessFaker('Show all galleries!', $fakeGalleryResults));
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function user_can_see_all_images_in_single_gallery()
    {
        $this->markTestSkipped('skip');
        $fakeGallery = $this->getFakeGallery();
        $fakeGalleryResults = $this->getFakeGallery();
        $fakeImage = $this->getFakeImage();

        $imageModelFaker = Mockery::mock('overload:'.\App\Image::class)->makePartial();

        $this->app->instance(\App\Image::class, $imageModelFaker);

        $galleryModelFaker = Mockery::mock('overload:'.\App\Gallery::class)->makePartial();
        $galleryModelFaker
            ->shouldReceive('findOrFail')
            ->andReturn(collect($fakeGallery));
        $galleryModelFaker
            ->shouldReceive('with')
            ->once()
            ->with($imageModelFaker)
            ->andReturn($galleryModelFaker);
        $imageModelFaker
            ->shouldReceive('isEmpty')
            ->andReturn(false);

        $galleryResourceFaker = Mockery::mock('overload:'.\App\Http\Resources\Gallery::class)->makePartial();
        $galleryResourceFaker
            ->shouldReceive('make')
            ->andReturn($fakeGallery);

        $actual = $this->galleryController->show(1)->getContent();

        $expected = json_encode($this->jsonResponseSuccessFaker('Show all galleries!', $fakeGalleryResults));
        $this->assertJsonStringEqualsJsonString($expected, $actual); 
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function user_can_see_all_images_that_he_has_uploaded()
    {
        $fakeFile = $this->getFakeFile();
        $filesResults = $this->getFakeFiles();

        $fileModelFaker = Mockery::mock('overload:'.\App\File::class)->makePartial();
        $fileModelFaker
            ->shouldReceive('get')
            ->andReturn(collect($fakeFile));
        $fileModelFaker
            ->shouldReceive('where')
            ->andReturn($fileModelFaker);
        $fileModelFaker
            ->shouldReceive('isEmpty')
            ->andReturn(false);
        $this->mockedImageService
            ->shouldReceive('getMultipleImages')
            ->andReturn($filesResults);

        $actual = $this->galleryController->showUploadedImages()->getContent();

        $expected = json_encode($this->jsonResponseSuccessFaker('Show all Images that the user has uploaded!', $filesResults->image));
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }

    /**
     * @test
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function user_sees_information_massage_if_he_has_not_uploaded_any_files()
    {
        $fileModelFaker = Mockery::mock('overload:'.\App\File::class)->makePartial();
        $fileModelFaker
            ->shouldReceive('get')
            ->andReturn(collect([]));
        $fileModelFaker
            ->shouldReceive('isEmpty')
            ->andReturn(true);
        $fileModelFaker
            ->shouldReceive('where')
            ->andReturn($fileModelFaker);

        $actual = $this->galleryController->showUploadedImages()->getContent();

        $expected = json_encode($this->jsonResponseErrorFaker('You haven\'t uploaded any files yet. To create a gallery start by uploading some images.', 404));
        $this->assertJsonStringEqualsJsonString($expected, $actual);
    }
}
