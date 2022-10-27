<?php

namespace Core\Basic;

/**
 * Manage the HTTP Headers sent in the response.
 * 
 * Provide methods to set and store HTTP Headers
 * and later send all the stored header to the response.
 * 
 * 
 * By default, this class run before most of the code is loaded, 
 * set the default header,
 * and check if the request is a preflight request.
 * If it is stop the rest of the code from loading and executing.
 * 
 * This change 
 * 
 * $_SERVER['HTTP_HEADERS_DEFAULT_RUN'] = false;
 * Stops the default behavior of SET and SEND default headers.
 *
 * $_SERVER['HTTP_HEADERS_DEFAULT_SEND_HEADERS'] = false;
 * Stops the default behavior of SEND default headers.
 *
 * $_SERVER['HTTP_HEADER_CONTENT_TYPE']
 * Set the ContentType value, if empty, when run() calls setContentType().
 *
 * $_SERVER['PROJECT_CONTENT_TYPE']
 * Set the ContentType value, if empty, when run() calls setContentType().
 */
class HttpHeaders
{
    public const CONTENT_TYPE_HTML = 1;
    public const CONTENT_TYPE_JSON = 2;

    static private int   $contentType = 0;
    static private array $headers     = [];



    static public function run(): void
    {
        if(self::canRun()){
            self::setContentType();
            self::setDefaultCORS();
            self::sendHeaders();
            self::preflightCheck();
        }
    }
    static private function canRun(): bool
    {
        if(
            (isset($_SERVER['HTTP_HEADERS_DEFAULT_RUN']) && $_SERVER['HTTP_HEADERS_DEFAULT_RUN']===false) ||
            (isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF']==="./vendor/bin/phpunit")
        ){
            return false;
        }

        return true;
    }

    static public function setContentType(int $value=0): void
    {
        $newValue = 0;

        //Direct Value
        if($value!==0) {
            $newValue = $value;
        }
        else if(self::$contentType===0)
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
        if($newValue===self::CONTENT_TYPE_HTML || $newValue===self::CONTENT_TYPE_JSON){
            self::$contentType = $newValue;
        }

        //Default Value
        if(self::$contentType!==self::CONTENT_TYPE_HTML && self::$contentType!==self::CONTENT_TYPE_JSON){
            self::$contentType = self::CONTENT_TYPE_HTML;
        }

        self::setHeader(self::createContentTypeHeader());
    }
    static public function getContentType(): int
    {
        return self::$contentType;
    }
    static private function createContentTypeHeader(): string
    {
        //Property
        $header = "Content-Type: ";
        //Type
        $header .= (self::$contentType===self::CONTENT_TYPE_JSON)?"application/json;":"text/html;";
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

    static private function preflightCheck()
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
    static public function getHeader($name): ?string
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

    }

}
HttpHeaders::run();
