<?php declare(strict_types=1);
namespace Core\Basic;

enum eHTTP_HEADER_CONTENT_TYPE: string
{
    case UNDEFINED = "";
    case HTML      = "HTML";
    case JSON      = "JSON";
}
