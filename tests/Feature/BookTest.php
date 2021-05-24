<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    const TEST_CASES = [
        [
            'name' => 'No query case',
            'query' => [],
            'expected_count' => 50,
            'expected_values' => [],
        ],
        [
            'name' => 'Query with limit',
            'query' => ['limit' => 100],
            'expected_count' => 100,
            'expected_values' => [],
        ],
        [
            'name' => 'Query for english language',
            'query' => ['limit' => 10000000, 'language' => 'English'],
            'expected_count' => 110,
            'expected_values' => [
                'language' => 'English'
            ],
        ],
        [
            'name' => 'Query for genre',
            'query' => ['limit' => 10000000, 'genres' => 'Science'],
            'expected_count' => 120,
            'expected_values' => [
                'genres' => ['Science fiction', 'Science', 'Fiction'],
            ],
        ],
        [
            'name' => 'Query for identifier',
            'query' => ['limit' => 10000000, 'identifier' => '123456789'],
            'expected_count' => 130,
            'expected_values' => [
                'identifier' => 'isbn: 123456789'
            ],
        ],
        [
            'name' => 'Query for author',
            'query' => ['limit' => 10000000, 'author' => 'Tester Author'],
            'expected_count' => 140,
            'expected_values' => [
                'author' => 'Tester Author'
            ],
        ],
        [
            'name' => 'Query for description',
            'query' => ['limit' => 10000000, 'description' => 'kdsa8743mkcz'],
            'expected_count' => 150,
            'expected_values' => [
                'description' => 'kdsa8743mkczxuehdkdgcasdiuwvrewd'
            ],
        ],
        [
            'name' => 'Query for title',
            'query' => ['limit' => 10000000, 'title' => 'gvn43587hfdshwehwtusdv786sdbh'],
            'expected_count' => 160,
            'expected_values' => [
                'title' => 'nfdgvn43587hfdshwehwtusdv786sdbhmasd'
            ],
        ],
        [
            'name' => 'Query for everything',
            'query' => [
                'limit' => 10000000,
                'language' => 'English',
                'genres' => 'Science',
                'identifier' => '123456789',
                'author' => 'Tester Author',
                'description' => 'kdsa8743mkcz',
                'title' => 'gvn43587hfdshwehwtusdv786sdbh',
            ],
            'expected_count' => 100,
            'expected_values' => [
                'language' => 'English',
                'genres' => ['Science fiction', 'Science', 'Fiction'],
                'identifier' => 'isbn: 123456789',
                'author' => 'Tester Author',
                'description' => 'kdsa8743mkczxuehdkdgcasdiuwvrewd',
                'title' => 'nfdgvn43587hfdshwehwtusdv786sdbhmasd',
            ],
        ],
    ];

    /**
     * Test different queries
     *
     * @return void
     */
    public function testQueryBooks()
    {
        foreach (self::TEST_CASES as $tc) {
            $books = Book::queryBooks($tc['query']);
            $booksCount = count($books);
            $this->assertEquals($tc['expected_count'], $booksCount, sprintf(
                'Expected %d results and got %d on %s',
                $tc['expected_count'],
                $booksCount,
                $tc['name']
            ));
            foreach ($tc['expected_values'] as $attr => $expectedValue) {
                $randomKey = random_int(0, $booksCount - 1);
                $this->assertEqualsCanonicalizing($expectedValue, $books[$randomKey]->$attr, sprintf(
                    'Expected %s to be %s and got %s on %s',
                    $attr,
                    is_array($expectedValue) ? json_encode($expectedValue) : $expectedValue,
                    is_array($books[$randomKey]->$attr) ? json_encode($books[$randomKey]->$attr) : $books[$randomKey]->$attr,
                    $tc['name'],
                ));
            }
        }
    }
}

