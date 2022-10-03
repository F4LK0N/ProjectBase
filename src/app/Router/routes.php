<?php

use App\Controllers\DevController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * @var App $app
 */
$app->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write("Hello World!");
    return $response;
});

$app->group('/Dev', function (RouteCollectorProxy $app)
{
    $app->get('/', function (Request $request, Response $response, array $args) {
        return (new DevController($request, $response, $args))->index();
    });
    $app->get('/Install', function (Request $request, Response $response, array $args) {
        return (new DevController($request, $response, $args))->install();
    });
});
