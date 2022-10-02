<?php

print"<h1>MySQL</h1>";
$dbConn = null;
$host = "mysql";
$username = "root";
$password = "root";
$database="project";



print"Connection: ";
try{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $dbConn = new mysqli($host, $username, $password);
}catch (Exception $e){
    print"ERROR!";
    var_dump($e);
    die;
}
print "OK!<br><br><br>";



print"Database: ";
try{
    $dbConn->select_db($database);
}catch (Exception $e){
    print"ERROR!";
    var_dump($e->getMessage());
//    var_dump($e);
    die;
}
print "OK!<br><br><br>";



print"<h3>Tables</h3>";
try{
    $tablesResult = $dbConn->query("SHOW TABLES");
}catch (Exception $e){
    print"ERROR!";
    var_dump($e);
    die;
}
while($table = $tablesResult->fetch_row())
{
    print"$table[0]<br>";
}
