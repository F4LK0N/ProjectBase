<?php
$pathSource="/var/www/html/.env";
$pathParsed="/var/cache/php/dotEnvParsed.php";
if(!is_file($pathParsed) && is_file($pathSource)){
    $start = microtime(true);
    $content=file_get_contents($pathSource);
    $contentParsed="";
    if(strlen($content)){
        while(str_contains($content, "\r\n")) {
            $content = str_replace("\r\n", "\n", $content);
        }
        while(str_contains($content, "\r")){
            $content = str_replace("\r", "\n", $content);
        }
        while(str_contains($content, " \n")){
            $content = str_replace(" \n", "\n", $content);
        }
        while(str_contains($content, "\n ")){
            $content = str_replace("\n ", "\n", $content);
        }
        while(str_contains($content, "\n\n")){
            $content = str_replace("\n\n", "\n", $content);
        }
        $content = explode("\n", $content);
        foreach ($content as &$line){
            $lineParsed = explode("#", $line, 2);
            $lineParsed = $lineParsed[0];
            if(strlen($lineParsed)){
                $lineParsed = explode("=", $lineParsed, 2);
                if(count($lineParsed)===2){
                    $name = trim($lineParsed[0]);
                    $value = trim($lineParsed[1]);
                    if(strlen($name) && strlen($value)){
                        if($name==="MYSQL_APP_USER"){
                            $name="MYSQL_USER";
                        }elseif($name==="MYSQL_APP_PASS"){
                            $name="MYSQL_PASS";
                        }elseif(
                            (str_starts_with($name, "MYSQL_") &&
                                (
                                    $name!=="MYSQL_HOST" &&
                                    $name!=="MYSQL_PORT" &&
                                    !str_starts_with($name, "MYSQL_DATABASE")
                                )
                            ) ||
                            str_starts_with($name, "PMA_") ||
                            str_starts_with($name, "COMPOSE_") ||
                            str_starts_with($name, "DOCKER_")
                        ){
                            continue;
                        }
                        $value = explode("}", $value);
                        $valueParsed = [];
                        foreach ($value as &$valuePart){
                            $valuePart = trim($valuePart, '"');
                            $valuePart = trim($valuePart, "'");
                            if(str_starts_with($valuePart, '${')){
                                $valueParsed[] = '$_ENV[\''.substr($valuePart, 2).'\']';
                            }else{
                                $valueParsed[] = '\''.$valuePart.'\'';
                            }
                        }
                        $valueParsed=implode(".", $valueParsed);
                        $contentParsed.='$_ENV[\''.$name.'\']='.$valueParsed.";\n";
                        
                    }
                }
            }
        }
    }
    file_put_contents(
        $pathParsed, 
        '<'.'?'.'php'."\n".
        $contentParsed."\n".
        "//Parsed in ".(microtime(true) - $start)." Seconds\n"
    );
    unset($start, $content, $contentParsed, $line, $lineParsed, $name, $value, $valueParsed, $valuePart);
}
unset($pathSource);

if(is_file($pathParsed)){
    require_once $pathParsed;
}
unset($pathParsed);
