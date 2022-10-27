<?php

namespace Core\DB;

class FIELD_TYPE
{
    //### DB SQL TYPES ###
    //DEFAULT TYPES
    const TYPE_BOOL       = 1;

    const TYPE_VARCHAR    = 2;
    const TYPE_TEXT       = 3;

    const TYPE_SMALLINT   = 4;
    const TYPE_INT        = 5;
    const TYPE_BIGINT     = 6;

    const TYPE_SERIAL     = 7;
    const TYPE_BIGSERIAL  = 8;

    //CUSTOM TYPES
    const TYPE_ID         = 9;
    const TYPE_ID_PRIMARY = 10;

    const TYPE_TIMESTAMP  = 11;


}
