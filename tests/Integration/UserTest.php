<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\User;
use \Mockery;
use Illuminate\Foundation\Testing\WithFaker;

class UserTest extends TestCase
{

    private $validUser;
    private $fakeSession;

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

    public function tearDown()
    {
        Mockery::getContainer()->mockery_close();
    }

    /**
     * @test
     * @group integration
     */
    public function user_can_login_with_valid_ctedentials()
    {
        $user = ['email' => 'test@test.com','password' => 'test123'];

        $authFasade = Mockery::mock('overload:'.Illuminate\Support\Facades\Auth::class)->makePartial();

        $authFasade->shouldReceive('attempt')
            ->once()
            ->andReturn(false);
        $authFasade->shouldReceive('attempt')
            ->andReturn(true);

        $response = $this->call('POST', '/login', $user);
        $authFasade::attempt($user);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login success',
            ]);
    }

    /**
     * @test
     * @group integration
     */
    public function user_can_not_login_whith_invalid_credentials()
    {
        $user = ['email' => 'invaliduser@test.com','password' =>'incorect'];

        $authFasade = Mockery::mock('overload:'.Illuminate\Support\Facades\Auth::class)->makePartial();

        $authFasade->shouldReceive('attempt')
            ->once()
            ->andReturn(false);

        $response = $this->call('POST', '/login', $user);
        $authFasade::attempt($user);
        
        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'These credentials do not match our records.'
            ]);
        $this->assertInvalidCredentials($user);
    }

    /**
     * @test
     * @group integration
     */
    public function user_can_logout()
    {
        $this->withSession($this->fakeSession);
        $authFasade = Mockery::mock('overload:'.Illuminate\Support\Facades\Auth::class)->makePartial();
        $authFasade->shouldReceive('logout')->once();

        $this->actingAs($this->validUser);

        $this->assertAuthenticated();
        $response = $this->call('POST','/logout');
        $authFasade::logout();
        $this->assertGuest();
        $response->assertSessionHas('_token');
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout success'
            ]);
    }
}
