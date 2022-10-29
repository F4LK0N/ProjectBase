<?php declare(strict_types=1);
namespace Core\Basic;

enum eGTW_TYPE: int
{
    case NUMBER                    = 0;
    case NUMBER_POSITIVE           = 1;
    case NUMBER_STRING             = 2;
    case ID                        = 3;
    case BOOL                      = 4;
    
    case VAR_NAME                  = 100;//Var names.
    case VAR_VALUE                 = 101;//Filter for forbidden chars into vars values.
    
    case DB_ID                     = 200;
    case DB_NAME                   = 201;//DB elements names (table name, field name, etc).
    case DB_NAMES                  = 202;//Same as TYPE_DB_NAMES, but accept 'spaces' and 'commas'.
    case DB_VALUE                  = 203;
    case DB_QUERY                  = 204;
    
    case SESSION_TOKEN             = 300;
    
    case LOGIN_USER                = 400;
    case LOGIN_PASS                = 401;
    
    case NAME                      = 500;//Names utilized in user entries.
    case TEXT                      = 501;//Texts utilized in user entries.
    case TEXT_LINE                 = 502;//Same as TYPE_TEXT, but with a line break filter.
    case PATH                      = 503;//FileSystem files and directories paths.
    
    case EMAIL                     = 600;
    case PHONE_DDD                 = 601;
    case PHONE                     = 602;
    case CPF                       = 603;
}
