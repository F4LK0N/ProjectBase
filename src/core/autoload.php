<?php 
/** @noinspection PhpDefineCanBeReplacedWithConstInspection */
use Slim\Factory\AppFactory;

//### AUTO LOADER ###
// Autoload the core library code.
// The files required in this file must be loaded in this exactly specific order.



//Enumerators
require_once __DIR__ . "/Enumerations/HTTP_HEADER_CONTENT_TYPE.php";
//... ENUM ...
//... ENUM ...
//... ENUM ...
//...

//Basic
require_once __DIR__."/Basic/HTTP_HEADERS.php";
//require_once __DIR__."/Basic/PATH.php";
//require_once __DIR__."/Basic/GTW.php";
//require_once __DIR__."/Basic/SANITIZATION.php";
//require_once __DIR__."/Basic/SERVER.php";
//...

//Vendor (Third Party Libraries)
require_once __DIR__.'/../vendor/autoload.php';

//Helpers
//...

//DB
require_once __DIR__."/DB/Table.php";
//...

//Controllers
require_once __DIR__."/Controllers/Controller.php";
//...

//Models
require_once __DIR__."/Models/Model.php";
//...



$GLOBALS['app'] = AppFactory::create();
