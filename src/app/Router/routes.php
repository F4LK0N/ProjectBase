<?php

use App\Controllers\DevController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

/**
 * @var App $GLOBALS['app']
 */
$GLOBALS['app']->get('/', function (Request $request, Response $response, array $args) {
    $response->getBody()->write($_SERVER['PROJECT_LABEL']);
    return $response;
});

$GLOBALS['app']->group('/Dev', function (RouteCollectorProxy $app)
{
    $app->get('/', function (Request $request, Response $response, array $args) {
        return (new DevController($request, $response, $args))->index();
    });
    $app->get('/Install', function (Request $request, Response $response, array $args) {
        return (new DevController($request, $response, $args))->install();
    });
});
