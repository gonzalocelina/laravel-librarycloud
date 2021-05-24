<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    const DEFAULT_LIMIT = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'author',
        'genres',
        'identifier',
        'language',
        'language_code',
    ];

    /**
     * Get the genres attribute as an array
     *
     * @param $value
     *
     * @return array
     */
    public function getGenresAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Set the genres of the Book
     *
     * @param $value
     */
    public function setGenresAttribute($value)
    {
        $this->attributes['genres'] = json_encode($value);
    }

    /**
     * Query the database for Books
     *
     * @param array $query
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function queryBooks(array $query)
    {
        $queryBuilder = self::query();

        foreach ($query as $field => $value) {
            if ($field == 'limit') {
                continue;
            }
            $queryBuilder->where($field, 'like', '%' . $value . '%');
        }
        $limit = isset($query['limit']) ? $query['limit'] : self::DEFAULT_LIMIT;

        $queryBuilder->limit($limit);

        return $queryBuilder->get();
    }
}
