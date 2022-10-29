<?php

//TODO:
class eSERVER_ENVIRONMENT
{
    public const OFFLINE = 0;
    public const ONLINE  = 1;
}
//TODO: add eSERVER_PROVIDER: DEV, HEROKU, AMAZON
class eSERVER_TIER
{
    public const DEV  = 0;
    public const STAG = 1;
    public const PROD = 2;
}
class eCLIENT_PLATFORM
{
    public const UNKNOWN = 0;
    public const APP     = 1;
    public const WEB     = 2;
}
