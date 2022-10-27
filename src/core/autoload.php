<?php

use Slim\Factory\AppFactory;

//### AUTO LOADER ###
// Autoload the core library code.
// The files required in this file must be loaded in this exactly specific order.

//Vendor
require_once __DIR__.'/../vendor/autoload.php';



//Basic
require_once __DIR__."/Basic/HttpHeaders.php";
require_once __DIR__."/Basic/eGTW_TYPE.php";
//...

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
