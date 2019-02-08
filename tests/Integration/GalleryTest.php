<?php

namespace Tests\Integration;

use \Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GalleryTest extends TestCase
{
    private $validUser;
    private $fakeSession;
    private $galleryFaker;

    public function setUp()
    {
        parent::setUp();
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);
        $this->fakeSession = ['_token'=> 'myfakefoken'];
        $this->validUser = factory(\App\User::class)->create([
            'first_name' => 'Test',
            'last_name' => 'Testing',
            'email' => 'test@test.com',
            'password' => bcrypt('test123')
        ]);

        $this->galleryFaker = factory(\App\Gallery::class)->create([
            'name' => 'Test gallery name',
            'user_id' => $this->validUser->id,
        ]);
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

    /**
     * @test
     * @group integration
     */
    public function user_can_see_galleries()
    {
        //mock user that has a galleries
        //assert that on get of galleries the json contains "Show all galleries!"

        $response = $this->call('GET', '/galleries');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Show all galleries!',
            ]);
    }

    /**
     * @test
     * @group integration
     */
    public function user_can_see_all_images_that_he_has_uploaded()
    {
        $this->withSession($this->fakeSession);
        $file = factory(\App\File::class)->create();
        $imageFaker = factory(\App\Image::class)->create([
            'gallery_id' => $this->galleryFaker->id,
            'file_id' => $file->id,
        ]);
        $fakedImages = new \stdClass();

        //$fakedImages->storagePath = 
        /*
            $image->storagePath = $this->getImage($file->pathToFile);
            $image->name = $file->originalName;
            $image->info = $file;
            $image->thumbnail = $this->getThumbnailWithSize($file->pathToFile, $size);
        
        */
        $imageService = Mockery::mock('overload:'.Illuminate\Support\Facades\Auth::class)->makePartial();
        $imageService
            ->shouldReceive('getMultipleImages')
            ->with($file::where('user_id', auth()->id()))
            ->once()
            ->andReturn($fakedImages);

        $this->actingAs($this->validUser);
        
        
        $response = $this->call('GET', '/galleries/create');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Show all Images that the user has uploaded!'
            ]);
        //mock that the user has some uploaded images
        //assert that on get of galleries/new the json contains "Show all Images that the user has uploaded!"
    }

    /**
     * @test
     * @group integration
     */
    public function user_can_create_new_gallery_with_valid_gallery_name()
    {
        //mock the user 
        //make request to /galleries/create
        //assert that the response is "New Gallery was added successfully!', ['id' => $galleryId]"
        //galleryName: name
        $this->actingAs($this->validUser);
        $galleryFake = ['galleryName' => 'testgalleryname'];
        $galleryModelFaker = Mockery::mock('overload:'.App\Gallery::class)->makePartial();
        $galleryModelFaker
            ->shouldReceive('create')
            ->with($galleryFake)
            ->once()
            ->andReturn(['id' => 2]);
        $response = $this->call('POST', '/galleries', $galleryFake);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'New Gallery was added successfully!',
                'data' => ['id' => 2]
            ]);
    }

    /**
     * @test
     * @expectedException Illuminate\Validation\ValidationException
     * @group integration
     */
    public function user_can_not_create_new_gallery_with_invalid_gallery_name()
    {
        //@expectedException Illuminate\Validation\ValidationException
        //mock the user 
        //make request to /galleries/create
        //assert that the response is "New Gallery was added successfully!', ['id' => $galleryId]"
        //galleryName: name
        $this->actingAs($this->validUser);
        $galleryRequestParams = [
            'galleryName' => ''
        ];
        // $mockGalleryRequest = Mockery::mock('overload:'.App\Http\Requests\StoreGallery::class)->makePartial();
        // $mockGalleryRequest
        //     ->shouldReceive('validated')
        //     ->with($galleryFake)
        //     ->once()
        //     ->andReturn(false);
        //$method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null
        $response = $this->call('POST', '/galleries', $galleryRequestParams);
     
        $response->assertSessionHasErrors('galleryName');
        $response
            ->assertStatus(302)
            ->assertJsonValidationErrors('galleryName');
    }


}
