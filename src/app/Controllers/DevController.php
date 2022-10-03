<?php

namespace App\Controllers;

use Core\Controllers\Controller;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DevController extends Controller
{
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
        var_dump($models);

        return $this->response;
    }

    private function loadModels(): array
    {
        $models = [];
        $dirPath = __DIR__.'/../Models/';
        $dirContent = scandir($dirPath);
        foreach($dirContent as $dirObject){
            if(is_file($dirPath.$dirObject) && str_ends_with($dirObject, ".php")){
                $models[] = [
                    'name' => substr($dirObject, 0, -4),
                    'file' => $dirObject,
                    'path' => $dirPath.$dirObject,
                ];
            }
        }
        return $models;
    }
}
