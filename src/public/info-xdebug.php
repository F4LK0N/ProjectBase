<?php

var_dump([
    "String string string",
    true,
    1234,
    [1,2,3],
    (object)[
        "attrb1"=>3,
        "attrb2"=>6,
    ]
]);

xdebug_info();
