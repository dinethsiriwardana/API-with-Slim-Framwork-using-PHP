<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../Controller/UserController.php';

$app->get('/', [\UserController::class, 'showall']);
$app->get('/user/{id}', [\UserController::class, 'byuser']);
$app->post('/adduser', [\UserController::class, 'adduser']);
$app->get('/delete/{id}', [\UserController::class, 'deleteuser']);
$app->post('/update/{id}', [\UserController::class, 'updateuser']);
