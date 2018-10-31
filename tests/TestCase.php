<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    protected function contentTypeHeader()
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
    }

    protected function getAuth()
    {
        return ['Authorization' => "Bearer {$this->getToken()}"];
    }

    protected function getToken()
    {
        if (User::where('email', 'raymond@philippinedev.com')->count() === 0) {
            factory(User::class)->create([
                'email' => 'raymond@philippinedev.com',
            ]);
        }

        $payload = ['email' => 'raymond@philippinedev.com', 'password' => 'secret'];
        $result = $this->json('POST', '/api/auth/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([ 'access_token', 'token_type', 'expires_in']);

        return json_decode($result->content())->access_token;
    }
}
