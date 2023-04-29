<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../Controller/UserController.php';

$app->get('/users', [\UserController::class, 'showall']);
$app->get('/users/{id}', [\UserController::class, 'byuser']);
$app->post('/users/adduser', [\UserController::class, 'adduser']);
