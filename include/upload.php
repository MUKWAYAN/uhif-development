<?php
include('config.php');
error_reporting(0);
?>
<html>
<head>
<style>
.popup_import{
 border: 1px solid black;
 width: 550px;
 height: auto;
 background: white;
 border-radius: 3px;
 margin: 0 auto;
 padding: 5px;

}

.format{
 color: red;
}

#userTable{
 border-collapse: collapse;
 margin: 0 auto;
 margin-top: 15px;
 width: 550px;
}

#but_import{
 margin-left: 10px;
 background-color:red;
}

</style>
</head>
<body>

<?php

$total_data = 0; $import_count = 0;
if(isset($_POST['but_import'])){
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["importfile"]["name"]);

  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  $uploadOk = 1;
  if($imageFileType != "csv" ) {
    $uploadOk = 0;
  }

  if ($uploadOk != 0) {
    if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_dir.'importfile.csv')) {

     // Checking file exists or not
     $target_file = $target_dir . 'importfile.csv';
     $fileexists = 0;
     if (file_exists($target_file)) {
       $fileexists = 1;
     }
     if ($fileexists == 1 ) {

      // Reading file
      $file = fopen($target_file,"r");
      $i = 0;

      $importData_arr = array();
      while(! feof($file)) {

       foreach(fgetcsv($file) as $key=>$value){
        $importData_arr[$i][] = $value;
       }

       $i++;
     }
     fclose($file);

     $skip = 0;
     // insert import data
     foreach($importData_arr as $data){
      if($skip != 0){
       $name = $data[0];
       $class = $data[1];
       
       // Checking duplicate entry
       //$sql = "select count(*) as allcount from user where username='" . $username . "' and fname='" . $fname . "' and  lname='" . $lname . "' and email='" . $email . "' ";

       //$retrieve_data = mysql_query($sql);
       //$row = mysql_fetch_array($retrieve_data);
       //$count = $row['allcount'];

       $res= $dbh->query("INSERT INTO subject VALUES('','$name','$class')");
	if($res){
		echo "<script>
		alert('csv imported successfully');
			window.location ='upload.php';
		</script>";
	}else{
		echo "<script>
		alert('csv imported successfully');
			window.location ='upload.php';
		</script>";
		//echo "<script>
		//alert('unable to upload file');
		//	window.location ='recoms/upload.php';
		//</script>";
	}
        // Insert record
      //  $ap = $dbh->query("insert into carseen(id,timet,class1,class2) values('0','".$time."','".$class1."','".$class2."')");
       // mysql_query($insert_query);
       
      }
      $skip ++;
     }
     $newtargetfile = $target_file;
     if (file_exists($newtargetfile)) {
       unlink($newtargetfile);
     }
    }
   }
  }
}
?>
 
<!-- Import form (start) -->
<div class="popup_import">
 <form method="post" action="" enctype="multipart/form-data" id="import_form">
  <table width="100%">

   <tr>
    <td colspan="2">
     <input type='file' name="importfile" id="importfile">
    </td>
   </tr>
   <tr>
    <td colspan="2" ><input type="submit" id="but_import" name="but_import" value="Import"></td>
   </tr>
  
  </table>
 </form>
</div>
<!-- Import form (end) -->

<!-- Displaying imported users -->
<table border="1" id="userTable">
  <tr>
   <td>Time</td>
   <td>Class1</td>
   <td>Class2</td>
    
   
  </tr>
  <?php
    
	//$ap = $dbh->query("SELECT * FROM carseen");
	//$pp = $dbh->query("SELECT count(subject_id) as counting  FROM subject");
	//while($x = $pp->fetch(PDO::FETCH_OBJ)){
		// $username= $x->counting; 
		 //echo $username;
		// $t=1;
		 $pu = $dbh->query("SELECT * FROM subject");
		// while(($username/4)>=$t){
			 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->subject_id; 
				 
                 $e= $x->name; 
				 $l= $x->class; 
				 
				//break;
			// }
			 	  echo "<tr>
			<td>".$f."</td>
            <td>".$e."</td>
            <td>".$l."</td>
			
           
        </tr>";
		//$t++;
		// }
	}
	
		
		
	
   ?>
</table>

</body>
</html>