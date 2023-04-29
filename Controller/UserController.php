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
        $sth = $pdo->prepare("SELECT * FROM user");
        $sth->execute();

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        $payload = json_encode($results);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function byuser(ServerRequestInterface $request, ResponseInterface $response, $args)
    {

        $pdo = (new Database())->pdo;
        $sth = $pdo->prepare("SELECT * FROM user WHERE userid = " . $args['id']);
        $sth->execute();

        $results = $sth->fetchAll(PDO::FETCH_ASSOC);

        $payload = json_encode($results);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
