<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // In english
        Book::factory()
            ->count(10)
            ->inEnglish()
            ->create();

        // Test genres
        Book::factory()
            ->count(20)
            ->testGenres()
            ->create();

        // Test identifier
        Book::factory()
            ->count(30)
            ->testIdentifier()
            ->create();

        // Tester author
        Book::factory()
            ->count(40)
            ->byTester()
            ->create();

        // Test description
        Book::factory()
            ->count(50)
            ->testDescription()
            ->create();

        // Test title
        Book::factory()
            ->count(60)
            ->testTitle()
            ->create();

        // All of the above
        Book::factory()
            ->count(100)
            ->inEnglish()
            ->testGenres()
            ->testIdentifier()
            ->byTester()
            ->testDescription()
            ->testTitle()
            ->create();

    }
}
