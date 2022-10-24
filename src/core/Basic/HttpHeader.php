<?php

namespace Core\Basic;

class HttpHeader
{
    public const CONTENT_TYPE_HTML = 1;
    public const CONTENT_TYPE_JSON = 2;

    static private int $contentType = 0;
    static private array $headers = [];



    static public function run()
    {
        self::runContentType();
//        self::runCORS();
//        self::runOptions();
    }

    static public function setHeader(string $value): bool
    {
        $value = trim($value);
        $separatorPosition = strpos($value, ":");

        if($separatorPosition===false || $separatorPosition<1 || $separatorPosition===(strlen($value)-1)){
            return false;
        }

        $headerParts = explode(": ", $value, 2);
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

    static private function runContentType(): void
    {
        self::setContentType();

//        if($_SERVER['REQUEST_METHOD']==='OPTIONS' || isset($_GET['TDD']))
//            self::ContentType(HTTP_Header::CONTENT_TYPE_HTML);
//        else
//            self::ContentType(HTTP_Header::CONTENT_TYPE_JSON);
    }
    static public function setContentType(int $value=0): void
    {
        //Direct Value
        if($value!==0) {
            self::$contentType = $value;
        }
        //Pre Script Variable
        else if(isset($HTTP_HEADER_CONTENT_TYPE)) {
            self::$contentType = $HTTP_HEADER_CONTENT_TYPE;
        }
        //Environment File
        else if(isset($_SERVER['PROJECT_CONTENT_TYPE'])){
            self::$contentType = $_SERVER['PROJECT_CONTENT_TYPE'];
        }

        //Default Value
        if(self::$contentType!==self::CONTENT_TYPE_HTML && self::$contentType!==self::CONTENT_TYPE_JSON){
            self::$contentType = self::CONTENT_TYPE_HTML;
        }
    }
    static private function getContentTypeHeader(): string
    {

    }
    static public function getContentType(): int
    {
        return self::$contentType;
    }
    static public function ContentType ($type, $returnHeaderString=false)
    {
        //Property
        $header = "Content-Type: ";
        //Type
        $header .= ($type===self::CONTENT_TYPE_HTML)?"text/html;":"application/json;";
        //Encoding
        $header.=" charset=utf-8";

        //SUCCESS
        if($returnHeaderString===true)
            return $header;
        header($header);
    }

    static private function runCORS()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: " . (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']) ? $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'].", " : "")."X-Requested-With, Accept-Encoding");
    }
    static private function runOptions()
    {
        //OPTIONS (Pre-flight requests)
        //If the $_SERVER['REQUEST_METHOD'] is of the type "OPTIONS" is probably because the ajax plugin from the front-end is performing a 'pre-flight' request.
        //A 'pre-flight' is a request to the API to know the accepted content formats, compression, cross-origins requests, etc.
        //In this case the server only need to respond with http headers and don't need to enter inside the API logic, saving resources.
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
            exit(0);
    }



}
//HttpHeader::run();
