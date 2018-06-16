<?php
include('./lib/dbcon.php'); 
 
include('session.php');



session_destroy();
header('location:/recoms'); 
?>