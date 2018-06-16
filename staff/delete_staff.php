<?php
include('./lib/dbcon.php');
dbcon();
if (isset($_POST['delete_staff'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysql_query("DELETE FROM staff where staff_id='$id[$i]'");
}
header("location: staff_user.php");
}
?>