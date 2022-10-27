<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__.'/../core/autoload.php';

require __DIR__.'/../app/Router/routes.php';
$GLOBALS['app']->run();
