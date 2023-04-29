# User Management System API

This is a user management system API built using the Slim framework. It allows you to perform CRUD operations (Create, Read, Update, Delete) on users.

## Getting Started

To get started with the API, follow these steps:

1.  Clone this repository to your local machine.
2.  Install the dependencies by running `composer install`.
3.  Set up your database by creating a new database and running the SQL script in `database/users.sql`.
4.  Start the PHP development server by running `php -S localhost:8000 -t public`.
5.  Use a tool like Postman to interact with the API endpoints.

## Endpoints

### `GET /users`

This endpoint returns a list of all users in the database.

#### Response

jsonCopy code

```json
[
  {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  },
  {
    "id": 2,
    "name": "Bob Johnson",
    "email": "bob.johnson@example.com"
  }
]
```

### `GET /users/{id}`

This endpoint returns the user with the specified ID.

#### Parameters

| Name | Type   | Description        |
| ---- | ------ | ------------------ |
| id   | string | The ID of the user |

#### Response

jsonCopy code

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "johndoe@example.com"
}
```

### `POST /users`

This endpoint allows you to add a new user to the database.

#### Request Body

jsonCopy code

```json
{
  "name": "John Doe",
  "email": "johndoe@example.com"
}
```

#### Response

jsonCopy code

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "johndoe@example.com"
}
```

### `PUT /users/{id}`

This endpoint allows you to update an existing user in the database.

#### Parameters

| Name | Type   | Description        |
| ---- | ------ | ------------------ |
| id   | string | The ID of the user |

#### Request Body

jsonCopy code

```json
{
  "name": "Jane Doe",
  "email": "janedoe@example.com"
}
```

#### Response

jsonCopy code

```json
{
  "userid": 1,
  "name": "Jane Doe",
  "email": "janedoe@example.com"
}
```

### `DELETE /users/{id}`

This endpoint allows you to delete an existing user from the database.

#### Parameters

| Name | Type   | Description        |
| ---- | ------ | ------------------ |
| id   | string | The ID of the user |

#### Response

jsonCopy code

```json
{
  "message": "User deleted successfully."
}
```

## Contributing

Contributions are welcome! If you find a bug or have a feature request, please open an issue or submit a pull request.
