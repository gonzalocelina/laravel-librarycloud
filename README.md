## About Laravel Library Cloud

Laravel Library Cloud is a web application that allows the user to query for books on the Harvard Library.

## Getting started

### Installation

Clone the repository

    git clone git@github.com:gonzalocelina/laravel-librarycloud.git

Switch to the repository folder

    cd laravel-librarycloud

Install all the dependencies using composer (ignoring platform requirements as it will run on a Docker container)

    php composer.phar install --ignore-platform-reqs

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

#### Inside the container

Generate a new application key

    php artisan key:generate

Run the database migrations

    php artisan migrate
    
Compile npm scripts

    npm install
    npm run dev

You can now access the server at http://localhost

### Importing books

You can import books by running

    php artisan books:import [--a|author=<author of the books> --g|genre=<genre of the books>]

### Testing

To run all tests

    ./vendor/bin/phpunit
