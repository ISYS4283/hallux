<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Query;

class QueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_queries()
    {
        $queries = create(Query::class, [], 5);

        $response = $this->get('/queries');

        foreach ($queries as $query) {
            $response->assertSeeText($query->description);
        }
    }

    public function test_can_show_query()
    {
        $query = create(Query::class);

        $this
            ->get("/queries/{$query->id}")
            ->assertSeeText($query->description)
        ;
    }

    public function test_can_create_query()
    {
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
}
