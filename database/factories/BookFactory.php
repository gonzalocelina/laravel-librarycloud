<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'author' => $this->faker->name(),
            'description' => $this->faker->text(),
            'genres' => $this->faker->randomElement([
                ['Biography', 'Text'],
                ['Interviews', 'text', 'government publication'],
                ['bibliography', 'Criticism', 'interpretation'],
                ['still image', 'Graphic novels', 'Comics (Graphic works)'],
            ]),
            'identifier' => $this->faker->bothify('????: ########'),
            'language' => $this->faker->randomElement(['Spanish', 'Polish', 'Swedish', 'Chinese']),
            'language_code' => $this->faker->word(),
            'title' => $this->faker->sentence(),
        ];
    }

    public function inEnglish()
    {
        return $this->state(function (array $attributes) {
            return [
                'language' => 'English',
                'language_code' => 'en',
            ];
        });
    }

    public function testGenres()
    {
        return $this->state(function (array $attributes) {
            return [
                'genres' => ['Science fiction', 'Science', 'Fiction'],
            ];
        });
    }

    public function testIdentifier()
    {
        return $this->state(function (array $attributes) {
            return [
                'identifier' => $this->faker->numerify('isbn: 123456789'),
            ];
        });
    }

    public function byTester()
    {
        return $this->state(function (array $attributes) {
            return [
                'author' => 'Tester Author',
            ];
        });
    }

    public function testDescription()
    {
        return $this->state(function (array $attributes) {
            return [
                // Using random string to avoid it being one of the generated
                'description' => 'kdsa8743mkczxuehdkdgcasdiuwvrewd',
            ];
        });
    }

    public function testTitle()
    {
        return $this->state(function (array $attributes) {
            return [
                // Using random string to avoid it being one of the generated
                'title' => 'nfdgvn43587hfdshwehwtusdv786sdbhmasd',
            ];
        });
    }


}
