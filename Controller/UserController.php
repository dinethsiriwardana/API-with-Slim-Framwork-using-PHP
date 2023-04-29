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
        // $response->getBody()->write($payload);
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
}
