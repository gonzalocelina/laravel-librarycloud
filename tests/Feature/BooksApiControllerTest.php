<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BooksApiControllerTest extends TestCase
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
            'query' => '',
            'expected_count' => 50,
            'expected_values' => [
                'id' => 1,
                'language' => 'English',
            ],
        ],
        [
            'name' => 'Limit',
            'query' => '?limit=200',
            'expected_count' => 200,
            'expected_values' => [
                'id' => 1,
                'language' => 'English',
            ],
        ],
        [
            'name' => 'Simple Query',
            'query' => '?author=Tester&limit=3000',
            'expected_count' => 140,
            'expected_values' => [
                'author' => 'Tester Author',
            ],
        ],
        [
            'name' => 'Complex Query',
            'query' => '?author=Tester&identifier=123456789&limit=3000',
            'expected_count' => 100,
            'expected_values' => [
                'identifier' => 'isbn: 123456789',
                'author' => 'Tester Author',
            ],
        ],
    ];

    /**
     * Testing the API GET endpoint
     *
     * @return void
     */
    public function testGetBooks()
    {
        foreach (self::TEST_CASES as $tc) {
            $response = $this->getJson('/api/books' . $tc['query']);
            $response->assertStatus(200);
            $response->assertJson(function (AssertableJson $json) use ($tc) {
                $json->has($tc['expected_count'])->first(function ($json) use ($tc) {
                    foreach ($tc['expected_values'] as $attr => $expectedValue) {
                        $json->where($attr, $expectedValue);
                    };
                    $json->etc();
                });
            }, sprintf(
                'Test case %s failed',
                $tc['name'],
            ));

        }
    }
}
