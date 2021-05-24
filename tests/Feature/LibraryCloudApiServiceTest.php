<?php

namespace Tests\Feature;

use App\Services\LibraryCloudApiService;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

class LibraryCloudApiServiceTest extends TestCase
{
    /**
     * @var LibraryCloudApiService
     */
    private $apiService;

    public function setUp(): void {

        parent::setUp();

        $this->apiService = $this->app->make(LibraryCloudApiService::class);
    }

    public function testFormatResponse()
    {
        $responseTwoResults = new Response(200, [], '{"pagination":{"maxPageableSet":"100000","numFound":8042,"query":"genre=science fiction&limit=2","limit":2,"start":0},"items":{"dc":[{"title":"The maze runner","creator":"Dashner, James , 1972-","type":["Text","Young adult fiction.","Science fiction.","Fiction","Juvenile works.","Dystopian fiction.","Science fiction","Science fiction","Dystopian fiction.","Science fiction","Young adult works.","Dystopian fiction.","Fiction.","Juvenile works.","Science fiction.","Young adult works.","Science fiction.","Science fiction."],"publisher":"Delacorte Press","language":"eng English","format":["print","375 p. ; 22 cm."],"description":["Sixteen-year-old Thomas wakes up with no memory in the middle of a maze and realizes he must work with the community in which he finds himself if he is to escape.","James Dashner."],"subject":["Amnesia","Amnesia--Fiction","Cooperativeness","Cooperativeness--Fiction","Labyrinths","Labyrinths--Fiction","Science fiction","Amnesia","Amnesia--Juvenile fiction","Escapes","Escapes--Juvenile fiction","Cooperativeness","Cooperativeness--Juvenile fiction","Labyrinths","Labyrinths--Juvenile fiction","Dystopias","Dystopias--Juvenile fiction","PZ7.D2587 Maz 2009","[Fic]"],"relation":["Maze runner--(DLC)^^2009001345--(OCoLC)299381315","Maze runner--(DLC)^^2009001345--(OCoLC)299381315","https://id.lib.harvard.edu/alma/990136123350203941/catalog"],"identifier":["isbn: 9780385737951","lccn: ^^2009001345","oclc: 299381315","librarycloud: 990136123350203941"]},{"title":"The end of the day","creator":"North, Claire (author.)","type":["Text","novel","text","Suspense fiction.","Science fiction.","Thrillers (Fiction)","Science fiction","Science fiction.","Thrillers (Fiction.)","Fiction","Science fiction","Suspense fiction","Fiction.","Science fiction.","Suspense fiction.","Thrillers (Fiction)","Science fiction"],"publisher":"Redhook,","language":"eng English","format":["print","403 pages ; 25 cm","unmediated","volume"],"description":["The enigmatic Charlie, a specter who travels everywhere and visits everyone marked for death, sends messages and makes profound, life-changing offers to those he meets.","Claire North."],"subject":["Death","Death--Fiction","Ghost stories","FICTION / Literary","FICTION / Science Fiction / Action & Adventure","FICTION / Thrillers / Psychological","FICTION / Thrillers / Suspense","Death","Death--Fiction","Death","Ghost stories","PR6114.O777 E63 2017","823/.92"],"identifier":["isbn: 9780316316743","isbn: 0316316741","isbn: 9780316316767","oclc: 978247916","librarycloud: 990150134640203941"],"relation":"https://id.lib.harvard.edu/alma/990150134640203941/catalog"}]}}');
        $resultTwo = $this->apiService->formatResponse($responseTwoResults);
        $expectedResultTwo =
        [
            [
                "author" => "Dashner, James , 1972-",
                "language_code" => "eng",
                "language" => "English",
                "title" => "The maze runner",
                "description" => "Sixteen-year-old Thomas wakes up with no memory in the middle of a maze and realizes he must work with the community in which he finds himself if he is to escape.",
                 "genres" => ["Text", "Young adult fiction.", "Science fiction.", "Fiction", "Juvenile works.", "Dystopian fiction.", "Science fiction", "Science fiction", "Dystopian fiction.", "Science fiction", "Young adult works.", "Dystopian fiction.", "Fiction.", "Juvenile works.", "Science fiction.", "Young adult works.", "Science fiction.", "Science fiction.",],
                "identifier" => "isbn: 9780385737951",
            ],
            [
                "author"=> "North, Claire (author.)",
                "language_code" => "eng",
                "language" => "English",
                "title" => "The end of the day",
                "description" => "The enigmatic Charlie, a specter who travels everywhere and visits everyone marked for death, sends messages and makes profound, life-changing offers to those he meets.",
                "genres" => ["Text", "novel", "text", "Suspense fiction.", "Science fiction.", "Thrillers (Fiction)", "Science fiction", "Science fiction.", "Thrillers (Fiction.)", "Fiction", "Science fiction", "Suspense fiction", "Fiction.", "Science fiction.", "Suspense fiction.", "Thrillers (Fiction)", "Science fiction",],
                "identifier" => "isbn: 9780316316743",
            ],
        ];
        $this->assertEqualsCanonicalizing($expectedResultTwo, $resultTwo);

        $responseOneResult = new Response(200, [], '{"pagination":{"maxPageableSet":"100000","numFound":8042,"query":"genre=science fiction&limit=1","limit":1,"start":0},"items":{"dc":{"title":"The maze runner","creator":"Dashner, James , 1972-","type":["Text","Young adult fiction.","Science fiction.","Fiction","Juvenile works.","Dystopian fiction.","Science fiction","Science fiction","Dystopian fiction.","Science fiction","Young adult works.","Dystopian fiction.","Fiction.","Juvenile works.","Science fiction.","Young adult works.","Science fiction.","Science fiction."],"publisher":"Delacorte Press","language":"eng English","format":["print","375 p. ; 22 cm."],"description":["Sixteen-year-old Thomas wakes up with no memory in the middle of a maze and realizes he must work with the community in which he finds himself if he is to escape.","James Dashner."],"subject":["Amnesia","Amnesia--Fiction","Cooperativeness","Cooperativeness--Fiction","Labyrinths","Labyrinths--Fiction","Science fiction","Amnesia","Amnesia--Juvenile fiction","Escapes","Escapes--Juvenile fiction","Cooperativeness","Cooperativeness--Juvenile fiction","Labyrinths","Labyrinths--Juvenile fiction","Dystopias","Dystopias--Juvenile fiction","PZ7.D2587 Maz 2009","[Fic]"],"relation":["Maze runner--(DLC)^^2009001345--(OCoLC)299381315","Maze runner--(DLC)^^2009001345--(OCoLC)299381315","https://id.lib.harvard.edu/alma/990136123350203941/catalog"],"identifier":["isbn: 9780385737951","lccn: ^^2009001345","oclc: 299381315","librarycloud: 990136123350203941"]}}}');
        $resultOne = $this->apiService->formatResponse($responseOneResult);
        $expectedResultOne =
            [
                [
                    "author" => "Dashner, James , 1972-",
                    "language_code" => "eng",
                    "language" => "English",
                    "title" => "The maze runner",
                    "description" => "Sixteen-year-old Thomas wakes up with no memory in the middle of a maze and realizes he must work with the community in which he finds himself if he is to escape.",
                    "genres" => ["Text", "Young adult fiction.", "Science fiction.", "Fiction", "Juvenile works.", "Dystopian fiction.", "Science fiction", "Science fiction", "Dystopian fiction.", "Science fiction", "Young adult works.", "Dystopian fiction.", "Fiction.", "Juvenile works.", "Science fiction.", "Young adult works.", "Science fiction.", "Science fiction.",],
                    "identifier" => "isbn: 9780385737951",
                ],
            ];
        $this->assertEqualsCanonicalizing($expectedResultOne, $resultOne);
  }
}
