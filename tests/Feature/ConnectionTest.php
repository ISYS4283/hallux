<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Connection;

class ConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_can_list_connections()
    {
        $this->signInAdmin();

        $connections = create(Connection::class, [], 5);

        $response = $this->get('/connections');

        foreach ($connections as $connection) {
            $response->assertSeeText($connection->name);
        }
    }

    public function test_users_can_not_list_connections()
    {
        $this->withExceptionHandling();
        $this->signIn();

        create(Connection::class);

        $this
            ->get('/connections')
            ->assertStatus(403)
        ;
    }

    public function test_can_show_connection()
    {
        $this->signInAdmin();

        $connection = create(Connection::class);

        $this
            ->get("/connections/{$connection->name}")
            ->assertSee($connection->config['host'])
        ;
    }

    public function test_user_can_not_view_connection()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $connection = create(Connection::class);

        $this
            ->get("/connections/{$connection->name}")
            ->assertStatus(403)
        ;
    }

    public function test_can_create_connection()
    {
        $this->signInAdmin();

        $connection = make(Connection::class);

        $response = $this
            ->post('/connections', $connection->toArray())
            ->assertStatus(302)
        ;

        $this
            ->get($response->headers->get('Location'))
            ->assertSeeText($connection->name)
            ->assertSeeText($connection->config['host'])
        ;
    }

    public function test_user_can_not_create_connection()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $connection = make(Connection::class);

        $response = $this
            ->post('/connections', $connection->toArray())
            ->assertStatus(403)
        ;
    }
}
