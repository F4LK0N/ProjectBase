<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../core/autoload.php';

$app = AppFactory::create();
require __DIR__.'/../app/Router/routes.php';
$app->run();
