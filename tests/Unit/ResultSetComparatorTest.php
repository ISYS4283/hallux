<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Validators\ResultSetComparator;

class ResultSetComparatorTest extends TestCase
{
    public function test_can_compare_matching_result_sets()
    {
        $data = [
            [1,2,3],
            ['one','two','three'],
        ];

        $comparator = new ResultSetComparator;

        $this->assertTrue($comparator->match($data, $data));
    }

    public function test_can_compare_different_result_sets()
    {
        $a = [
            [1,2,3],
            ['one','two','three'],
        ];

        $b = [
            [1,2,5],
            ['one','six','three'],
        ];

        $expected = '<thead><tr><th>0</th><th>1</th><th>2</th></tr></thead><tbody><tr><td>1</td><td>2</td><td class="danger">3</td></tr><tr><td>one</td><td class="danger">two</td><td>three</td></tr></tbody>';

        $comparator = new ResultSetComparator;

        $this->assertSame($expected, $comparator->match($a, $b));
    }
}
