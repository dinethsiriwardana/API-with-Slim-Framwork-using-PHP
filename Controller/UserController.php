<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;


require __DIR__ . '/../config/database.php';


class UserController
{
    public function showall(ServerRequestInterface $request, ResponseInterface $response, $args)
    {

        $pdo = (new Database())->pdo;
        $sth = $pdo->prepare("SELECT userid,name,email FROM user");
        $sth->execute();

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        $payload = json_encode($results);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function byuser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {

        $pdo = (new Database())->pdo;
        $sth = $pdo->prepare("SELECT userid,name,email FROM user WHERE userid = " . $args['id']);
        $sth->execute();

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        $payload = json_encode($results);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function adduser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {

        // Get the request body as JSON
        $requestBody = $request->getBody();
        $data = json_decode($requestBody, true);

        // Insert the new user into the database
        // $sql = "INSERT INTO user (name, email, password) VALUES ('" . $data['name'] . "', '" . $data['email'] . "', '" . $data['password'] . "')";
        // echo $sql;
        $pdo = (new Database())->pdo;
        $sql = "INSERT INTO user (name, email, password) VALUES (:name, :email, :password)";
        $sth = $pdo->prepare($sql);
        $sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $sth->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $sth->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $sth->execute();
        // Get the ID of the new user
        $newUserId = $pdo->lastInsertId();

        // Create a response with the new user's ID
        $responseData = array('id' => $newUserId);
        $responseBody = json_encode($responseData);
        $response->getBody()->write($responseBody);
        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        return $response;
    }

    public function deleteuser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {

        $pdo = (new Database())->pdo;
        $sth = $pdo->prepare("DELETE FROM user WHERE userid = " . $args['id']);
        $sth->execute();

        if ($sth->rowCount() == 0) {
            $response->getBody()->write(json_encode(array('message' => 'User not found')));
        } else {
            $response->getBody()->write(json_encode(array('message' => 'User deleted successfully')));
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
    public function updateuser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = $args['id'];

        // Get the request body
        $requestBody = $request->getBody();
        $data = json_decode($requestBody, true);

        // Make sure all required fields are present in the request body
        if (!isset($data['name']) || !isset($data['email'])) {
            $error = array('error' => 'Name and email are required fields', 'name' => $data['name'], 'email' => $data['email']);
            $payload = json_encode($error);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Get the database connection
        $pdo = (new Database())->pdo;

        // Update the user record
        $sth = $pdo->prepare("UPDATE user SET name=:name, email=:email WHERE userid=:id");
        $sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $sth->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();

        if (!$sth->execute()) {
            $error = $sth->errorInfo();
            echo $error[2]; // Print out the error message
        }

        // Get the updated user record
        $sth = $pdo->prepare("SELECT * FROM user WHERE userid=:id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        // Return the updated user record
        $payload = json_encode($result);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
