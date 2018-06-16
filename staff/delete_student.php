<?php
include('lib/dbcon.php');
//dbcon();
if (isset($_POST['delete_student'])){
$id=$_POST['selector'];
$N = count($id);
for($i=0; $i < $N; $i++)
{
	$result = mysql_query("DELETE FROM student_lower where student_lid='$id[$i]'");
}
header("location: add_student.php");
}
?>