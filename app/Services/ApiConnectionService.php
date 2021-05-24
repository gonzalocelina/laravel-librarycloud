<?php
namespace App\Services;

use App\Models\Book;
use GuzzleHttp\Client;
use \Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\str;

class ApiConnectionService
{
    /**
     * Gets the results from a GET Request
     *
     * @param string $url
     * @param array $query
     *
     * @return ResponseInterface
     */
    public function get(string $url, array $query): ResponseInterface
    {
        $client = new Client();

        return $client->get($url, ['query' => $query]);
    }
}
