<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Connection;

class ConnectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_connections()
    {
        $connections = create(Connection::class, [], 5);

        $response = $this->get('/connections');

        foreach ($connections as $connection) {
            $response->assertSeeText($connection->name);
        }
    }

    public function test_can_show_connection()
    {
        $connection = create(Connection::class);

        $this
            ->get("/connections/{$connection->name}")
            ->assertSee($connection->config['host'])
        ;
    }

    public function test_can_create_connection()
    {
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
}
