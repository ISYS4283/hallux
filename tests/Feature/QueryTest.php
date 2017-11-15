<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Query;

class QueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_queries()
    {
        $this->signInAdmin();

        $queries = create(Query::class, [], 5);

        $response = $this->get('/queries');

        foreach ($queries as $query) {
            $response->assertSeeText($query->description);
        }
    }

    public function test_user_can_not_list_queries()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $queries = create(Query::class);

        $this
            ->get('/queries')
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_show_query()
    {
        $this->signInAdmin();

        $query = create(Query::class);

        $this
            ->get("/queries/{$query->id}")
            ->assertSeeText($query->description)
        ;
    }

    public function test_user_can_not_show_query()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $query = create(Query::class);

        $this
            ->get("/queries/{$query->id}")
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_create_query()
    {
        $this->signInAdmin();

        $query = make(Query::class);

        $response = $this
            ->post('/queries', $query->toArray())
            ->assertStatus(302)
        ;

        $this
            ->get($response->headers->get('Location'))
            ->assertSeeText($query->description)
        ;
    }

    public function test_user_can_not_create_query()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $query = make(Query::class);

        $response = $this
            ->post('/queries', $query->toArray())
            ->assertStatus(403)
        ;
    }
}
