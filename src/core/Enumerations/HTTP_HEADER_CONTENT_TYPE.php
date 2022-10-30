<?php declare(strict_types=1);
namespace Core\Enumerations;

enum HTTP_HEADER_CONTENT_TYPE: string
{
    case UNDEFINED = "";
    case HTML      = "HTML";
    case JSON      = "JSON";
    
//    public function getHttpHeaderValue(): string 
//    {
//        
//    }
}
