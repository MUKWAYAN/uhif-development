<?php
include('include/db.php');

	if (!empty($_SESSION['user']))
	{
		$_SESSION['user'] = '';
	}
	session_destroy();
	header("Location:/recoms");
	


?>