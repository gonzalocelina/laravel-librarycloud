<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">
    <title>Laravel Library Cloud</title>

    <link href = {{ asset("css/app.css") }} rel="stylesheet" />
    <link href = {{ asset("css/styles.css") }} rel="stylesheet" />
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div class="container">
        <div class="row mt-4 mb-2">
            <div class="col text-center">
                <h3>Search our book database</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-2">
            <form id="searchForm" class="form" action="javascript:getBooks()">
                <div class="row">
                    <div class="form-group col">
                        <label for="input-title">Title</label>
                        <input name="title" id="input-title" class="form-control mr-1" type="text" placeholder="Title">
                    </div>
                    <div class="form-group col">
                        <label for="input-description">Description</label>
                        <input name="description" id="input-description" class="form-control mr-1" type="text" placeholder="Description">
                    </div>
                    <div class="form-group col">
                        <label for="input-author">Author</label>
                        <input name="author" id="input-author" class="form-control mr-1" type="text" placeholder="Author">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col">
                        <label for="input-genres">Genre</label>
                        <input name="genres" id="input-genres" class="form-control mr-1" type="text" placeholder="Genre">
                    </div>
                    <div class="form-group col">
                        <label for="input-identifier">Identifier</label>
                        <input name="identifier" id="input-identifier" class="form-control mr-1" type="text" placeholder="ISBN, OCLC, LCCN, etc.">
                    </div>
                    <div class="form-group col">
                        <label for="input-language">Language</label>
                        <input name="language" id="input-language" class="form-control mr-1" type="text" placeholder="Language">

                    </div>
                </div>
                <button class="btn btn-primary float-right">Search</button>
            </form>
        </div>
        <div class="row">
            <div class="col text-center">
                <p class="error" id="error"></p>
            </div>
        </div>
        <table class="table" id="books-table" style="display: none;">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Author</th>
                <th scope="col">Title</th>
                <th scope="col"><!--more info--></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="test"></div>

    <script>
        function alternatePlusMinus(selector) {
            const button = $(selector);
            if (button.html().trim() === "+") {
                button.html("-");
            } else {
                button.html("+");
            }
        }

        function getBooks() {
            const booksTable = $("#books-table");
            booksTable.find("tbody tr").fadeOut("slow").delay(1000).queue(function(){$(this).remove();});
            booksTable.find("tbody").hide();

            $.ajax({url: "{{ route('get_books') }}",
                data: $("#searchForm :input")
                    .filter(function(index, element) {
                        return $(element).val() != '';
                    })
                    .serialize()
                ,
                success: function(results) {
                    if (results.length === 0) {
                        $("#error").show();
                        $("#error").text("Your search returned no results");
                        booksTable.fadeOut("slow");

                        return;
                    }
                    for (let i = 0; i < results.length; i++) {
                        const book = results[i];

                        booksTable.append(
                            '<tr>' +
                            '<td>' + (book.author ? book.author : "No information") + '</td>' +
                            '<td>' + (book.title ? book.title : "No information") + '</td>' +
                            '<td>' +
                                '<button id="info-' + i + '" class="btn btn-sm btn-dark float-right" type="button"' +
                                'data-toggle="collapse" data-target="#collapse-' + i + '" aria-expanded="false"' +
                                'aria-controls="collapse-' + i + '" onclick="alternatePlusMinus(\'#info-' + i + '\')">+' +
                                '</button>' +
                            '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td colspan="3" class="collapse" id="collapse-' + i + '">' +
                            '<div class="card card-body">' +
                            '<p>' +
                            '<b>Description:</b> ' + (book.description ? book.description : "No information") +'<br>' +
                            '<b>Genre/s:</b> ' + (book.genres ? book.genres.join(", ") : "No information") + '<br>' +
                            '<b>Identifier:</b> ' + (book.identifier ? book.identifier : "No information") + '<br>' +
                            '<b>Language:</b> ' + (book.language ? book.language : "No information") + '<br>' +
                            '</p>' +
                            '</div>' +
                            '</td>' +
                            '</tr>'
                        );


                    }
                    booksTable.find("tbody").fadeIn("slow");
                    $("#error").hide();
                    if (booksTable.is(":hidden")) {
                        booksTable.fadeIn("slow");
                    }
                },
                error: function(response) {
                    const error = eval("(" + response.responseText + ")");
                    $("#error").show();
                    $("#error").text(error.message);
                }
            });
        };
    </script>
</body>
</html>

