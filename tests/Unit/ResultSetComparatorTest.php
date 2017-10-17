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
            (object)[
                'first' => 1,
                'second' => 2,
                'third' => 3,
            ],
            (object)[
                'first' => 'one',
                'second' => 'two',
                'third' => 'three',
            ],
        ];

        $comparator = new ResultSetComparator;

        $this->assertTrue($comparator->match($data, $data));
    }

    public function test_can_compare_different_result_sets()
    {
        $a = [
            (object)[
                'first' => 1,
                'second' => 2,
                'third' => 3,
            ],
            (object)[
                'first' => 'one',
                'second' => 'two',
                'third' => 'three',
            ],
        ];

        $b = [
            (object)[
                'first' => 1,
                'second' => 2,
                'third' => 5,
            ],
            (object)[
                'first' => 'one',
                'second' => 'six',
                'third' => 'three',
            ],
        ];

        $expected = '<thead><tr><th>first</th><th>second</th><th>third</th></tr></thead><tbody><tr><td>1</td><td>2</td><td class="danger">3</td></tr><tr><td>one</td><td class="danger">two</td><td>three</td></tr></tbody>';

        $comparator = new ResultSetComparator;

        $this->assertSame($expected, $comparator->match($a, $b));
    }
}
