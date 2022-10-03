<?php

namespace Core\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller
{
    protected ServerRequestInterface $request;
    protected ResponseInterface $response;
    protected array $arguments;

    public function __construct(ServerRequestInterface $request, ResponseInterface $response, array $arguments)
    {
        $this->request = $request;
        $this->response = $response;
        $this->arguments = $arguments;
    }

}
