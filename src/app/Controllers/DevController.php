<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DevController {

    private ServerRequestInterface $request;
    private ResponseInterface $response;
    private array $args;

    public function __construct(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;
    }

    public function index(): ResponseInterface
    {
        $this->response->getBody()->write("<h1>Dev</h1>");
        $this->response->getBody()->write("<a href='/Dev/Install'>Install</a>");
        return $this->response;
    }

    public function install(): ResponseInterface
    {
        $this->response->getBody()->write("<h1>Dev - Install</h1>");

        $models = $this->loadModels();

        return $this->response;
    }

    private function loadModels(): array
    {
//        $dirContent = scandir(__DIR__)
    }
}
