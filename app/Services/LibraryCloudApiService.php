<?php
namespace App\Services;

use \Psr\Http\Message\ResponseInterface;

class LibraryCloudApiService
{
    /**
     * @var string Base URL of Library Cloud API
     */
    private $url = 'https://api.lib.harvard.edu/v2/items.dc.json';

    /**
     * 250 is max results set by the API
     *
     * @var int Limit of the queries
     */
    private $limit = 250;

    /**
     * @var ApiConnectionService
     */
    private $apiService;

    public function __construct(ApiConnectionService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Queries the Library Cloud API
     *
     * @param string|null $author
     * @param string|null $genre
     *
     * @return ResponseInterface
     */
    public function queryBooks(?string $author = null, ?string $genre = null): ResponseInterface
    {
        $query = ['limit' => $this->limit];

        if ($author) {
            $query['name'] = $author;
        }

        if ($genre) {
            $query['genre'] = $genre;
        }

        return $this->apiService->get($this->url, $query);
    }

    /**
     * Formats the API Response
     *
     * @param $response
     *
     * @return array
     */
    public function formatResponse(ResponseInterface $response): array
    {
        $responseArray = json_decode($response->getBody(), true);

        if ($responseArray['items'] == null) {
            return [];
        }
        $data = [];

        $results = $responseArray['items']['dc'];

        // When there's a single result, the results are not on an array (as the rest of the process expects)
        if ($responseArray["pagination"]["numFound"] == 1 || $responseArray["pagination"]["limit"] == 1) {
            $results = [$results];
        }

        foreach ($results as $bookData) {
            $data[] = $this->formatBookData($bookData);
        }

        return $data;
    }

    /**
     * Formats the data of a single Book
     *
     * @param array $data
     *
     * @return array
     */
    private function formatBookData(array $data): array
    {
        $bookData = [];

        $bookData['author'] = $this->formatValue($data,'creator')[0];
        $languageData = $this->formatValue($data,'language')[0];
        if ($languageData) {
            $languageArray = explode(" ", $languageData);
            $bookData['language_code'] = $languageArray[0];
            $bookData['language'] = $languageArray[1];
        }
        // In case there's more than 1 title or description, it takes the first one
        $bookData['title'] = $this->formatValue($data, 'title')[0];
        $bookData['description'] = $this->formatValue($data, 'description')[0];

        $bookData['genres'] = $this->formatValue($data,'type');
        $bookData['identifier'] = preg_replace(
            '/[\s,\xc2\xa0]+/', ' ', $this->formatValue($data,'identifier')[0]
        );

        return $bookData;
    }

    /**
     * Most keys can exist or not, and can be an array or a single value.
     * This method standardize them all as an array.
     *
     * @param $data
     *
     * @return array
     */
    private function formatValue(array $data, string $value): array
    {
        if (!isset($data[$value])) {
            return [null];
        }

        return is_array($data[$value]) ? $data[$value] : [$data[$value]];
    }
}
