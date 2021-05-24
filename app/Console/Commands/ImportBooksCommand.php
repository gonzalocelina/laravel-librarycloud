<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Services\LibraryCloudApiService;
use Illuminate\Console\Command;

class ImportBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:import {--a|author= : Author of the book} {--g|genre= : Genre of the book}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import books to the DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param LibraryCloudApiService $apiService
     */
    public function handle(LibraryCloudApiService $apiService)
    {
        $author = $this->option('author');
        $genre = $this->option('genre');

        $booksResponse = $apiService->queryBooks($author, $genre);
        $booksArray = $apiService->formatResponse($booksResponse);

        foreach ($booksArray as $bookData) {
            // Ideally it'll check by identifier. If there's no data on it, it'll check by title
            $checkBy = $bookData['identifier'] ? ['identifier' => $bookData['identifier']] : ['title' => $bookData['title']];

            Book::updateOrCreate($checkBy, $bookData);
        }

        $this->info(sprintf("%d books where processed", count($booksArray)));
    }
}
