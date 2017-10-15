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
}
