<?php
try
{
    $dbh = new PDO('mysql:host=localhost; dbname=resultsdb', 'root', ''); // connects to the database called super_market
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // catch connection exception
}
catch (PDOException $e)
{
    echo "Error: " . $e->getMessage();
}
?>