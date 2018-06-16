<?php
session_start();
date_default_timezone_set('Africa/Nairobi');
$today = date('Y-m-d H:i:s A',time());
try
{
    $dbh = new PDO('mysql:host=localhost; dbname=resultsdb', 'root', '');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo "Error: " . $e->getMessage();
}


?>