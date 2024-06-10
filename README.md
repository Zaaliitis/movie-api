# Movie API

This is a RESTful API for managing movies and their broadcast information.

## Features

- Create, retrieve, update, and delete movies
- Add broadcast information to movies
- Search movies by title
- Authentication using Basic Auth
- Static analysis using PHPStan
- Code style enforcement using PHP-CS-Fixer

## Technologies Used

- PHP 8.x
- Laravel 11.x
- MySQL
- PHPUnit for testing
- PHPStan for static analysis
- PHP-CS-Fixer for code style enforcement

## Prerequisites

Before running the project, make sure you have the following installed:

- PHP 8.x
- Composer
- MySQL

## Setup

1. Clone the repository:
   ```
   git clone https://github.com/Zaaliitis/movie-api.git
   ```

2. Navigate to the project directory:
   ```
   cd movie-api
   ```

3. Install the dependencies using Composer:
   ```
   composer install
   ```

4. Copy the `.env.example` file to `.env` and update the database configuration:
   ```
   cp .env.example .env
   ```
   Open the `.env` file and update the `DB_*` variables with your MySQL database credentials.

5. Generate the application key:
   ```
   php artisan key:generate
   ```

6. Run the database migrations:
   ```
   php artisan migrate
   ```

7. Seed the database with sample data:
   ```
   php artisan db:seed
   ```

8. Start the development server:
   ```
   php artisan serve
   ```
   The API will be accessible at `http://localhost:8000`.

## Configuration

The API uses Basic Auth for authentication. To configure the API credentials, update the following variables in the `.env` file:
```
API_USERNAME=your-api-username
API_PASSWORD=your-api-password
```
Replace `your-api-username` and `your-api-password` with your desired credentials.

## API Endpoints

- `GET /api/movies`: Retrieve a paginated list of movies.
- `GET /api/movies/{id}`: Retrieve a specific movie by ID.
- `POST /api/movies`: Create a new movie.
- `PUT /api/movies/{id}`: Update a movie by ID.
- `DELETE /api/movies/{id}`: Delete a movie by ID.
- `POST /api/movies/{id}/broadcasts`: Add a broadcast to a movie.

## Testing

The project includes a test suite written with PHPUnit. To run the tests, use the following command:
```
php artisan test
```

## Static Analysis

The project uses PHPStan for static analysis. To run PHPStan, use the following command:
```
composer phpstan
```
## Code Style

The project uses PHP-CS-Fixer to enforce a consistent coding style. To run PHP-CS-Fixer and fix any style violations, use the following command:
```
composer php-cs-fixer
```

Thank you for checking out the Movie API project!
