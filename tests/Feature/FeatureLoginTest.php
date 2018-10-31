<?php

namespace Tests\Feature;

use App\User;
use PHPUnit\Util\Json;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFailedLogin()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(401)
            ->assertJson([ 'error' => 'Unauthorized' ]);
    }

    public function testSuccessfulLoginAndLogout()
    {
        $this->json('POST', '/api/auth/logout', [], $this->getAuth())
            ->assertStatus(200);
    }
}
