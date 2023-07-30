Laravel Product API
===================

This is a Laravel-based API that fetches, parses, maps, and stores product data from an external API into a local database. The data can then be retrieved in either JSON or XML format.

Features
--------

-   Fetches data from an external API
-   Parses the fetched data based on its content type (XML or JSON)
-   Maps the parsed data to match the fields of the local database
-   Stores the mapped data in the database
-   Retrieves all stored products in either JSON or XML format

Getting Started
---------------

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

-   PHP >= 7.4
-   Composer
-   Laravel >= 8.x
-   A SQL database

### Installing

1.  Clone the repository: `git clone https://github.com/aliosmanyuksel/bugloosLaravel.git`
2.  Navigate to the project directory: `cd bugloosLaravel`
3.  Install Composer dependencies: `composer install`
4.  Create a `.env` file by copying the example file: `cp .env.example .env`
5.  Add to .env file this lines.
    `API_URL=https://aliosmanyuksel.com.tr/wp-content/uploads/products.json
    CONFIG_PATH=/products.yml`
6.  Generate an app key: `php artisan key:generate`
7.  Set up your database and fill in the database information in the `.env` file
8.  Migrate the database: `php artisan migrate`
9.  Run the server: `php artisan serve`
10. The application should now be running at `http://localhost:8000`

### Usage

The application currently supports two endpoints:

-   `GET /fetch`: Fetches, parses, maps, and stores product data from the external API
-   `GET /products`: Retrieves all stored products in the format specified by the `Accept` header of the request

### Tests

You can run the application's tests by using the following command: `php artisan test`

Contributing
------------

Please read CONTRIBUTING.md for details on our code of conduct, and the process for submitting pull requests to us.

License
-------

This project is licensed under the MIT License - see the LICENSE.md file for details