<?php
namespace Core\Basic;

require_once __DIR__.'/../Enumerations/HTTP_HEADER_CONTENT_TYPE.php';
use Core\Enumerations\HTTP_HEADER_CONTENT_TYPE;

/**
 * Manage the HTTP Headers sent in the response.
 *
 * 
 * 
 * METHODS:
 * 
 * Provide methods to set and store HTTP headers
 * and later send all the stored headers to the response.
 * 
 * Provide methods to set Content-Type header with default or
 * customized values.
 *
 * Provide methods to set CORS (Cross Origin Resource Sharing) 
 * headers with default values, including response from CORS 
 * headers sent in the request, or customized values.
 * 
 * Provide a method to handle OPTIONS (Preflight Request) header
 * and stop unnecessary code loading and processing. 
 * 
 * 
 * 
 * DEFAULT BEHAVIOR:
 * 
 * This class file is the first code loaded by the core autoloader.
 * By default, this class is loaded and run before any core library 
 * code can be loaded or executed. Meaning that if it stops the 
 * execution. (calling 'exit(0)') it will spare server resources.
 * 
 * By default, this class runs right after it is loaded, on 
 * FirstRunDefaultBehavior mode, and execute these default behaviors: 
 * - Set and store the default Content-Type header;
 * - Set and store the default CORS headers;
 * - Send all stored headers;
 * - Identify preflight request and stop code execution;
 * 
 * 
 * 
 * CUSTOM BEHAVIOR:
 * 
 * To modify or prevent any of these behaviors, you can define a
 * constant with a custom value, like this:
 * define('CONSTANT_NAME', value);
 * 
 * The constants are:
 * HTTP_HEADERS_DEFAULT_RUN: bool
 * - Run the class right after its loaded, with the default behavior
 *   of every method. 
 * 
 * HTTP_HEADERS_DEFAULT_CONTENT_TYPE: string
 * - The default Content-Type header value.
 *    "HTML" = "Content-Type: text/html; charset=utf-8"
 *    "JSON" = "Content-Type: application/json; charset=utf-8"
 * 
 * HTTP_HEADERS_DEFAULT_RUN_CONTENT_TYPE: bool
 * - Set the default Content-Type header on first run.
 * 
 * HTTP_HEADERS_DEFAULT_RUN_CORS: bool
 * - Set the default CORS headers on first run.
 * 
 * HTTP_HEADERS_DEFAULT_SEND_HEADERS: bool
 * - Send the default stored headers on first run. 
 *
 * HTTP_HEADERS_DEFAULT_RUN_PREFLIGHT: bool
 * - Check if is a preflight request and stop code execution 
 *   on first run.
 * 
 * 
 * 
 * DOT ENV DEFINITIONS:
 *
 * This custom behaviors modifiers can also be defined in variables 
 * in a '.env' file, using the same name e value type of the constants.
 * Example:
 * HTTP_HEADERS_DEFAULT_RUN=false
 * 
 * Precedence:
 * The class first search for a constant, if it is not defined then it
 * search for an environment variable.
 * 
 * Alias:
 * PROJECT_CONTENT_TYPE = HTTP_HEADERS_DEFAULT_CONTENT_TYPE
 *
 */
class HTTP_HEADERS
{
    static private bool   $defaultRun            = true;
    static private bool   $defaultRunContentType = true;
    static private bool   $defaultRunCors        = true;
    static private bool   $defaultRunPreflight   = true;
    static private bool   $defaultSendHeaders    = true;
    static private string $defaultContentType    = "HTML";
    
    static private bool   $firstRunWithDefaultBehavior = true;
    
    static private HTTP_HEADER_CONTENT_TYPE $contentType = HTTP_HEADER_CONTENT_TYPE::UNDEFINED;
    static private array                    $headers     = [];
    
    

    static public function run(bool $default): void
    {
        self::loadDefaultDefinitions();
        if(self::canRun()){
            self::contentTypeSetDefault();
            self::setDefaultCORS();
            self::sendHeaders();
            self::preflightCheck();
        }
        self::$firstRunWithDefaultBehavior=false;
    }
    static private function loadDefaultDefinitions(): void
    {
        
    }
    static private function canRun(): bool
    {
        if(
            (!self::$firstRunWithDefaultBehavior) ||
            (isset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']) && $_SERVER['HTTP_HEADERS_DEFAULT_RUN']===false) ||
            (isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF']==="./vendor/bin/phpunit")
        ){
            return false;
        }

        return true;
    }
    
    
    static public function contentTypeSetDefault(): void
    {
        //self::setHeader(self::createContentTypeHeader());
    }
    static public function contentTypeSet(HTTP_HEADER_CONTENT_TYPE $value = HTTP_HEADER_CONTENT_TYPE::UNDEFINED): void
    {
        $newValue = HTTP_HEADER_CONTENT_TYPE::UNDEFINED;

        //Direct Value
        if($value!==HTTP_HEADER_CONTENT_TYPE::UNDEFINED) {
            $newValue = $value;
        }
        else if(self::$contentType===HTTP_HEADER_CONTENT_TYPE::UNDEFINED)
        {
            //Pre Script Variable
            if(isset($_SERVER['HTTP_HEADER_CONTENT_TYPE'])) {
                $newValue = $_SERVER['HTTP_HEADER_CONTENT_TYPE'];
            }
            //Environment File Variable
            else if(isset($_SERVER['PROJECT_CONTENT_TYPE'])){
                $newValue = $_SERVER['PROJECT_CONTENT_TYPE'];
            }
        }

        //Set New Value
        if($newValue===HTTP_HEADER_CONTENT_TYPE::HTML || $newValue===HTTP_HEADER_CONTENT_TYPE::JSON){
            self::$contentType = $newValue;
        }

        //Default Value
        if(self::$contentType!==HTTP_HEADER_CONTENT_TYPE::HTML && self::$contentType!==HTTP_HEADER_CONTENT_TYPE::JSON){
            self::$contentType = HTTP_HEADER_CONTENT_TYPE::HTML;
        }

        self::setHeader(self::contentTypeCreateHeader());
    }
    static public function contentTypeGet(): HTTP_HEADER_CONTENT_TYPE
    {
        return self::$contentType;
    }
    static private function contentTypeCreateHeader(): string
    {
        //Property
        $header = "Content-Type: ";
        //Type
        $header .= (self::$contentType===HTTP_HEADER_CONTENT_TYPE::HTML)?"application/json;":"text/html;";
        //Encoding
        $header.=" charset=utf-8";

        return $header;
    }

    
    static private function setDefaultCORS(): void
    {
        self::setHeader('Access-Control-Allow-Origin: *');
        self::setHeader('Access-Control-Allow-Credentials: true');
        self::setHeader('Access-Control-Max-Age: 86400');
        self::setHeader("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        self::setHeader("Access-Control-Allow-Headers: " . (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']) ? $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'].", " : "")."X-Requested-With, Accept-Encoding");
    }

    
    static private function preflightCheck(): void
    {
        //OPTIONS (Pre-flight Requests)
        //If the $_SERVER['REQUEST_METHOD'] is of the type "OPTIONS" is probably because the ajax plugin from the front-end is performing a 'pre-flight' request.
        //A 'pre-flight' is a request to the API to know the accepted content formats, compression, cross-origins requests, etc.
        //In this case the server only need to respond with http headers and don't need to enter inside the API logic, saving resources.
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
            exit(0);
        }
    }

    
    static public function clearHeaders(): void
    {
        self::$headers = [];
    }
    static public function setHeader(string $value): bool
    {
        $value = trim($value);
        $separatorPosition = strpos($value, ":");

        if($separatorPosition===false || $separatorPosition<1 || $separatorPosition===(strlen($value)-1)){
            return false;
        }

        $headerParts = explode(":", $value, 2);
        $headerParts[0] = trim($headerParts[0]);
        $headerParts[1] = trim($headerParts[1]);

        if(strlen($headerParts[0])===0 || strlen($headerParts[1])===0){
            return false;
        }

        self::$headers[$headerParts[0]] = $headerParts[1];
        return true;
    }
    static public function getHeader(string $name): ?string
    {
        if(isset(self::$headers[$name])){
            return self::$headers[$name];
        }
        return null;
    }
    static public function getHeaders(): array
    {
        return self::$headers;
    }
    static public function sendHeaders(): void
    {
        foreach(self::$headers as $name => $value){
            header("$name: $value");
        }
    }

}
HTTP_HEADERS::run();
