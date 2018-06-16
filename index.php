<?php include('include/db.php');//calls the connection page with connection scripts
date_default_timezone_set('Africa/Nairobi');
$today = date("Y-m-dH:i:s");//sets the current date time zone
if(isset($_POST['login'])){ // checks whether user filled in all the information and clicked the login button
$uname = $_POST['email'];
$pass = md5($_POST['password']); // encrypts input password

if($uname && $pass){
	$sql = $dbh->query("SELECT * FROM administrators WHERE email='$uname' AND password='$pass'");//queries from the database for user login details
	$br = $dbh->query("SELECT * FROM students WHERE email='$uname' AND password='$pass'");
	$row = $sql->fetch(PDO::FETCH_OBJ); // fetch every row
	$rows = $br->fetch(PDO::FETCH_OBJ);
	if($row){
		
			$name = $row->email;
			$pwd = $row->password;
			$type = $row->interface;
			$_SESSION['staff'] = $row->userID;
			$_SESSION['pwd'] = $row->password;
			$_SESSION['ui'] = $row->interface;
			$_SESSION['user']= $row->email;
			$_SESSION['first'] = $row->firstName;
			$_SESSION['last'] = $row->lastName;
			if($name==$uname && $pass==$pwd){
				if($type=="bursar"){
					echo "<script>
				var x= confirm('Welcome $type ,Click ok to continue !!');
				
				if(x){
					window.location='staff/dashboard.php';
				}else{
					window.location='/recoms';
				}
				</script>";	
				}else{
					echo "<script>
				var x= confirm('Welcome $type ,Click ok to continue !!');
				
				if(x){
					window.location='home.php?user=$type';
				}else{
					window.location='/recoms';
				}
				</script>";	
				}
			}
			else{
				echo "<script>
				alert('Username or password is incorrect.  Try again later');
				window.location = '/recoms';
				</script>";	
			}
		
		
	}elseif($rows){
		    $name = $rows->email;
			$pwd = $rows->password;
			$type = $rows->interface;
			$_SESSION['pwd']= $rows->password;
			$_SESSION['ui'] = $rows->interface;
			$_SESSION['user']= $rows->email;
			$_SESSION['first'] = $rows->firstName;
			$_SESSION['last'] = $rows->lastName;
			$_SESSION['sno']= $rows->studentNo;
			if($name==$uname && $pass==$pwd){
				
				if($type=="student"){
				
					echo "<script>
				var x= confirm('Welcome $_SESSION[first], Click OK to continue !!');
				
				if(x){
					window.location='home.php?user=$type';
				}else{
					alert('Go back to homepage !');
					window.location='/recoms';
				}
				</script>";
				}
				else{
					echo "<script>
				var x= confirm('Welcome $type ,Click ok to continue !!');
				
				if(x){
					window.location='home.php?user=$type';
				}else{
					window.location='/recoms';
				}
				</script>";
				}
				
				
				
				
			}
			else{
				echo "<script>
				alert('UserName or password is incorrect. Try again');
				window.location = '/recoms';
				</script>";	
			}
		
		
	}else{
				echo "<script>
				alert('UserName or password is incorrect. Try again');
				window.location = '/recoms';
				</script>";	
	
	}
	
}	
}elseif(isset($_REQUEST['register'])){
$sno = $dbh->query("SELECT studentNo FROM students")->fetchColumn();
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$pass = md5($_POST['password']);
$email = $_POST['email'];
$yos = $_POST['yos'];
$reg = $_POST['regn'];
$std = $_POST['sno'];
$course = $_POST['course'];

if($std !=$sno ){
$var = $dbh->query("INSERT INTO students VALUES('$std','$reg','$course','$yos','$email','$pass','$fname','$lname','','student')");
if($var){
echo "<script>
	alert('Registration successful');
	window.location ='/recoms';
</script>";
}else{
echo "Error:".$e->getMessage();
}

}else{
echo "<script>
alert('Student Number already exists');
window.location = 'index.php';
</script>";
}




}
 ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <title>STERAC | Login</title>
	 <link rel="icon" href="assets/img/loog.png" type="images/icon" />
	 <link rel="icon" href="assets/img/loog.png" type="images/icon" />
    <link rel="stylesheet" href="assets/css/style.css"/>
	   <link href="assets/css/bootstrap.css" rel="stylesheet"/>
      <script src="js/jquery.min.js"></script>
	  <script src="js/bootstrap.min.js" ></script>
	   <script src="js/angular.min.js" ></script> <!-- angular javascript script for validation -->
      <script src="js/jquery.ui.shake.js"></script>
   </head>
   <body > 
      <div id="main">
	 
         <div id="box">
		 <center> <img src ="assets/img/log.png" height="50px" width="250px"/></center>
		  <h1 style="font-size:13px"> Report & Fees System - Login Panel </h1>
            <form ng-app="app" ng-controller="ctrl" action="" method="post" name="login" novalidate>
               <input type="email" name="email"  ng-model="email" class="inputx username-field"  id="username" placeholder ="Email Address" required /><br/>
					<span class="ngshow" ng-show="login.email.$error.email">Invalid email address. Email must contain @ character</span>
               <input type="password" name="password" ng-model="password" class="inputx password-field" ng-model="password" ng-minlength="7" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/"id="password" placeholder ="Password" required /><br/>
					<span class="ngshow" ng-show="login.password.$error.minlength">Password must be 7 characters and alphanumeric
			   </span><br/>
              <center> <input type="submit" style="align:center" ng-disabled="login.$invalid" class="btn btn-primary" name="login" value="Login" id="login"/></center>
             
			</form> 
			<script>
			var app = angular.module("app",[]);
			app.controller("ctrl",function($scope){
			});
			
			</script>
	
         </div>
	  
	  
	  
      </div>
      </div>
   </body>
</html>
