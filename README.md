
# Supermarket List API

A RESTful API built with Laravel for managing supermarket shopping lists. Users can create shopping lists, add products, share lists with others, and communicate via messages for clarifications.


## Features

- User authentication with Sanctum.
- Create, read, update, and delete shopping lists, products and messages.
- Share shopping lists with other users.
- Messaging functionality for list clarifications.
- RESTful design principles.

## Installation

  

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- Laravel Framework

### Steps
1. Clone the repository:
```bash
git clone https://github.com/BluEDr/supermarket-list-api.git
```
2. Navigate to the project directory:
```bash
cd supermarket-list-api
```
3. Install dependencies:
```bash
composer install
```
4. Set up the .env file:
```bash
cp .env.example  .env
```

5. Configure database connection in the .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=super_list_db
DB_USERNAME=root
DB_PASSWORD=yourpassword
```
5. Run migrations:
```bash
php artisan migrate
```
6. Start the development server:
```bash
php artisan serve
```
# API Documentation


## Authentication

  

### Register

* URL: /api/register
* Method: POST
* Request Body:
```JSON
{
    "name" : "Tryfon Skordos",
    "email" : "tryfon@skordos.gr",
    "password" : "password"
}
```
* Response:
```JSON
{
    "status": "User registered successfully"
}
```
### Login  

* URL: /api/login
* Method: POST
* Request Body:
```JSON
{
	"email": "your@email.com",
	"password": "password"
}
```
* Response:
```JSON
{
	"access_token": "6|lilV61oUWSpNPJbDoLJH1l7BnK4pxIJrWVHxOyZl60df52f6",
	"token_type": "Bearer"
}
```
### Logout  

* URL: /api/logout
* Method: POST
* Request Header:

|Key                            |Value                                                |
|-------------------------------|-----------------------------------------------------|
|`Authorization`                |`6|lilV61oUWSpNPJbDoLJH1l7BnK4pxIJrWVHxOyZl60df52f6` |


* Response:
```JSON
{
    "message": "Logged out successfully"
}
```

  

  

## Database Schema

  

### Tables

  
  

//edo na balo tin eikona gia tin db

  

## Built With

  

* Laravel 11

  

* MySQL

  

* Sanctum for authentication

  

* Postman Client for testing

  

  

## Contributing

  

  

### License

  

This project is licensed under the MIT License - see the LICENSE.md file for details.

  

  

### Contact

  

For any questions, feel free to reach out:

  

* Email: skordos88@gmail.com

  

* GitHub: [github.com/BluEDr](https://github.com/BluEDr)