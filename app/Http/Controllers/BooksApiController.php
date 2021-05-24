<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksApiController extends Controller
{

    /**
     * Retrieve Books from database
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBooks(Request $request)
    {
        $query = $request->query();

        return Book::queryBooks($query);
    }

}
