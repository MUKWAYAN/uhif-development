<?php
include('include/db.php');
error_reporting(0);
if(empty($_SESSION['user']))
{
echo "<script>
		alert('Guests can not access this page. Please login to continue');
		window.location = '/recoms';
		
		</script>";
}
	$user = $_SESSION['last'];
	$fname = $_SESSION['first'];
	$name = $fname.'&nbsp'.$user;
	$email = $_SESSION['user'];
	$ui = $_SESSION['ui'];



if(isset($_POST['change_profile'])){
$f = $_POST['first'];
$l = $_POST['last'];
$e = $_POST['email'];
$old = $_POST['old'];
$new = $_POST['new'];

if($old && $new){
$pwd = md5($new);
if($ui=="teacher"){
$pwd1= md5($_POST['old']);
$pass = $dbh->query("SELECT password FROM administrators WHERE email='$email'")->fetchColumn();
if($pwd1 == $pass){
$update = $dbh->query("UPDATE administrators set firstName='$f',lastName='$l',email='$email',password='$pwd' WHERE email='$email'");

if($update){

echo "<script>
	alert('Profile updated successfully');
	window.location= '/recoms';
	</script>";
	}else{
	echo "Error:".$e->getMessage();
	}
}else{
echo "<script>
	alert('Old password is incorrect. Try inputting correct password');
	window.location= 'home.php?edit-profile';
	</script>";
}
}else{
$pwd = md5($new);
$pwd1= md5($_POST['old']);
$pass = $dbh->query("SELECT password FROM users WHERE email='$email'")->fetchColumn();
if($pwd1 == $pass){
$update = $dbh->query("UPDATE users set firstName='$f',lastName='$l',email='$email',password='$pwd' WHERE email='$email'");

if($update){

echo "<script>
	alert('Profile updated successfully');
	window.location= '/recoms';
	</script>";
	}else{
	echo "Error:".$e->getMessage();
	}

}
else{
echo "<script>
	alert('Old password incorrect. Try again');
	window.location= 'home.php?edit-profile';
	</script>";
}


}

}
else{
    echo "<script>
	alert('New password is required');
	window.location= 'home.php?edit-profile';
	</script>";

}


}elseif(isset($_POST['add_teacher'])){
$fname = $_POST['first'];
$lname = $_POST['last'];
$pass = md5($_POST['pass']);
$title = $_POST['title'];

$image = addslashes(file_get_contents($_FILES['photo']['tmp_name']));
                                $image_name = addslashes($_FILES['photo']['name']);
                                $image_size = getimagesize($_FILES['photo']['tmp_name']);

                                move_uploaded_file($_FILES["photo"]["tmp_name"], "staff/uploads/" . $_FILES["photo"]["name"]);
                                $file = "staff/uploads/" . $_FILES["photo"]["name"];
$email = $_POST['email'];
$dept = $_POST['class'];

if($pass && $email ){
$rs  = $dbh->query("INSERT INTO administrators VALUES('','$email','$pass','$title','$fname','$lname','$dept','$file')");

if($rs){
echo "<script>
	alert('New user added successfully');
	window.location= 'home.php?manage_teacher';
	</script>";

}
}
}elseif(isset($_POST['add_cunit'])){
	$code = $_POST['code'];
	$cd = $dbh->query("SELECT courseCode FROM course_units WHERE courseCode='$code'")->fetchColumn();
	$cname = $_POST['cname'];
	$cu  = $_POST['cunit'];
if($code && $cname && $cu){
if(!$cd){
	
$rs = $dbh->query("INSERT INTO course_units VALUES('$code','$cname','$cu')");

if($rs){
echo "<script>
	alert('Course unit added successfully');
	window.location= 'home.php?manage_subject';
	</script>";
}
	
}else{
	echo "<script>
	alert('Course unit already exists');
	window.location= 'home.php?manage_subject';
	</script>";
	
}


}

}elseif(isset($_POST['num'])){
	   // reporting();
		?>
		
		<?php
		
}
  function aggregate($sub){
	 if($sub>=80){
		 $agg="D1";
		 $no = 1;
	 }elseif($sub>=75){
		 $agg="D2";
		 $no = 2;
	 }elseif($sub>=65){
		 $agg="C3";
		 $no = 3;
	 }elseif($sub>=60){
		 $agg="C4";
		 $no = 2;
	 }elseif($sub>=55){
		 $agg="C5";
		 $no = 5;
	 }elseif($sub>=50){
		 $agg="C6";
		 $no = 6;
	 }elseif($sub>=45){
		 $agg="P7";
		 $no = 7;
	 }elseif($sub>=40){
		 $agg="P8";
		 $no = 8;
	 }else{
		 $agg = "F9";
		 $no = 9;
	 }
	 return $no;
 }
  function division($total_agg){
	 if($total_agg <= 12){
		 $div =1;
	 }elseif($total_agg <= 24){
		 $div =2;
	 }elseif($total_agg <= 28){
		 $div =3;
	 }elseif($total_agg <= 32){
		 $div =4;
	 }else{
		 $div = "Failed";
	 }
	 return $div;
 }
 function upload(){
	

     
      $student = $_POST['student'];
	   $Year = $_POST['year'];
	  $Term = $_POST['term'];
	  $session = $_POST['session'];
	  $Class = $_POST['class'];
	  if($Class=="Primary one"||$Class=="Primary two"||$Class=="Primary three"){
		   $re = $_POST['re'];
		   $eng=$_POST['eng'];
		   $lug=$_POST['lug'];
		   $lita=$_POST['lita'];
		   $litb=$_POST['litb'];
		   $num = $_POST['num'];
		   include('config.php');
       // Checking duplicate entry
       $sql = $dbh->query("select count(*) as allcount from lower_upper where student_lid='" . $student . "' and class='" . $Class . "' and  session='" . $session . "' and term='" . $Term . "' and year='" . $Year . "'and 
	   english='" . $eng . "'and re='" . $re . "'and lita='" . $lita . "'and luganda='" . $lug . "' ");
       while($x = $sql->fetch(PDO::FETCH_OBJ)){
		 $counting= $x->allcount; 
	   }
	   if($counting>0){
			echo "<script>
		alert('file was already uploaded ');
			window.location ='home.php?mark_upper';
		</script>";
		}else{
       $res= $dbh->query("INSERT INTO lower_upper VALUES('','$student','$eng','$num','$lita','$litb','$lug','$re','$session','$Term','$Year','$Class')");
	if($res){
		$id="MID";
		        $avg_eng=0;
		        $avg_lug=0;
		         $avg_lita= 0;
                  $avg_litb= 0; 
                 $avg_num= 0;
                  $avg_re= 0; 				  
		           $total_mid=0;
	                $total_end=0;
					$total_avg=0;
					$total_agg=0;
					$sci_mid= 0; 
                  $eng_mid= 0; 
				  $re_mid= 0;
                  $lug_mid= 0; 
				  $lita_end= 0; 
				   $litb_mid= 0; 
				  $num_mid= 0; 
					  $eng_end= 0; 
					  $re_end= 0;
					  $lug_end= 0;
					  $lita_end= 0; 
					  $litb_end= 0;
					  $num_end= 0;
		if($session=="EOT"){
			$pu = $dbh->query("SELECT * FROM lower_upper where session='$session' and student_lid='$student' and class='$Class' and year='$Year' and term='$Term'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $ter = $x->session;
				  $lid=$x->student_lid;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->student_lid;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $lug_end= $x->luganda; 
                  $eng_end= $x->english; 
				  $lita_end= $x->lita;
                  $litb_end= $x->litb; 
				  $num_end= $x->numbers;
                  $re_end= $x->re;        				  
	 $mid= $dbh->query("SELECT * FROM lower_upper where student_lid='$lid'and session='$id'and class='$clas' and term='$period' and year='$yea'");
	               while($y = $mid->fetch(PDO::FETCH_OBJ)){
					   $lug_mid= $y->luganda; 
					  $eng_mid= $y->english; 
					  $lita_mid= $y->lita;
					  $litb_mid= $y->litb;
					  $num_mid= $y->numbers;
					  $re_mid= $y->re;
				   
				}}
	             $avg_eng= ($eng_end/2) + ($eng_mid/2); 
				  $avg_num= ($num_end/2) + ($num_mid/2);
                  $avg_lug= ($lug_end/2) + ($lug_mid/2);
                  $avg_re= ($re_end/2) + ($re_mid/2);  
                  $avg_lita= ($lita_end/2) + ($lita_mid/2);
                  $avg_litb= ($litb_end/2) + ($litb_mid/2); 				  
		           $total_mid=($eng_mid + $litb_mid + $lita_mid + $num_mid+ $lug_mid + $re_mid);
	                $total_end=($eng_end + $lita_end + $litb_end + $num_end+ $re_end + $lug_end);
					$total_avg=($avg_eng + $avg_lita + $avg_litb + $avg_num+ $avg_lug + $avg_re);
					$total_agg=(aggregate($avg_eng)+aggregate($avg_lug)+aggregate($avg_lita)+aggregate($avg_litb)+aggregate($avg_re)+aggregate($avg_num));
				 
					$rs  = $dbh->query("INSERT INTO lower_upper_final VALUES('','$e','$clas','$period','$yea',
					'".aggregate($avg_eng)."','".aggregate($avg_lug)."','".aggregate($avg_lita)."','".aggregate($avg_litb)."',
					'".aggregate($avg_re)."','".aggregate($avg_num)."','$avg_lug','$avg_eng','$avg_lita','$avg_litb','$avg_num','$avg_re','$total_avg','$total_agg','".division($total_agg)."')");
				 
		}else{
		$pu = $dbh->query("SELECT * FROM lower_upper where session='$session' and student_lid='$student' and class='$Class' and year='$Year' and term='$Term'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $ter = $x->session;
				$p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $lug_mid= $x->luganda; 
                  $eng_mid= $x->english; 
				  $lita_mid= $x->lita;
                  $litb_mid= $x->litb; 
				  $num_mid= $x->numbers;
                  $re_mid= $x->re; 
	 
				}
				 $total_mid=($eng_mid + $lug_mid + $num_mid + $re_mid+ $lita_mid + $litb_mid);
	               
					$total_agg=(aggregate($eng_mid)+aggregate($lug_mid)+aggregate($num_mid)+aggregate($re_mid)+aggregate($lita_mid)+aggregate($litb_mid));
				 
					$rs  = $dbh->query("INSERT INTO lower_upper_mid VALUES('','$f',
					'".aggregate($lug_mid)."','".aggregate($eng_mid)."','".aggregate($num_mid)."','".aggregate($re_mid)."','".aggregate($lita_mid)."',
					'".aggregate($litb_mid)."','".$total_mid."','$total_agg','".division($total_agg)."','$clas','$period','$yea')");
				}
	             
		    echo "<script>
		alert('results uploaded successfully');
			
		</script>";
	}else{
		echo "<script>
		alert('unable to upload results, please try again later');
			
		</script>";
		
	}
        
      
  }
	  }else{
		 
	   $English = $_POST['english'];
	   $Science = $_POST['science'];
	   $SST = $_POST['sst'];
	   $Math = $_POST['math'];  
	  include('config.php');
       // Checking duplicate entry
       $sql = $dbh->query("select count(*) as allcount from result where student_lid='" . $student . "' and class='" . $Class . "' and  session='" . $session . "' and term='" . $Term . "' and year='" . $Year . "'and 
	   english='" . $English . "'and science='" . $Science . "'and sst='" . $SST . "'and math='" . $Math . "' ");
       while($x = $sql->fetch(PDO::FETCH_OBJ)){
		 $counting= $x->allcount; 
	   }
	   if($counting>0){
			echo "<script>
		alert('file was already uploaded ');
			window.location ='home.php?mark_upper';
		</script>";
		}else{
       $res= $dbh->query("INSERT INTO result VALUES('','$student','$Class','$session','$Term','$Year','$English','$Science','$SST','$Math')");
	if($res){
		$id="MID";
		        $avg_eng=0;
		        $avg_math=0;
		         $avg_sst= 0;
                  $avg_sci= 0;  	
		           $total_mid=0;
	                $total_end=0;
					$total_avg=0;
					$total_agg=0;
					$sci_mid= 0; 
                  $eng_mid= 0; 
				  $sst_mid= 0;
                  $math_mid= 0; 
				  $sci_end= 0; 
					  $eng_end= 0; 
					  $sst_end= 0;
					  $math_end= 0;
		if($session=="EOT"){
			$pu = $dbh->query("SELECT * FROM result where session='$session' and student_lid='$student' and class='$Class' and year='$Year' and term='$Term'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				  $lid=$x->student_lid;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->student_lid;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $sci_end= $x->science; 
                  $eng_end= $x->english; 
				  $sst_end= $x->sst;
                  $math_end= $x->math; 
	 $mid= $dbh->query("SELECT * FROM result where student_lid='$lid'and session='$id'and class='$clas' and term='$period' and year='$yea'");
	               while($y = $mid->fetch(PDO::FETCH_OBJ)){
					   $sci_mid= $y->science; 
					  $eng_mid= $y->english; 
					  $sst_mid= $y->sst;
					  $math_mid= $y->math;
				   
				}}
	             $avg_eng= ($eng_end/2) + ($eng_mid/2); 
				  $avg_math= ($math_end/2) + ($math_mid/2);
                  $avg_sst= ($sst_end/2) + ($sst_mid/2);
                  $avg_sci= ($sci_end/2) + ($sci_mid/2);  	
		           $total_mid=($eng_mid + $math_mid + $sst_mid + $sci_mid);
	                $total_end=($eng_end + $math_end + $sst_end + $sci_end);
					$total_avg=$avg_eng + $avg_math + $avg_sci + $avg_sst;
					$total_agg=(aggregate($avg_eng)+aggregate($avg_math)+aggregate($avg_sci)+aggregate($avg_sst));
				 
					$rs  = $dbh->query("INSERT INTO graded_result VALUES('','$e','$clas','$period','$yea',
					'$avg_math','$avg_eng','$avg_sci','$avg_sst','$total_avg','".aggregate($avg_math)."','".aggregate($avg_eng)."','".aggregate($avg_sci)."',
					'".aggregate($avg_sst)."','$total_agg','".division($total_agg)."')");
				 
		}else{
		$pu = $dbh->query("SELECT * FROM result where session='$session' and student_lid='$student' and class='$Class' and year='$Year' and term='$Term'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				$p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $sci_mid= $x->science; 
                  $eng_mid= $x->english; 
				  $sst_mid= $x->sst;
                  $math_mid= $x->math; 
	 
				}
				 $total_mid=($eng_mid + $math_mid + $sst_mid + $sci_mid);
	               
					$total_agg=(aggregate($eng_mid)+aggregate($math_mid)+aggregate($sci_mid)+aggregate($sst_mid));
				 
					$rs  = $dbh->query("INSERT INTO mid_upper VALUES('','$f',
					'".aggregate($eng_mid)."','".aggregate($math_mid)."','".aggregate($sci_mid)."',
					'".aggregate($sst_mid)."','".$total_mid."','$total_agg','".division($total_agg)."','$clas','$period','$yea')");
				}
	             
		    echo "<script>
		alert('results uploaded successfully');
			
		</script>";
	}else{
		echo "<script>
		alert('unable to upload results, please try again later');
			
		</script>";
		
	}
        
      
  }
 }}
 function upload_lower(){

       $student = $_POST['student'];
	   $math_concepts = $_POST['math'];
	   $social_devt = $_POST['social'];
	   $health_habits= $_POST['HH'];
	   $laguage_devt_1 = $_POST['lang'];
	   $read= $_POST['reading'];
	  
	   $Year = $_POST['year'];
	  $Term = $_POST['term'];
	  $session = $_POST['session'];
	  $Class = $_POST['class'];
	  include('config.php');
       // Checking duplicate entry
       $sql = $dbh->query("select count(*) as allcount from result_lower where student_lid='" . $student . "' and class='" . $Class . "' and  session='" . $session . "' and term='" . $Term . "' and year='" . $Year . "'and 
	   math_concepts='" . $math_concepts . "'and health_habits='" . $health_habits . "'and social_devt='" . $social_devt . "'and reading='" . $read . "' ");
       while($x = $sql->fetch(PDO::FETCH_OBJ)){
		 $counting= $x->allcount; 
	   }
	   if($counting>0){
			echo "<script>
		alert('marks were already uploaded ');
			
		</script>";
		}else{
       $res= $dbh->query("INSERT INTO result_lower VALUES('','$student','$math_concepts','$social_devt','$health_habits','$laguage_devt_1','$read','$session','$Term','$Year','$Class')");
	if($res){
		if($session=="EOT"){
			report_lower();
		}else{
			mid_report();
		}
		echo "<script>
		alert('results uploaded successfully');
			
		</script>";
	}else{
		echo "<script>
		alert('unable to upload results, ');
			
		</script>";
		
	}
		}   
      
 }
  function report_lower(){
	
	include('config.php');
	$ed = "EOT";
	$id ="MID";
	
		 $pu = $dbh->query("SELECT * FROM result_lower where session='$ed'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->student_lid;
				  }
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
					  $math_end= $x->math_concepts; 
                  $social_end= $x->social_devt; 
				  $health_end= $x->health_habits;
                  $lang_end= $x->laguage_devt_1; 
				   
                  $reading_end= $x->reading;
				 
	 $mid= $dbh->query("SELECT * FROM result_lower where student_lid='$e'and session='$id'and class='$clas' and term='$period' and year='$yea'");
	               while($y = $mid->fetch(PDO::FETCH_OBJ)){
				 
				   $math_mid= $x->math_concepts; 
                  $social_mid= $x->social_devt; 
				  $health_mid= $x->health_habits;
                  $lang_mid= $x->laguage_devt_1; 
				  
                  $reading_mid= $x->reading; 
				   }}
	              $avg_social= (($social_end+$social_mid)/2); 
				  $avg_math= (($math_end+$math_mid)/2);
                  $avg_health= (($health_end+$health_mid)/2);
                  $avg_lang= (($lang_end+$lang_mid)/2); 
                  
                   $avg_reading= (($reading_end+$reading_mid)/2);  				  
		           $total_mid=($health_mid+$math_mid+$lang_mid+$social_mid+$reading_mid);
	                $total_end=($health_end+$math_end+$social_end+$health_end+$reading_end);
					$total_avg=$avg_social+$avg_math+$avg_lang+$avg_health+$avg_reading;
					
					$rs  = $dbh->query("INSERT INTO lower_grade VALUES('','$e','$avg_math','$avg_health','$avg_lang','$avg_social','$avg_reading','$total_avg','$total_end','$total_mid','$clas','$period','$yea')"); 
					
				 
 }
 function mid_report(){
	
	include('config.php');
	$ed = "EOT";
	$id ="MID";
	
		 $pu = $dbh->query("SELECT * FROM result_lower where session='$id'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $math_mid= $x->math_concepts; 
                  $social_mid= $x->social_devt; 
				  $health_mid= $x->health_habits;
                  $lang_mid= $x->laguage_devt_1; 
				  
                  $reading_mid= $x->reading; 
				 
	}
	           				  
		           $total_mid=($health_mid+$math_mid+$lang_mid+$social_mid+$reading_mid);
	                
					
					$rs  = $dbh->query("INSERT INTO mid_lower VALUES('','$f','$total_mid','$clas','$period','$yea')");
				 
 }

 function reporting(){
	 include('config.php');
	 $ed = "EOT";
	 
	 $d=$_REQUEST['num'];
	$id ="MID";
	$count=0;
	          $pu = $dbh->query("SELECT * FROM result where session='$ed'and result_id ='$d'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $image= $xt->photo;
				 $birth = $xt->DOB;
				 $balance = $xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				  $count=$count+1;
				  
				 $sci_mid= $x->science; 
                  $eng_mid= $x->english; 
				  $sst_mid= $x->sst;
                  $math_mid= $x->math; 
				   $lid=$x->student_lid;
				$sql = $dbh->query("select count(*) as allcount from graded_result where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
	 	      $p = $dbh->query("SELECT * FROM result where  session='$id' and class='$clas'and year='$yea'and term='$period' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					
					 $sci_end= $xa->science; 
                  $eng_end= $xa->english; 
				  $sst_end= $xa->sst;
                  $math_end= $xa->math;
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from graded_result where student_lid='" . $lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id = $ag->grade_id;
					$sci=$ag->sci_agg;
					$math=$ag->math_agg;
					$sst=$ag->sst_agg;
					$eng=$ag->eng_agg;
					$div=$ag->div;
					$sci_avg=$ag->sci_av;
					$math_avg=$ag->math_av;
					$eng_avg=$ag->eng_av;
					$sst_avg=$ag->sst_av;
					$totalagg =$ag->total_agg;
					$totalavg =$ag->total_avg;
					$L = $dbh->query("select * from upper_position where grade_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="report" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px">
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="6"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="6">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="7">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $eng_end;?></td>
				<td style="border:1px solid black;"><?php echo $eng_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sci_mid;?>  </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sst_mid;?></td>
				<td style="border:1px solid black;"><?php echo $sst_end;?></td>
				<td style="border:1px solid black;"><?php echo $sst_avg;?></td>
				<td style="border:1px solid black;"><?php echo $sst ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">400</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$eng_mid+$sst_mid+$sci_mid);?> </td>
				<td style="border:1px solid black;"><?php echo ($math_end+$eng_end+$sst_end+$sci_end);?></td>
				<td style="border:1px solid black;"><?php echo $totalavg;?></td>
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Balance:<br/>    <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					
					
					
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				 }}}
 }
 function reportingr(){
	 include('config.php');
	 $ed = "EOT";
	 
	 $c=$_REQUEST['sch'];
	$id ="MID";
	$count=0;
	          $pu = $dbh->query("SELECT * FROM result where session='$ed'and student_lid ='$c'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  $image= $xt->photo;
				  $birth=$xt->birth;
				  $balance=$xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				  $count=$count+1;
				  
				 $sci_mid= $x->science; 
                  $eng_mid= $x->english; 
				  $sst_mid= $x->sst;
                  $math_mid= $x->math; 
				   $lid=$x->student_lid;
				$sql = $dbh->query("select count(*) as allcount from graded_result where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
	 	      $p = $dbh->query("SELECT * FROM result where  session='$id' and class='$clas'and year='$yea'and term='$period' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					
					 $sci_end= $xa->science; 
                  $eng_end= $xa->english; 
				  $sst_end= $xa->sst;
                  $math_end= $xa->math;
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from graded_result where student_lid='" . $lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id = $ag->grade_id;
					$sci=$ag->sci_agg;
					$math=$ag->math_agg;
					$sst=$ag->sst_agg;
					$eng=$ag->eng_agg;
					$div=$ag->div;
					$sci_avg=$ag->sci_av;
					$math_avg=$ag->math_av;
					$eng_avg=$ag->eng_av;
					$sst_avg=$ag->sst_av;
					$totalagg =$ag->total_agg;
					$totalavg =$ag->total_avg;
					$L = $dbh->query("select * from upper_position where grade_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="rep" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					 
					
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="6"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image;?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="6">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="7">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $eng_end;?></td>
				<td style="border:1px solid black;"><?php echo $eng_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sci_mid;?>  </td>
				<td style="border:1px solid black;"> <?php echo $sci_end;?> </td>
				<td style="border:1px solid black;"><?php echo $sci_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $sci ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sst_mid;?></td>
				<td style="border:1px solid black;"><?php echo $sst_end;?></td>
				<td style="border:1px solid black;"><?php echo $sst_avg;?></td>
				<td style="border:1px solid black;"><?php echo $sst ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">400</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$eng_mid+$sst_mid+$sci_mid);?> </td>
				<td style="border:1px solid black;"><?php echo ($math_end+$eng_end+$sst_end+$sci_end);?></td>
				<td style="border:1px solid black;"><?php echo $totalavg;?></td>
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Balance:<br/>  <?php echo $balance;?> </td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				 }}}
 }
 function reporting_mid(){
	 include('config.php');
	 $ed = "EOT";
	 
	 $c=$_REQUEST['sch'];
	$id ="MID";
	$count=0;
	          $pu = $dbh->query("SELECT * FROM result where session='$id'and student_lid='$c'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				  $count=$count+1;
				  
				 $sci_mid= $x->science; 
                  $eng_mid= $x->english; 
				  $sst_mid= $x->sst;
                  $math_mid= $x->math;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth= $xt->DOB;
				 $image = $xt->photo;
				 $balance= $xt->balance;
				  }
				  
				$sql = $dbh->query("select count(*) as allcount from mid_upper where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
	 	     
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from mid_upper where result_id ='" . $f . "'  ORDER BY total desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$d = $ag->mid_id;
					$sci=$ag->science;
					$math=$ag->math;
					$sst=$ag->sst;
					$eng=$ag->english;
					$div=$ag->div;
					
					$totalagg =$ag->total_agg;
					$L = $dbh->query("select * from mid_upper_position where mid_id='" . $d . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="mid_report" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					 
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="4"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image;?>" alt="logo" height="100px" width="85px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="4">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="5">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sci_mid;?>  </td>
				
				<td style="border:1px solid black;"><?php echo $sci ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sst_mid;?></td>
				
				<td style="border:1px solid black;"><?php echo $sst ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">400</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$eng_mid+$sst_mid+$sci_mid);?> </td>
				
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/><?php echo $balance?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				}}
 }
 function reporting_midd(){
	 include('config.php');
	 $ed = "EOT";
	 
	 $c=$_REQUEST['mid_num'];
	$id ="MID";
	$count=0;
	          $pu = $dbh->query("SELECT * FROM result where session='$id'and result_id='$c'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				  $count=$count+1;
				  
				 $sci_mid= $x->science; 
                  $eng_mid= $x->english; 
				  $sst_mid= $x->sst;
                  $math_mid= $x->math;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth= $xt->DOB;
				 $image= $xt->photo;
				 $balance= $xt->balance;
				  }
				  
				$sql = $dbh->query("select count(*) as allcount from mid_upper where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
	 	     
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from mid_upper where result_id ='" . $f . "'  ORDER BY total desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$d = $ag->mid_id;
					$sci=$ag->science;
					$math=$ag->math;
					$sst=$ag->sst;
					$eng=$ag->english;
					$div=$ag->div;
					
					$totalagg =$ag->total_agg;
					$L = $dbh->query("select * from mid_upper_position where mid_id='".$d."' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="mid" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					 
					
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="4"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image;?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="4">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="5">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sci_mid;?>  </td>
				
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sst_mid;?></td>
				
				<td style="border:1px solid black;"><?php echo $sst ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">400</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$eng_mid+$sst_mid+$sci_mid);?> </td>
				
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/>  <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				}}
 }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>STERAC | Home</title>
		 <link rel="icon" href="assets/img/loog.png" type="images/icon" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="MUKWAYA NICHOLAS">
        <!-- Le styles -->
        <link href="assets/css/bootstrap.css" rel="stylesheet"/>
        <link href="assets/css/style-content.css" rel="stylesheet"/>
        <script src="js/jquery.min.js"></script>
	  <script src="js/bootstrap.min.js" ></script>		
		<script src="assets/js/slider.js" ></script>
		 <script src="js/angular.min.js" ></script> <!-- angular javascript script for validation -->
      <script src="js/jquery.ui.shake.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap.min.css" media="screen">
	 <!-- DataTables CSS -->
    <link href="assets/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- DataTables Responsive CSS -->
    <link href="assets/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet" type="text/css">

    <!-- Custom Fonts -->
    
		<script type="text/javascript">
		var timer = setInterval("myTime()",2); 
		function myTime(){
		var t = new Date();
		document.getElementById("date").innerHTML = t.toLocaleString(); // displays current time in a page with div element date
		}
		var Image= new Array("assets/img/im1.png","assets/img/im2.png"); // array to autoplay the images
			var Image_Number=0;
			var Image_Length= Image.length - 1;
			function change_image(num){
			Image_Number= Image_Number + num;
			if(Image_Number >Image_Length){
			Image_Number=0;
			}
			if(Image_Number<0){
			Image_Number= Image_Length;
			}
			document.slideshow.src=Image[Image_Number];
			return false;
			}
			function autoplay(){
			setInterval("change_image(1)",2500);
			}
		
		</script>
		<script src="js/angular.min.js"></script>
		
				 
		<script type="text/javascript"> 
			var timer = setInterval("myTime()",2);
			function myTime(){
			var t = new Date();
			document.getElementById("date").innerHTML = t.toLocaleString();
			}
		</script>
		
	<script >
	var app = angular.module("myApp",[]);
	app.controller("control",function($scope){
		$scope.View = function(){
		$scope.showView = !$scope.showView;
		}	
	});
	</script>
        
    </head>

    <body onload="javascript:autoplay()">

        <div class="container">
			
        
		<div class="row">
                <div class="span12">
                    <div class="wrapper-content">
                        <div class="header"><h1></h1>
	
							<div class="search">
							
							<div id="date" style="color:black">
							
							</div>
								<div class="control-group" style="color:black">
							<?php echo $name.'&nbsp';
							if($ui=="teacher"){
								echo '(Teacher)';
							}else{
							echo '(Administrator)';
							}
							?>
								</div>	
							</div>
                        </div>
             				<div class="menu">
							<div class="navbar">
								<div class="navbar-inner">
									<div class="container">
										<ul class="nav">
											<li >
												<a href='home.php'><i class="icon-home icon-white"></i>Home</a><li class="divider-vertical"></li>
											</li>
											<li class="dropdown active">
												<a href="#" data-toggle="dropdown" class="dropdown-toggle">Students<b class="caret"></b></a>
												<ul class="dropdown-menu">
														<li><a href="#best"  title="Best Pupils" data-toggle="modal" >Best Performing Students</a></li>
														<li><a href="#worst"  title="Worst Pupils" data-toggle="modal" >Worst Performing Students</a></li>
														<li><a href="#total"  title="Total Students" data-toggle="modal" >Total Students</a></li>
														
												
													</ul>
											</li>
											
											<?php if($ui=="admin"){?>
											<li class="divider-vertical"></li>
											
											<li class="dropdown active">
												<a data-toggle="dropdown" class="dropdown-toggle" href="#">MANAGEMENT<b class="caret"></b></a>
													<ul class="dropdown-menu">
														<li><a href="?new_teacher"  title="Add Teacher" >Add User</a></li>
														<li><a href="?manage_teacher"  title="Manage Teacher" >Manage Users </a></li>
														<li><a href="?new_subject"  title="Add Subject" >Add Subject</a></li>
														<li><a href="?manage_subject"  title="Manage Subject" >Manage Subjects</a></li>
												
													</ul>
											</li>
											<?php } ?>
											<li class="divider-vertical"></li>
											<li class="dropdown active">
												<a data-toggle="dropdown" class="dropdown-toggle" href="#"> User Guide<b class="caret"></b></a>
													<ul class="dropdown-menu">
														<li><a href="include/nursery_ section.csv"  title="Download format for writing nursery section results"
														onclick="return confirm('You are about to download User guide for REPORTS upload.
														Are you sure you want to continue?')">
														<img src="assets/img/excel.png" height="20px" width="20px"></img>&nbsp;Download Results Format(nursery) </a></li>
														<li><a href="include/PRIMARY SECTION.csv"  title="Download format for writing primary section results"
														onclick="return confirm('You are about to download User guide for REPORTS upload.
														Are you sure you want to continue?')">
														<img src="assets/img/excel.png" height="20px" width="20px"></img>&nbsp;Download Results Format(primary) </a></li>
												</ul>
											</li>
											<li class="divider-vertical"></li>
											<li class="dropdown active">
												<a data-toggle="dropdown" class="dropdown-toggle" href="#"> My Account<b class="caret"></b></a>
													<ul class="dropdown-menu">
														<li><a href="?edit-profile"  title="Edit Profile" >Edit Profile </a></li>
												<li><a href='logout.php' title="#">Logout </a></li>
													</ul>
											</li>	
											<li class="divider-vertical"></li>
											
											
										</ul>
										<?php 
										?>
										<form action="?search" method="post">
											<input type="search" name="search" class="cst-search" list="datalist1" placeholder="Search Student by Name"
											style="border-radius:5px;" required
											/>
											<datalist id="datalist1">
												<?php
												$qr = $dbh->query("SELECT * FROM student_lower");
												while($app = $qr->fetch(PDO::FETCH_OBJ)){
													?>
												<option value="<?php echo $app->name;?>"></option>
												<?php	
												}
												?>
												</datalist>
											</form>
										<?php
										
										?>
													<div class="modal fade" id="best" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Details</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_four" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?best'">
							<center>
							<h4 class="hx" > Generate Pupils </h4></br>
							<label for="class">Class </label>
							<select name="class" required="required"  >
								<option value="" > >> Select Class  << </option>
								
								<option value="Primary one" > Primary one </option>
								<option value="Primary two" > Primary two</option>
								<option value="Primary three" > Primary three</option>
								<option value="Primary four" > Primary four</option>
								<option value="Primary five" > Primary five</option>
								<option value="Primary six" > Primary Six</option>
								<option value="Primary seven" > Primary Seven</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
		<a href="?best" 	><input type="submit" ng-disabled="r_four.$invalid" class="btn btn-primary" name="best"  value="Process Pupils"/></a>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
				<div class="modal fade" id="worst" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Details</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_four" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?worst'">
							<center>
							<h4 class="hx" > Generate Pupils </h4></br>
							<label for="class">Class </label>
							<select name="class" required="required"  >
								<option value="" > >> Select Class  << </option>
								
								<option value="Primary one" > Primary one </option>
								<option value="Primary two" > Primary two</option>
								<option value="Primary three" > Primary three</option>
								<option value="Primary four" > Primary four</option>
								<option value="Primary five" > Primary five</option>
								<option value="Primary six" > Primary Six</option>
								<option value="Primary seven" > Primary Seven</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
		<a href="?worst" 	><input type="submit" ng-disabled="r_four.$invalid" class="btn btn-primary" name="worst"  value="Process Pupils"/></a>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
				<div class="modal fade" id="total" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Details</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_four" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?total'">
							<center>
							<h4 class="hx" > Generate Pupils </h4></br>
							<label for="class">Class </label>
							<select name="class" required="required"  >
								<option value="" > >> Select Class  << </option>
								
								<option value="Primary one" > Primary one </option>
								<option value="Primary two" > Primary two</option>
								<option value="Primary three" > Primary three</option>
								<option value="Primary four" > Primary four</option>
								<option value="Primary five" > Primary five</option>
								<option value="Primary six" > Primary Six</option>
								<option value="Primary seven" > Primary Seven</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
		<a href="?total" 	><input type="submit" ng-disabled="r_four.$invalid" class="btn btn-primary" name="total"  value="Process Pupils"/></a>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
	
									</div>
								</div>
							</div>
						</div>
                    </div>
					
                    <div class="span12 box-content">
		
					<div class="modal fade" id="report_four" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_four" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary four" > >> Primary Four << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
		<a href="?report" 	><input type="submit" ng-disabled="r_four.$invalid" class="btn btn-primary" name="report"  value="Process Reports"/></a>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
								<div class="modal fade" id="report_five" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_five" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary five" > >> Primary Five << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_five.$invalid" class="btn btn-primary" name="report"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
					<div class="modal fade" id="report_six" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_six" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary six" > >> Primary Six << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_six.$invalid" class="btn btn-primary" name="report"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
					<div class="modal fade" id="report_seven" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_seven" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary seven" > >> Primary Seven << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_seven.$invalid" class="btn btn-primary" name="report"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
<div class="modal fade" id="report_one" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_one" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report_upper'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary one" > >> Primary One << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							
							<label for="password"style="text-align:left;"> Term:</label>
							
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_one.$invalid" class="btn btn-primary" name="report_upper"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
<div class="modal fade" id="report_two" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_two" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report_upper'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary two" > >> Primary Two << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_two.$invalid" class="btn btn-primary" name="report_upper"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
<div class="modal fade" id="report_three" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_three" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report_upper'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Primary three" > >> Primary Three << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_three.$invalid" class="btn btn-primary" name="report_upper"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
<div class="modal fade" id="report_top" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_top" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report_lower'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="Top" > >> Top Class << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_top.$invalid" class="btn btn-primary" name="report_lower"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 
<div class="modal fade" id="report_baby" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Specify Report Form</h4>
						</div>
					<div class="modal-body" >
							<form method="post" action=""  name="r_baby" ng-app="amt" ng-controller="value" onsubmit=" window.location='home.php?report_lower'">
							<center>
							<h4 class="hx" > Generate Report </h4></br>
							<select name="class" required="required"  >
								<option value="baby" > >> Baby Class << </option>
								
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_baby.$invalid" class="btn btn-primary" name="report_lower"  value="Process Reports"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 


<div class="modal fade" id="#profile" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sm"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Edit Profile </h4>
						</div>
					<div class="modal-body" >
							<form method="post" action="" name="stcomp" class="stcomp">
							<label for="compType">Complaint Type</label>
							<select name="compType" required="required">
								<option value=""> >> Select Complaint Category << </option>
								<option value="Missing Exam marks">Missing Exam marks</option>
								<option value="Missing Coursework marks">Missing Coursework marks</option>
								<option value="Remarking">Remarking</option>
							</select>
							<label for="description">Description</label>
							<textarea cols="3" rows="4" name="desp" placeholder="Enter the description of the complaint" required="required"></textarea>
							<label for="yos">Year of Study</label>
							<select name="year" required="required">
								<option value=""> >> Select Year of Study << </option>
								<option value="3">Year 3</option>
								<option value="2">Year 2</option>
								<option value="1">Year 1</option>
							</select>
							<label for="cunit">Course Unit</label>
							<select name="cunit" required="required">
							<option value=""> >> Select Course Unit << </option>
							<?php
							$query = $dbh->query("SELECT * FROM course_units");
							while($num = $query->fetch(PDO::FETCH_OBJ)){
							?>
							<option value="<?php echo $num->name;?>"><?php echo $num->name;?></option>
						    <?php
							}
							?>
							</select>
								
					</div>
	<div class="modal-footer"> 
				<input type="submit" class="btn btn-primary" name="complain" value="SAVE" required="required"/>
				<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
		</form>
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 

<!-- ===================  end of edit content -->


                       
				
						<div class="span3" >
                            <!--Left Menu-->
							<div style="border:5px ridge ghostwhite; border-radius:10px; 
							width:232px;margin-left:15px;margin-top:18px;">
                            <div id="left_menu">	
								<ul class="topnav">								
									<li><a href="#">User Profile </a>
									</a>							
									<ul>
										<li>
											<a href="?prof" title="#">My profile</a>
										</li>
										<li>
										<a href="?edit-profile"  >Edit Profile </a>
										</li>										
									</ul>
								</ul>
							</div>
								<div id="left_menu">
								<ul class="topnav">								
									<li><a href="#">Upload Students' Results </a>
									</a>							
									<ul>
									
									<li><a href="#marks_lower" title="lower classes" data-toggle="modal" >Nursery Section</a></li>
										<li><a href="#marks_upper" title="Primary classes" data-toggle="modal" >Primary Section</a></li>
										
										
									</ul>
								</ul>
								</div>
								<div id="left_menu">
								<ul class="topnav">								
									<li><a href="#">Reports</a>
									</a>							
									<ul>
									    <li><a href="#report_baby" title="Baby class" data-toggle="modal" >Baby class</a></li>
										<li><a href="#report_top" title="Top class" data-toggle="modal" >Top class</a></li>
										<li><a href="#report_one" title="Primary one" data-toggle="modal" >Primary one</a></li>
										<li><a href="#report_two" title="Primary two" data-toggle="modal" >Primary two</a></li>
										<li><a href="#report_three" title="Primary three" data-toggle="modal" >Primary three</a></li>
										<li><a href="#report_four" title="Primary four" data-toggle="modal" >Primary four</a></li>
										<li><a href="#report_five" title="Primary five" data-toggle="modal" >Primary five</a></li>
										<li><a href="#report_six" title="Primary six" data-toggle="modal" >Primary six</a></li>
										<li><a href="#report_seven" title="Primary seven" data-toggle="modal" >Primary seven</a></li>
									</ul>
								</ul>
							</div>
							</div>
                        </div>
						<div class="modal fade" id="marks_lower" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Marks Details</h4>
						</div>
						<div class="modal-body" >
							<form method="post" action="home.php?mark_lower"  name="r_lower" ng-app="amt" ng-controller="value" onsubmit="window.location='home.php?mark_lower'">
					
							<center>
							
							<select name="class" required="required"  >
							   <option value="" > >> Select class << </option>
								<option value="Baby" > >> Baby Class << </option>
								<option value="Top" > >> Top Class << </option>
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_lower.$invalid" class="btn btn-primary" name="r_lower"  value="submit"/>
			<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
	</form>
	</div>
	
</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div> 

		<div class="modal fade" id="marks_upper" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-sma"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">Marks Details</h4>
						</div>
						<div class="modal-body" >
							<form method="post" action="home.php?mark_upper"  name="r_upper" ng-app="amt" ng-controller="value" onsubmit="window.location='home.php?mark_upper'">
					
							<center>
							
							<select name="class" required="required"  >
							   <option value="" > >> Select class << </option>
								<option value="Primary one" > Primary one </option>
								<option value="Primary two" > Primary two</option>
								<option value="Primary three" > Primary three</option>
								<option value="Primary four" > Primary four</option>
								<option value="Primary five" > Primary five</option>
								<option value="Primary six" > Primary Six</option>
								<option value="Primary seven" > Primary Seven</option>
							</select>
							<label for="password"style="text-align:left;"> Period:</label>
							<select name="period" required="required"  >
								<option value="" > >> Select period << </option>
								<option value="MID" > Mid Term </option>
								<option value="EOT" > End Of Term</option>
							</select>
							<label for="password"style="text-align:left;"> Term:</label>
							<select name="term" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							</select>
							<label for="Result"style="text-align:left;">Year:</label>
							   <select name="year" required="required"  >
							  <option value="" > >> Select Year << </option>
								<option value="2000" > 2000 </option><option value="2001" > 2001</option><option value="2002" > 2002</option><option value="2003" > 2003</option>            
							    <option value="2004" > 2004 </option><option value="2005" > 2005</option><option value="2006" > 2006</option><option value="2007" > 2007</option>
								<option value="2008" > 2008 </option><option value="2009" > 2009</option><option value="2010" > 2010</option><option value="2011" > 2011</option>
								<option value="2012" > 2012 </option><option value="2013" > 2013</option><option value="2014" > 2014</option><option value="2015" > 2015</option>
								<option value="2016" > 2016 </option><option value="2017" > 2017</option><option value="2018" > 2018</option><option value="2019" > 2019</option>
								<option value="2020" > 2020 </option><option value="2021" > 2021</option><option value="2022" > 2022</option><option value="2003" > 2023</option>
								<option value="2024" > 2024 </option><option value="2025" > 2025</option><option value="2026" > 2026</option><option value="2003" > 2027</option>
								<option value="2028" > 2028 </option><option value="2029" > 2029</option><option value="2030" > 2030</option><option value="2003" > 2031</option>
								<option value="2032" > 2032 </option><option value="2033" > 2033</option><option value="2034" > 2034</option><option value="2003" > 2035</option>
								<option value="2036" > 2036 </option><option value="2037" > 2037</option><option value="2038" > 2038</option><option value="2003" > 2039</option>
								<option value="2040" > 2040 </option><option value="2041" > 2041</option><option value="2042" > 2042</option><option value="2003" > 2043</option>
								<option value="2044" > 2044 </option><option value="2045" > 2045</option><option value="2046" > 2046</option><option value="2003" > 2047</option>
								</select>              
							
							
						</center>
						
								
					</div>
	<div class="modal-footer"> 
			<input type="submit" ng-disabled="r_upper.$invalid" class="btn btn-primary" name="r_upper"  value="submit"/>
			<button class="btn btn-primary" data-dismiss="modal"> CANCEL</button> <!-- Closing button -->
	</form>
	</div>
	
</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

	  <div class="span9">
							<!-- Page content -->
						<center>	<div id="content">
							<?php 
							if(isset($_REQUEST['search'])){
							$key = $_POST['search'];
					if($key){
					
					$q = $dbh->query("SELECT * FROM student_lower WHERE ( name like '%$key%')  ORDER BY year desc LIMIT 20");
					
					$num = $dbh->query("SELECT count(*) FROM student_lower WHERE ( name like '%$key%' )  ORDER BY year desc LIMIT 20" )->fetchColumn();
					
					if($num > 0){
					
					?>
					
					<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Search results for: <i style="color:red;font-weight:normal"><?php echo $key;?></i>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
					<table width="740px" class="table table-striped table-bordered table-hover" id="example" height="auto" cellpadding="2px" cellspacing="2px" style="margin:2px 2px 2px 2px">
                         
                            <tr>
							  <th># </th>
							  <th>Student </th>
                              <th>class</th>
							   <th>Term</th>
                               <th>Year</th>						 
							  <th> action</th>
                            </tr>
							
                            <?php $count=0;
							while($at = $q->fetch(PDO::FETCH_OBJ)){
								$id=$at->student_lid;
								$count=$count+1;
                            ?>
                              <tr>
                                <td> <?php echo $count;?> </td>
                                <td> <?php echo $at->name;?>  </td>
                                 <td> <?php echo $at->class;?>  </td>
								 <td> <?php echo $at->term;?>  </td>
								 <td> <?php echo $at->year;?>  </td>
								 <td><a href="?sch=<?php echo $id?>" data-toggle="modal" class='btn btn-danger'><input type="button" value="Report" class="btn btn-danger"/></a></a></td>
                              </tr>
							 
							<?php 
							 	}
                            ?> 
                        </table>
						</div></div>
					<?php
					}else{
					echo "<script>
					alert('Sorry $fname, your search did not match any results. Try again later');
					window.location = 'home.php?search-term=$key';
					</script>";
					}
					
						
					}else{
					echo "<script>
					alert('Search item can not be empty. Try again later');
					window.location ='home.php';
					</script>";
							}
							}elseif(isset($_REQUEST['sch'])){
								
							$id =$_REQUEST['sch'];
							$counter=0;
							$top="Top"	;
                                  $baby="Baby";
							$p = $dbh->query("SELECT * FROM student_lower where  student_lid='".$id."' and class='$top'or class='$baby'");
		                     while($x = $p->fetch(PDO::FETCH_OBJ)){
								$class	= $x->class; 
                                 $counter=$counter+1;
								 
							 }
							 if($counter>0){
								 $count=0;
								 $test="EOT";
								$ap = $dbh->query("SELECT * FROM result where  student_lid='".$id."' and session='".$test."'");
		                     while($x = $ap->fetch(PDO::FETCH_OBJ)){
								$session= $x->session; 
							 $count=$count+1;}
							 
                             if($count>0) {
								 
						 $pu = $dbh->query("SELECT * FROM result_lower where student_lid='$id' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?>
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report_lower'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "EOT";?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report_lower" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#lower" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" class="btn btn-danger"/></a>
					</div>
						<?php
				         $ed = "EOT";
						 $count=0;
						 $d ="MID";
		                 $counter=0;
		 $pu = $dbh->query("SELECT * FROM result_lower where student_lid='$id' and session='$ed' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth = $xt->DOB;
				 $image = $xt->photo;
				 $balance = $xt->balance;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $health_end= $x->health_habits; 
                  $lang_end= $x->laguage_devt_1; 
				  $social_end= $x->social_devt;
                  $math_end= $x->math_concepts;
				  $writing_end= $x->writing;
                  $reading_end= $x->reading;
				  
			$sql = $dbh->query("select count(*) as allcount from lower_grade where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
			
				$p = $dbh->query("SELECT * FROM result_lower where session='$d'and student_lid='$id'and class='$clas'and year='$yea'and term='$period' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					 
				  $health_mid= $xa->health_habits; 
                  $lang_mid= $xa->laguage_devt_1; 
				  $social_mid= $xa->social_devt;
                  $math_mid= $xa->math_concepts;
				  $writing_mid= $xa->writing;
				 $reading_mid= $xa->reading;}
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_grade where student_lid='" . $x->student_lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$ad=$ag->lower_grade_id;
				  $health_avg= $ag->health_avg; 
                  $lang_avg= $ag->ld1_avg; 
				  $social_avg= $ag->social_avg;
                  $math_avg= $ag->math_avg;
				  $writing_avg= $ag->writing_avg;
                  $reading_avg= $ag->reading_avg;
					$total_end =$ag->total_end;
					$total_mid =$ag->total_mid;
					$total_avg =$ag->total_avg;
				 }$L = $dbh->query("select * from lower_position where lower_grade_id='" . $ad . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="lower" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
				
				
				 
			 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="5"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image;?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="5">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="6">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				 
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;">  </td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths Concepts </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				 
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>
				 
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $social_mid;?></td>
				<td style="border:1px solid black;"><?php echo $social_end;?></td>
				<td style="border:1px solid black;"><?php echo $social_avg;?></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $health_mid;?></td>
				<td style="border:1px solid black;"><?php echo $health_end;?></td>
				<td style="border:1px solid black;"><?php echo $health_avg;?></td>
			 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lang_mid;?></td>
				<td style="border:1px solid black;"><?php echo $lang_end;?> </td>
				<td style="border:1px solid black;"><?php echo $lang_avg;?></td>
				 
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $reading_mid;?></td>
				<td style="border:1px solid black;"><?php echo $reading_end;?></td>
				<td style="border:1px solid black;"><?php echo $reading_avg;?></td>
			 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">500</td>
				<td style="border:1px solid black;"> <?php echo total_mid;?> </td>
				<td style="border:1px solid black;"><?php echo total_end;?></td>
				<td style="border:1px solid black;"><?php echo $total_avg;?></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Balance:<br/> <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="4" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="4" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					 
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				 
			 } 
								 
								
								 
							 }else{
						 $pu = $dbh->query("SELECT * FROM result_lower where student_lid ='$id' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?>
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report_lower'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "MID";?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						
						<a href="" class="btn btn-warning"><input type="submit" name="report_lower" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#mid_lower" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" class="btn btn-danger"/></a>
					</div>
						<?php
				         $ed = "EOT";
						 $count=0;
						 $d ="MID";
		                 $counter=0;
		 $pu = $dbh->query("SELECT * FROM result_lower where student_lid ='$id' and session='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth = $xt->DOB;
				 $image = $xt->photo;
				 $balance = $xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  
				  $health_mid= $x->health_habits; 
                  $lang_mid= $x->laguage_devt_1; 
				  $social_mid= $x->social_devt;
                  $math_mid= $x->math_concepts;
				 
				 $reading_mid= $x->reading;
				 
			$sql = $dbh->query("select count(*) as allcount from mid_lower where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; }
				  
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from mid_lower where lower_id='$f' ORDER BY total desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id = $ag->mid_lid;
					$total_mid =$ag->total;
					
				 }$L = $dbh->query("select * from mid_lower_position where mid_lid='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="mid_lower" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="3"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image ;?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="3">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="4">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths Concepts</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				
				
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $social_mid;?></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $health_mid;?></td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lang_mid;?></td>
				<td style="border:1px solid black;"> </td>
				 
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $reading_mid;?></td>
				
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				 
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">500</td>
				<td style="border:1px solid black;"> <?php echo $total_mid;?> </td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="2" > Division: </td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="2">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/><?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="2"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="2">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="2">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					 
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				 
			 } 
								
							 }	
							 
							 }else{
								 $count=0;
								$ap = $dbh->query("SELECT * FROM result where  student_lid='".$id."' and session ='EOT'");
		                     while($x = $ap->fetch(PDO::FETCH_OBJ)){
								$session= $x->session; 	
							$count=$count+1;
							 }
                             if($count>0) {
								 	$pu = $dbh->query("SELECT * FROM result where student_lid='$id' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?> 
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#rep" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" name="num" class="btn btn-danger"/></a>
					</div>
					<?php
					reportingr();
							 }else{
							
						 $p = $dbh->query("SELECT * FROM result where student_lid='$id' ");
		 	
				 while($x = $p->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?> 
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;">
							<form method="post" onsubmit=" window.location='home.php?report'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "MID";?>" />
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#mid_report" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" name="num" class="btn btn-danger"/></a>
					</div>
					<?php
					reporting_mid();
							 }}							
					}elseif(isset($_REQUEST['edit-profile'])){
					if($ui=="student"){
					$qr = $dbh->query("SELECT * FROM students WHERE email='$email'");
					while($apx = $qr->fetch(PDO::FETCH_OBJ)){
					$first = $apx->firstName;
					$last = $apx->lastName;
					$email = $apx->email;
					$pwd = md5($apx->password);
					
					?>
					
					<form method="post" action="" class="complaint-form" name="edt" ng-app="edit" ng-controller="ctrl" >
					<h4 class="hx" > EDIT PROFILE</h4><br/>
							<label for="first">FirstName</label>
							 <input type="text" name="first" style="width:280px" value="<?php echo $first;?>"  placeholder="Enter first name" readonly />
							<label for="last">LastName</label>
							<input type="text"  name="last" style="width:280px" value="<?php echo $last;?>" placeholder="Enter last name" readonly ></input>
							<label for="email">UserName </label>
							<input type="email"  name="email" style="width:280px"value="<?php echo $email;?>" placeholder="Enter email address"  ></input>
							<label for="password">Old Password </label>
							<input type="password"  name="old" style="width:280px"  ng-model="old" ng-minlength="7" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/" placeholder="Enter old password" required  ></input>
							<span  class="ngshow" ng-show="edt.old.$error.pattern || edt.old.$error.minlength" > Password must be 7 characters and alphanumeric </span>
							<label for="password">New Password </label>
							<input type="password"  name="new" style="width:280px" ng-model="new" ng-minlength="7" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/"  value="" placeholder="Enter New password" required  ></input>
							<span  class="ngshow" ng-show="edt.new.$error.pattern || edt.new.$error.minlength" > Password must be 7 characters and alphanumeric </span>
							<label for="submit"></label>
							<input type="submit" ng-disabled="edt.$invalid" class="btn btn-primary" name="change_profile"  value="UPDATE"/>
					    </form>
					<script>
					var ty = angular.module("edit",[]);
					ty.controller("ctrl",function($scope){}
					);
					</script>
					<?php
					}
					
					}else{
					$qr = $dbh->query("SELECT * FROM administrators WHERE email='$email'");
					while($apx = $qr->fetch(PDO::FETCH_OBJ)){
					$first = $apx->firstName;
					$last = $apx->lastName;
					$email = $apx->email;
					$pwd = $apx->password;
					
					?>
					
					<form method="post" action="" class="complaint-form" name="apr" ng-app="my" ng-controller="valid">
					<h4 class="hx" > EDIT PROFILE</h4></br>
							<label for="first">FirstName</label>
							 <input type="text" name="first" style="width:280px" value="<?php echo $first;?>"  placeholder="Enter first name" readonly />
							<label for="last">LastName</label>
							<input type="text"  name="last" style="width:280px" value="<?php echo $last;?>" placeholder="Enter last name" readonly></input>
							<label for="email">UserName </label>
							<input type="email"  name="email" style="width:280px" value="<?php echo $email;?>" placeholder="Enter email address"  ></input>
							<label for="password">Old Password </label>
							<input type="password"  name="old" style="width:280px" ng-model="old" ng-minlength="7" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/" placeholder="Enter old password" required  ></input>
							<span  class="ngshow" ng-show="apr.old.$error.pattern || apr.old.$error.minlength" > Password must be 7 characters and alphanumeric </span>
							<label for="password">New Password </label>
							<input type="password"  name="new" style="width:280px" ng-model="new" ng-minlength="7" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/"  value="" placeholder="Enter New password" required  ></input>
								<span  class="ngshow" ng-show="apr.nw.$error.pattern || apr.new.$error.minlength" > Password must be 7 characters and alphanumeric </span>
							<label for="submit"></label>
							<input type="submit" ng-disabled="apr.$invalid" class="btn btn-primary" name="change_profile"  value="UPDATE"/>
					
					    </form>
						<script>
					var apr = angular.module("my",[]);
					apr.controller("valid",function($scope){}
					);
					</script>
					<?php
					}}}elseif(isset($_REQUEST['new_teacher'])){
					?>
					<form method="post" action="" class="complaint-form" name="tec" ng-app="lect" ng-controller="vr" enctype="multipart/form-data">
					<h4 class="hx" > USER REGISTRATION FORM</h4></br>
							
							  <input type="text" name="first" class="input" ng-model="first" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/" placeholder="Enter first name" ><br/>
								<span  class="ngshow" ng-show="tec.first.$error.pattern" > First name must start with capital letter  </span><br/>
							
								<input type="text"  name="last"  ng-model="last" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/" class="input" style="height:auto"  placeholder="Enter last name" ></input><br/>
							<span  class="ngshow" ng-show="tec.last.$error.pattern" > Last name must start with capital letter  </span><br/>
							
							<input type="email"  name="email" ng-model="email" class="input" style="height:auto" placeholder="Enter email address" required  ></input><br/>
								<span  class="ngshow" ng-show="tec.email.$error.email" > Invalid email. Email must contain @ character  </span><br/>
							
								<input type="password" name="pass" ng-model="pass" class="input" ng-model="pass" ng-minlength="7" ng-pattern="/^[A-Z][a-z0-9-_\.]{1,20}$/"id="password" placeholder ="Password eg Admin12" required /><br/>
						   <span style="color:red" ng-show="tec.pass.$error.minlength">Password must be 7 characters and alphanumeric
						   </span></br>
						  
							<select name="title" required="required"  >
								<option value="" selected> >> Select Tittle << </option>
								<option value="bursar" >BURSAR</option>
								<option value="teacher" >TEACHER</option>
								<option value="admin" >ADMINISTRATOR</option>
								
							</select><br/></br/>
							
							<input type="file" name="photo"class="input" required/><br/><br/>
							
							<select name="class"  required="required"  >
								<option value="" > >> Select Class  << </option>
								<option value="Baby class" >Baby class </option>
								<option value="Top class" > Top Class</option>
								<option value="Primary one" > Primary one </option>
								<option value="Primary two" > Primary two</option>
								<option value="Primary three" > Primary three</option>
								<option value="Primary four" > Primary four</option>
								<option value="Primary five" > Primary five</option>
								<option value="Primary six" > Primary Six</option>
								<option value="Primary seven" > Primary Seven</option>
							</select>
							<label for="submit"></label>
							<input type="submit" ng-disabled="tec.$invalid" class="btn btn-primary" name="add_teacher"  value="SAVE"/>
					</form>
					<script>
					var br= angular.module("lect",[]);
					br.controller("vr",function($scope){}
					);
					</script>
					
					<?php
					}elseif(isset($_REQUEST['manage_teacher'])){
					$var = $dbh->query("SELECT * FROM administrators WHERE interface='teacher'or interface='bursar' order by userID desc");
					$num = $dbh->query("SELECT count(*) FROM administrators WHERE interface='teacher' or interface='bursar'  order by userID desc")->fetchColumn();
							if($num >0){
								?>
								<center><h4 class="mh4"> All Users </h4></center><br/>
								<table width="auto" border="1px black" height="auto" cellpadding="2px" cellspacing="2px" style="margin:2px 2px 2px 2px">
                            <tr>
								<th>FirstName</th>
								<th>LastName</th>
								<th>Email</th>
								
								<th>Title</th>
							
									<th colspan="1">Action</th>
							</tr>
							 <?php
							 while($ap = $var->fetch(PDO::FETCH_OBJ)){
							 ?>
							 <tr>
							 <td><?php echo $ap->firstName;?></td>
							  <td><?php echo $ap->lastName;?></td>
							  <td><?php echo $ap->email;?></td>
							  
							  <td><?php echo $ap->interface;?></td>
								  <td><a href="?lectid=<?php echo $ap->userID;?>"  ><img src="assets/img/del.png"></img></a>
								   </td>
							</tr>
							 <?php
							 }
							 ?>
						</table>
							<?php	
							}
							
							else{
							?>
							<strong style="color:red;font-family:Tahoma,sans-serif;font-size:16px"> NO users' details found</strong>
							<?php
							}
					
					}elseif(isset($_REQUEST['new_subject'])){
					?>
					
							<form method="post" action="" class="complaint-form" name="cunits" ng-app="amt" ng-controller="value">
							<h4 class="hx" > SUBJECT ADDITION FORM</h4></br>
							<label for="code">SubjectCode</label>
							  <input type="text" name="first" class="input"  placeholder="Enter subjectCode" ><br/>
								<br/>
							
							<label for="code"style="text-align:left;">Subject Name:</label>
							  <select name="dept" required="required"  >
								<option value="" > >> Select subject  << </option>
								<option value="science" >Science </option>
								<option value="sst" > Social studies</option>
								<option value="math" > Mathematics </option>
								<option value="eng" > English</option>
								
							</select>
							<label for="cname"style="text-align:left;">Select Class it Applies:</label>
												<div style="text-align:left;"><input type="checkbox"  name="cname"    />      Baby class    <br/>
													<input type="checkbox"  name="cname"    />		Top class     <br/>
													<input type="checkbox"  name="cname"    />      Primary one   <br/>
													<input type="checkbox"  name="cname"    />      Primary two   <br/>
													<input type="checkbox"  name="cname"     >      Primary three <br/> 
													<input type="checkbox"  name="cname"    />      Primary four  <br/>
													<input type="checkbox"  name="cname"    />      Primary five  <br/>
													<input type="checkbox"  name="cname"    />      Primary six   <br/>
													<input type="checkbox"  name="cname"    />      Primary seven <br/></div>
							
							<label for="submit"></label>
							<input type="submit" ng-disabled="cunits.$invalid" class="btn btn-primary" name="add1_cunit"  value="SAVE"/>
						</form>
					<script>
						var x = angular.module("amt",[]);
						x.controller("value",function($scope){});
					</script>
					<?php
					}elseif(isset($_REQUEST['manage_subject'])){
					$var = $dbh->query("SELECT * FROM course_units order by creditUnit");
					$num = $dbh->query("SELECT count(*) FROM course_units order by creditUnit")->fetchColumn();
							if($num >0){
								?>
								<h4 class="mh4">ALL subjects</h4>
								<table width="auto" border="1px black" height="auto" cellpadding="2px" cellspacing="2px" style="margin:2px 2px 2px 2px">
                            <tr>
								<th>subjectCode</th>
								<th>subject Name</th>
								
								
									<th colspan="1">Action</th>
							</tr>
							 <?php
							 while($ap = $var->fetch(PDO::FETCH_OBJ)){
							 ?>
							 <tr>
							 <td><?php echo $ap->courseCode;?></td>
							  <td><?php echo $ap->name;?></td>
							  <td><a href="?courseid=<?php echo $ap->courseCode;?>"  ><img src="assets/img/del.png"></img></a>
								  </td>
							</tr>
							 <?php
							 }
							 ?>
						</table>
							<?php	
							}
							
							else{
							echo "<script>
							alert('No subject details found');
							window.location ='home.php?cunits';
							</script>";
							}
					}
					elseif(isset($_GET['lectid'])){
					$id = $_GET['lectid'];
					$res = $dbh->query("DELETE FROM administrators WHERE userID='$id'");
					if($res){
					echo "<script>
					alert('teacher deleted successfully');
					window.location ='home.php?manage_lecturers';
					</script>";
					}
					}
					elseif(isset($_GET['courseid'])){
					$id = $_GET['courseid'];
					$res = $dbh->query("DELETE FROM course_units WHERE courseCode='$id'");
					if($res){
					echo "<script>
					alert('teacher deleted successfully');
					window.location ='home.php?manage_cunits';
					</script>";
					}
					}elseif(isset($_REQUEST['mark_lower'])){
						if(isset($_POST['r_lower'])){
					  $yea = $_POST['year'];
					  $period = $_POST['term'];
					  $session = $_POST['period'];
					  $clas = $_POST['class'];
						?>
						
                    <div class="panel panel-default" style=" width:51.2em">
                        <div class="panel-heading">
                            Results Upload For <?php echo $clas?> Class </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" > 
						<tr><th>Name </th>
						
						<th>Math concepts </th>
						<th>Health Habits</th>
						<th>Social Devt</th>
						<th>Language Devt</th>
						<th> Writing and Reading</th>
						
						<th> Action</th></tr>
						<?php 
						$counter=0;
					
						$qr = $dbh->query("SELECT * FROM student_lower  where  year='$yea' and term='$period' and class='$clas' ");
					
					while($apx = $qr->fetch(PDO::FETCH_OBJ)){
					$first = $apx->name;
					$id = $apx->student_lid;
					$count=0;
					$counter=$counter+1;
					$q = $dbh->query("SELECT * FROM result_lower  where student_lid = '".$apx->student_lid."' and year='$yea' and term='$period' and class='$clas' and session='$session' ");
					while($ap = $q->fetch(PDO::FETCH_OBJ)){
						$d = $ap->student_lid;
						$count=$count+1;
						
					}
					if($count!=0){
						
					}else{
					?>
						<tr><td><?php echo $first?></td>
						
                             <form method="post" action=""  name="lower" ng-app="amt" ng-controller="value" enctype="multipart/form-data">
                              <input type="hidden" name="student" value="<?php echo $id ?>" class="input" style=" width:50px" required />
							   <input type="hidden" name="year" value="<?php echo $yea ?>" class="input" style=" width:50px" required />
							    <input type="hidden" name="class" value="<?php echo $clas ?>" class="input" style=" width:50px" required />
								 <input type="hidden" name="term" value="<?php echo $period ?>" class="input" style=" width:50px" required />
								  <input type="hidden" name="session" value="<?php echo $session ?>" class="input" style=" width:50px" required />
							<td>  <input type="number" name="math" class="input" style=" width:50px" required /> </td>
                            <td> <input type="number" name="HH" class="input" style=" width:50px"  required  /> </td>
                            <td><input type="number" name="social" class="input" style=" width:50px" required   />  </td>  
                            <td><input type="number" name="lang" class="input"  style=" width:50px" required  />  </td>
                            <td> <input type="number" name="reading" class="input" style=" width:50px" required   /> </td>
                            
                            <td> <input type="submit" ng-disabled="lower.$invalid" class="btn btn-primary" name="lower"  value="SAVE"/> </td> </form> </tr>
					<?php }}?>
						</table>
					      </div>
						  </div>
						  
					<?php
					if($counter==0 ){
						echo "<script>
					alert('no new $clas class Pupil available for marks entry');
					window.location ='home.php';
					</script>";
					}
					}
					if(isset($_POST['lower'])){
	upload_lower();
	$yea = $_POST['year'];
	  $period = $_POST['term'];
	  $session = $_POST['session'];
	  $clas = $_POST['class'];
	  $counter=0;
	  if($session=="MID"){
		     
			$sql = $dbh->query("select * from mid_lower where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'ORDER BY total desc");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $counter+1;
		 $id =$xs->mid_lid;
		 $count=0;
		 $sq = $dbh->query("select * from mid_lower_position where mid_lid='$id' ");
        while($xs = $sq->fetch(PDO::FETCH_OBJ)){
			$count= $count+1;
		}
		if($count>0){
			$r  = $dbh->query("UPDATE mid_lower_position set position='$counter' where mid_lid='$id'");
		}else{
		$rs  = $dbh->query("INSERT INTO mid_lower_position VALUES('','$id','$counter')");
		}
		 
	   }	 
		
        	   
		echo "<form method='post' action=''  name='r_lower' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              <input type='hidden' name='student' value='".$id."' class='input'style='width:50px'required />
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  <input type='hidden' name='period' value='".$session."' class='input' style=' width:50px' required />
								 <input type='submit'  class='btn btn-primary' name='r_lower' title='click to continue' value='Next'/></form>";
	  }else{
		 $sql = $dbh->query("select * from lower_grade where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'ORDER BY total_avg desc");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $counter+1;
		 $id =$xs->lower_grade_id;
		 $count=0;
		 $sq = $dbh->query("select * from lower_position where lower_grade_id='$id' ");
        while($xs = $sq->fetch(PDO::FETCH_OBJ)){
			$count= $count+1;
		}
		if($count>0){
			$r  = $dbh->query("UPDATE lower_position set position='$counter' where lower_grade_id='$id'");
		}else{
		 $rs  = $dbh->query("INSERT INTO lower_position VALUES('','$id','$counter')");
		}}
      echo "<form method='post' action=''  name='r_lower' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              <input type='hidden' name='student' value='".$id."' class='input'style='width:50px'required />
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  <input type='hidden' name='period' value='".$session."' class='input' style=' width:50px' required />
								 <input type='submit'  class='btn btn-primary' name='r_lower'  value='Next'/></form>";	   
	  }
}
					}elseif(isset($_REQUEST['mark_upper'])){
						if(isset($_POST['r_upper'])){
					  $yea = $_POST['year'];
					  $period = $_POST['term'];
					  $session = $_POST['period'];
					  $clas = $_POST['class'];
					?>
					        <div class="panel panel-default" style=" width:51.2em">
                        <div class="panel-heading">
                            Results Upload  For <?php echo $clas ?></div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
						<?php if($clas=="Primary one"||$clas=="Primary two"||$clas=="Primary three"){
							?>
							<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%"> 
						<tr><th>Name </th>
						
						<th>Luganda </th>
						<th>Numbers</th>
						<th>RE</th>
						<th>English</th>
						<th>Literacy a</th>
						<th>Literacy b</th>
						<th> Action</th></tr>
						<?php 
						
						$counter=0;
						$qr = $dbh->query("SELECT * FROM student_lower  where year='$yea' and term='$period' and class='$clas'");
					while($apx = $qr->fetch(PDO::FETCH_OBJ)){
					$first = $apx->name;
					$id = $apx->student_lid;
					$count=0;
					$counter = $counter +1;
					$q = $dbh->query("SELECT * FROM lower_upper where student_lid = '".$apx->student_lid."' and year='$yea' and term='$period' and class='$clas' and session='$session' ");
					while($ap = $q->fetch(PDO::FETCH_OBJ)){
						$d = $ap->student_lid;
						$count=$count+1;
						
					}
					if($count!=0){
					}else{
					?>
						<tr><td><?php echo $first?></td>
						
                             <form method="post" action=""  name="upper" ng-app="amt" ng-controller="value" enctype="multipart/form-data">
                              <input type="hidden" name="student" value="<?php echo $id ?>" class="input" style=" width:50px" required />
							   <input type="hidden" name="year" value="<?php echo $yea ?>" class="input" style=" width:50px" required />
							    <input type="hidden" name="class" value="<?php echo $clas ?>" class="input" style=" width:50px" required />
								 <input type="hidden" name="term" value="<?php echo $period ?>" class="input" style=" width:50px" required />
								  <input type="hidden" name="session" value="<?php echo $session ?>" class="input" style=" width:50px" required />
							<td>  <input type="number" name="lug" class="input" style=" width:50px" required /> </td>
                            <td> <input type="number" name="num" class="input" style=" width:50px"  required  /> </td>
                            <td><input type="number" name="re" class="input" style=" width:50px" required   />  </td>  
                            <td><input type="number" name="eng" class="input"  style=" width:50px" required  />  </td>
							 <td><input type="number" name="lita" class="input" style=" width:50px" required   />  </td>  
                            <td><input type="number" name="litb" class="input"  style=" width:50px" required  />  </td>
                           
                            <td> <input type="submit" ng-disabled="upper.$invalid" class="btn btn-primary" name="upper"  value="SAVE"/> </td> </form> </tr>
					<?php }}?>
						</table>
					      </div>
						  </div>
					<?php
					if($counter==0 ){
						echo "<script>
					alert('no new $clas class Pupil available for marks entry');
					window.location ='home.php';
					</script>";
					}
						}else{?>
						<table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%"> 
						<tr><th>Name </th>
						
						<th>Mathematics </th>
						<th>Science</th>
						<th>Social Studies</th>
						<th>English</th>
						<th> Action</th></tr>
						<?php 
						$counter = 0;
						
						$qr = $dbh->query("SELECT * FROM student_lower  where year='$yea' and term='$period' and class='$clas'");
					while($apx = $qr->fetch(PDO::FETCH_OBJ)){
					$first = $apx->name;
					$id = $apx->student_lid;
					$count=0;
					$counter + $counter +1;
					$q = $dbh->query("SELECT * FROM result where student_lid = '".$apx->student_lid."' and year='$yea' and term='$period' and class='$clas' and session='$session' ");
					while($ap = $q->fetch(PDO::FETCH_OBJ)){
						$d = $ap->student_lid;
						$count=$count+1;
						
					}
					if($count!=0){
					}else{
					?>
						<tr><td><?php echo $first?></td>
						
                             <form method="post" action=""  name="upper" ng-app="amt" ng-controller="value" enctype="multipart/form-data">
                              <input type="hidden" name="student" value="<?php echo $id ?>" class="input" style=" width:50px" required />
							   <input type="hidden" name="year" value="<?php echo $yea ?>" class="input" style=" width:50px" required />
							    <input type="hidden" name="class" value="<?php echo $clas ?>" class="input" style=" width:50px" required />
								 <input type="hidden" name="term" value="<?php echo $period ?>" class="input" style=" width:50px" required />
								  <input type="hidden" name="session" value="<?php echo $session ?>" class="input" style=" width:50px" required />
							<td>  <input type="number" name="math" class="input" style=" width:50px" required /> </td>
                            <td> <input type="number" name="english" class="input" style=" width:50px"  required  /> </td>
                            <td><input type="number" name="sst" class="input" style=" width:50px" required   />  </td>  
                            <td><input type="number" name="science" class="input"  style=" width:50px" required  />  </td>
                           
                            <td> <input type="submit" ng-disabled="upper.$invalid" class="btn btn-primary" name="upper"  value="SAVE"/> </td> </form> </tr>
					<?php }}?>
						</table>
					      </div>
						  </div>
					<?php
					if($counter==0 ){
						echo "<script>
					alert('no new $clas class Pupil available for marks entry');
					window.location ='home.php';
					</script>";
					}
					}}
					if(isset($_POST['upper'])){
	upload();
	$yea = $_POST['year'];
	  $period = $_POST['term'];
	  $session = $_POST['session'];
	  $clas = $_POST['class'];
	  if($clas=="Primary one"||$clas=="Primary two"||$clas=="Primary three"){
		  $counter=0;
	  if($session=="MID"){
		  $sql = $dbh->query("select * from lower_upper_mid where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'ORDER BY total_mid desc");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $counter+1;
		 $id =$xs->lower_upper_mid_id;
		 $sq = $dbh->query("select * from lower_upper_mid_position where upper_mid_position_id='$id'");
		 $count=0;
         while($x= $sq->fetch(PDO::FETCH_OBJ)){
			 $count=$count +1;
		 }
		 if($count>0){
			 $r  = $dbh->query("UPDATE lower_upper_mid_position set position='$counter' where upper_mid_position_id='$id'");
		 }else{
		 $rs  = $dbh->query("INSERT INTO lower_upper_mid_position VALUES('','$id','$counter')");
		} }
	   echo "<form method='post' action=''  name='r_upper' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  <input type='hidden' name='period' value='".$session."' class='input' style=' width:50px' required />
								 <input type='submit'  class='btn btn-primary' name='r_upper'title='click to continue'  value='Next '/></form>";
	  }else{
		   $sql = $dbh->query("select * from lower_upper_final where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'ORDER BY total_avg desc");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $counter+1;
		 $id =$xs->lower_upper_final_id;
		  $sq = $dbh->query("select * from lower_upper_final_position where lower_upper_final_id='$id'");
		 $count=0;
         while($x= $sq->fetch(PDO::FETCH_OBJ)){
			 $count=$count +1;
		 }
		 if($count>0){
			 $r  = $dbh->query("UPDATE lower_upper_final_position set position='$counter' where lower_upper_final_id ='$id'");
		 }else{
		 $rs  = $dbh->query("INSERT INTO lower_upper_final_position VALUES('','$id','$counter')");
		}
		
	   }
        echo "<form method='post' action=''  name='r_upper' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              <input type='hidden' name='student' value='".$id."' class='input'style='width:50px'required />
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  <input type='hidden' name='period' value='".$session."' class='input' style=' width:50px' required />
								 <input type='submit'  class='btn btn-primary' name='r_upper' title='click to continue' value='Next'/></form>";
			
		   
	  } 
	  }else{
		  
	 
	  $counter=0;
	  if($session=="MID"){
		  $sql = $dbh->query("select * from mid_upper where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'ORDER BY total desc");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $counter+1;
		 $id =$xs->mid_id;
		 $sq = $dbh->query("select * from mid_upper_position where mid_id='$id'");
		 $count=0;
         while($x= $sq->fetch(PDO::FETCH_OBJ)){
			 $count=$count +1;
		 }
		 if($count>0){
			 $r  = $dbh->query("UPDATE mid_upper_position set position='$counter' where mid_id='$id'");
		 }else{
		 $rs  = $dbh->query("INSERT INTO mid_upper_position VALUES('','$id','$counter')");
		} }
	   echo "<form method='post' action=''  name='r_upper' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  <input type='hidden' name='period' value='".$session."' class='input' style=' width:50px' required />
								 <input type='submit'  class='btn btn-primary' name='r_upper'title='click to continue'  value='Next '/></form>";
	  }else{
		   $sql = $dbh->query("select * from graded_result where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'ORDER BY total_avg desc");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $counter+1;
		 $id =$xs->grade_id;
		  $sq = $dbh->query("select * from upper_position where grade_id='$id'");
		 $count=0;
         while($x= $sq->fetch(PDO::FETCH_OBJ)){
			 $count=$count +1;
		 }
		 if($count>0){
			 $r  = $dbh->query("UPDATE upper_position set position='$counter' where grade_id ='$id'");
		 }else{
		 $rs  = $dbh->query("INSERT INTO upper_position VALUES('','$id','$counter')");
		}
		
	   }
        echo "<form method='post' action=''  name='r_upper' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              <input type='hidden' name='student' value='".$id."' class='input'style='width:50px'required />
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  <input type='hidden' name='period' value='".$session."' class='input' style=' width:50px' required />
								 <input type='submit'  class='btn btn-primary' name='r_upper' title='click to continue' value='Next'/></form>";
			
		   
	  }
					}
}
					
					}elseif(isset($_REQUEST['report_lower'])){
						        if(isset($_POST['report_lower'])){
						 $ed = "EOT";
						$count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
						 $period=$_POST['period'];
					  	 $Class = $_POST['class'];
						 $counter=0;
						 
						 if($period=="MID"){
				    ?>
					
					<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Reports<a href="#mid_lower" data-toggle="modal"Style="margin-left:240px;" class="btn btn-primary"><input type="button"value="Print all"class="btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Term</th>
				<th>Year</th>
				<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php 
					
		 $pu = $dbh->query("SELECT * FROM result_lower where session='$id'and class='$Class'and year='$Year'and term='$Term' ");
		 	while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				
				 $count=$count+1;
				?>
				
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<td> <a href="<?php echo '?mid_lower='.$f;?>" data-toggle="modal" class="btn btn-danger"><input type="button"value="Report" class="btn btn-danger"></a></td>
				</tr>
				<?php 						 }?>
				
				
					</tbody>
				</table>
				</div>
				</div>
				</div>	 <?php }else{
						 ?>
						 <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Reports<a href="#lower" data-toggle="modal"Style="margin-left:240px;" class="btn btn-primary"><input type="button"value="Print all"class="btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Term</th>
				<th>Year</th>
				<th>Action</th>
				</tr>
				</thead>
				<tbody>
						 
						 <?php
						 $pu = $dbh->query("SELECT * FROM result_lower where session='$ed'and class='$Class'and year='$Year'and term='$Term' ");
		 	while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 
				 $count=$count+1;
				?>
				
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<td> <a href="<?php echo '?lower='.$f;?>" data-toggle="modal" class="btn btn-danger"><input type="button"value="Report" class="btn btn-danger"></a></td>
				 </tr>
				 <?php 
						 }?>
				
			
				</tbody>
				</table>
				</div>
				</div>
				</div>
						 <?php
						 }?>
				
						<div class="modal fade" tabindex="-1" role="dialog"  id="lower" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						<a href="#" class="btn btn-primary"
				onclick="PrintElem('#print')" title="Print Report" ><button type="button"class="btn btn-primary" >Save To <img src="assets/img/pdf.png" width="30px" height="30px"/></button></a>  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print"><?php
						$ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					  	 $Class = $_POST['class'];
						$pu = $dbh->query("SELECT * FROM result_lower where session='$ed' and class='" . $Class . "' and term='" . $Term . "' and year='" . $Year . "'");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $image= $xt->photo;
				 $birth = $xt->DOB;
				 $balance = $xt->balance;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $health_end= $x->health_habits; 
                  $lang_end= $x->laguage_devt_1; 
				  $social_end= $x->social_devt;
                  $math_end= $x->math_concepts;
				   
                  $reading_end= $x->reading;
				  
			$sql = $dbh->query("select count(*) as allcount from lower_grade where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
			
				$p = $dbh->query("SELECT * FROM result_lower where session='$id'and class='$clas'and year='$yea'and term='$period' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					 
					 $health_mid= $xa->health_habits; 
                  $lang_mid= $xa->laguage_devt_1; 
				  $social_mid= $xa->social_devt;
				 $math_mid= $xa->math_concepts;
				 
				 $reading_mid= $xa->reading;}
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_grade where student_lid='" . $x->student_lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id=$ag->lower_grade_id;
					$health_avg=$ag->health_avg;
					$math_avg=$ag->math_avg;
					$social_avg=$ag->social_avg;
					$lang_avg=$ag->ld1_avg;
					
					$reading_avg=$ag->reading_avg;
					
					$total_avg =$ag->total_avg;
					$total_end =$ag->total_end;
					$total_mid =$ag->total_mid;
				}
				$L = $dbh->query("select * from lower_position where lower_grade_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
				?>
						<div style="margin-bottom:30px">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
				
				
				 
			 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="5"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image;?> " alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="5">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="6">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths Concepts </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"><?php echo $social_mid ;?> </td>
				<td style="border:1px solid black;"><?php echo $social_end ;?></td>
				<td style="border:1px solid black;"><?php echo $social_avg ;?></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $health_mid ;?></td>
				<td style="border:1px solid black;"><?php echo $health_end ;?></td>
				<td style="border:1px solid black;"><?php echo $health_avg ;?></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lang_mid ;?></td>
				<td style="border:1px solid black;"> <?php echo $lang_end ;?></td>
				<td style="border:1px solid black;"><?php echo $lang_avg ;?></td>
				 
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $reading_mid;?></td>
				<td style="border:1px solid black;"><?php echo $reading_end ;?></td>
				<td style="border:1px solid black;"><?php echo $reading_avg ;?></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">500</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$health_mid+$social_mid+$lang_mid+$reading_mid);?> </td>
				<td style="border:1px solid black;"><?php echo ($math_end+$health_end+$social_end+$lang_end+$reading_end);?></td>
				<td style="border:1px solid black;"><?php echo $total_avg;?></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Division: </td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Balance:<br/>   <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="4" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="4" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					 
					</div>
				 </div></div><?php }?></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div><div class="modal fade" tabindex="-1" role="dialog"  id="mid_lower" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						<a href="#" class="btn btn-primary"
				onclick="PrintElem('#print1')" title="Print Report" ><button type="button"class="btn btn-primary" >Save To <img src="assets/img/pdf.png" width="30px" height="30px"/></button></a>  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print1">
						<?php
						$ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					  	 $Class = $_POST['class'];
						$pu = $dbh->query("SELECT * FROM result_lower where session='$id' and class='" . $Class . "' and term='" . $Term . "' and year='" . $Year . "'");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth= $xt->DOB;
				 $image= $xt->photo;
				 $balance= $xt->balance;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $health_mid= $x->health_habits; 
                  $lang_mid= $x->laguage_devt_1; 
				  $social_mid= $x->social_devt;
				 $math_mid= $x->math_concepts;
				
				 $reading_mid= $x->reading;
				  
			$sql = $dbh->query("select count(*) as allcount from mid_lower where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
			
				
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from mid_lower where lower_id='$f' ORDER BY total desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$d = $ag->mid_lid;
					$total_mid =$ag->total;
				}
				$L = $dbh->query("select * from mid_lower_position where mid_lid='" . $d . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
				?>
						<div style="margin-bottom:30px">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="3"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="3">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="4">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths Concepts</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				
				 
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				 
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $social_mid;?></td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $health_mid;?></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lang_mid;?></td>
				<td style="border:1px solid black;"> </td>
				 
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $reading_mid;?></td>
				
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">500</td>
				<td style="border:1px solid black;"> <?php echo $total_mid;?> </td>
				
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="2" > Division:  </td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position;?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="2">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/> <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="2"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="2">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="2">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					
					
					
					</div>
				 </div></div> <?php }?> </div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print1')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>
					<?php
					} if($count!=0){
					
					}else{
				 echo "<script>
					alert('No $Class pupil in term $Term of  $Year  available ');
					window.location ='home.php';
					</script>";
			 }
						   
					
					}elseif(isset($_REQUEST['report_upper'])){
						 if(isset($_POST['report_upper'])){
						 $ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					     $period=$_POST['period'];
						 $Class = $_POST['class'];
						 $counter=0;
                     if($period=="MID"){
				     	?>
						<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Reports <a href="#mid_upper" data-toggle="modal"Style="margin-left:240px;" class="btn btn-primary"><input type="button"value="Print all"class="btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Term</th>
				<th>Year</th>
				<th>Action</th>
				</tr>
				</thead><tbody>
				<?php
					
		 $pu = $dbh->query("SELECT * FROM lower_upper where session='$id'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				
				 $count=$count+1;
			?> 
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<td><a href="<?php echo '?mid_upper='.$f;?>" data-toggle="modal" class="btn btn-danger"><input type="button"value="Marks"class="btn btn-danger"></a></td>
				</tr>
		  <?php }?>
				 </tbody>
				</table>
				 </div>
				</div>
				</div>
				<?php
				}else{        
				?>
				<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Reports <a href="#upper" data-toggle="modal"Style="margin-left:240px;" class="btn btn-primary"><input type="button"value="Print all"class="btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Term</th>
				<th>Year</th>
				<th>Action</th>
				</tr>
				</thead><tbody>
				<?php
				$pu = $dbh->query("SELECT * FROM lower_upper where session='$ed'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 
				 $count=$count+1;
			?> 
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<td><a href="<?php echo '?upper='.$f;?>" data-toggle="modal" class="btn btn-danger"><input type="button"value="Marks"class="btn btn-danger"></a></td>
				 </tr>        <?php   }?> 
				 
				  </tbody>
				</table>
				 </div>
				</div>
				</div>
				 <?php
						 }}?>
				 <div class="modal fade" tabindex="-1" role="dialog"  id="mid_upper" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						 <a href="#" class="btn btn-primary"
				onclick="PrintElem('#print')" title="Print Report" ><button type="button"class="btn btn-primary" >Save To <img src="assets/img/pdf.png" width="30px" height="30px"/></button></a>	 <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
					
						<?php 
						
				
				$ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					  
						 $Class = $_POST['class'];
						 $counter=0;

		 $pu = $dbh->query("SELECT * FROM lower_upper where session='$id'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  $birth= $xt->DOB;
				 $image = $xt->photo;
				 $balance = $xt->balance;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				   $lug_mid= $x->luganda; 
                  $eng_mid= $x->english; 
				  $lita_mid= $x->lita;
                  $litb_mid= $x->litb;
				   $re_mid= $x->re;
                  $num_mid= $x->numbers;
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_upper_mid where lower_upper_id='$f' ORDER BY total_mid desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id = $ag->lower_upper_mid_id;
					$total_mid =$ag->total_mid;
					$lug=$ag->luganda;
					$eng=$ag->english;
					$lita =$ag->lita;
					$litb= $ag->litb;
					$re =$ag->re;
					$num= $ag->numbers;
					$totalagg=$ag->total_agg;
					$div = $ag->division;
					$total_mid =$ag->total_mid;
				}
				?>
				  <?php
						$sql = $dbh->query("select count(*) as allcount from lower_upper_mid where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
        while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
			 }
			 $L = $dbh->query("select * from lower_upper_mid_position where lower_upper_mid_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
						?>
							
						<div style="margin-bottom:30px;">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="4"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="4">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="5">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Numbers </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $num_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $num ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy A</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lita_mid;?>  </td>
				
				<td style="border:1px solid black;"><?php echo $lita ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Literacy B</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $litb_mid;?></td>
				
				<td style="border:1px solid black;"><?php echo $litb ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > R.E </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $re_mid ;?></td>
				
				<td style="border:1px solid black;"><?php echo $re ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Luganda </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lug_mid ;?></td>
				
				<td style="border:1px solid black;"><?php echo $lug ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Math</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">600</td>
				<td style="border:1px solid black;"> <?php echo $total_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/>          <?php echo $balance;?> </td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
				 </div></diV><?php }?></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>
						<div class="modal fade" tabindex="-1" role="dialog"  id="upper" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						 <a href="#" class="btn btn-primary"
				onclick="PrintElem('#print')" title="Print Report" ><button type="button"class="btn btn-primary" >Save To <img src="assets/img/pdf.png" width="30px" height="30px"/></button></a>	 <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
					
						<?php 
						
				
				$ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					  
						 $Class = $_POST['class'];
						 $counter=0;

		 $pu = $dbh->query("SELECT * FROM lower_upper where session='$ed'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $ter = $x->session;
				 $lid=$x->student_lid;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth= $xt->DOB;
				 $image = $xt->photo;
				 $balance= $xt->balance;
				  }
				 
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $lug_end= $x->luganda; 
                  $eng_end= $x->english; 
				  $lita_end= $x->lita;
                  $litb_end= $x->litb;
				   $re_end= $x->re;
                  $num_end= $x->numbers;
				 
				$p = $dbh->query("SELECT * FROM lower_upper where session='$id' and student_lid='$lid' and class='$Class'and year='$Year'and term='$Term' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					 
					 $lug_mid= $x->luganda; 
                  $eng_mid= $xa->english; 
				  $lita_mid= $xa->lita;
                  $litb_mid= $xa->litb;
				   $re_mid= $xa->re;
                  $num_mid= $xa->numbers;
				  
				 }
				  
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_upper_final where student_lid='" . $lid . "' and class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$d = $ag->lower_upper_final_id;
					$lug=$ag->luganda;
					$num=$ag->numbers;
					$re=$ag->re;
					$eng=$ag->english;
					$lita=$ag->lita;
					$litb=$ag->litb;
					$div=$ag->division;
					$lug_avg=$ag->avg_lug;
					$num_avg=$ag->avg_num;
					$re_avg=$ag->avg_re;
					$eng_avg=$ag->avg_eng;
					$lita_avg=$ag->avg_lita;
					$litb_avg=$ag->avg_litb;
					$totalagg =$ag->total_agg;
					$totalavg =$ag->total_avg;
				}
				?>
				 
				  <?php
						$sql = $dbh->query("select count(*) as allcount from lower_upper_final where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
				 }
				 $L = $dbh->query("select * from lower_upper_final_position where lower_upper_final_id='" . $d . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
						?>
							
						<div style="margin-bottom:30px;">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					<table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="6"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="6">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="7">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $eng_end;?></td>
				<td style="border:1px solid black;"><?php echo $eng_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Numbers</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $num_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $num_end;?> </td>
				<td style="border:1px solid black;"><?php echo $num_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $num ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;">Literacy A</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lita_mid;?>  </td>
				<td style="border:1px solid black;"> <?php echo $lita_end;?> </td>
				<td style="border:1px solid black;"><?php echo $lita_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $lita ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Literacy B</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $litb_mid;?></td>
				<td style="border:1px solid black;"><?php echo $litb_end;?></td>
				<td style="border:1px solid black;"><?php echo $litb_avg;?></td>
				<td style="border:1px solid black;"><?php echo $litb ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > R.E </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"><?php echo $re_mid ;?> </td>
				<td style="border:1px solid black;"><?php echo $re_end ;?></td>
				<td style="border:1px solid black;"><?php echo $re_avg ;?></td>
				<td style="border:1px solid black;"><?php echo $re;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Luganda </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lug_mid ;?></td>
				<td style="border:1px solid black;"><?php echo $lug_end ;?></td>
				<td style="border:1px solid black;"><?php echo $lug_avg ;?></td>
				<td style="border:1px solid black;"><?php echo $lug ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">600</td>
				<td style="border:1px solid black;"> <?php echo ($lug_mid+$re_mid+ $lita_mid +$litb_mid +$num_mid+$eng_mid);?> </td>
				<td style="border:1px solid black;"><?php echo ($lug_end+$re_end+ $lita_end +$litb_end +$num_end+$eng_end);?></td>
				<td style="border:1px solid black;"><?php echo $totalavg;?></td>
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Balance:<br/>   <?php echo $balance?>  </td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
				 </div></diV><?php }?></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

					
				
				<?php
				   
					if($count>0){
					
					}else{
				echo "<script>
					alert('No $Class pupil in term $Term of  $Year  available $count ');
					window.location ='home.php';
					</script>";
			 }
					}elseif(isset($_REQUEST['report'])){
						 $ed = "EOT";
						 $count=0;
						 $id ="MID";
	                   $Year = $_POST['year'];
	                 $Term = $_POST['term'];
	                $period=$_POST['period'];
	                $Class = $_POST['class'];
		            $counter=0;
            if($period=="MID"){
						?>
				    <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Reports<a href="#mid_report" data-toggle="modal"Style="margin-left:240px;" class="btn btn-primary"><input type="button"value="Print all"class="btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Term</th>
				<th>Year</th>
				<th>Action</th>
				</tr>
				</thead><tbody>
					<?php
					// if(isset($_POST['report'])){
						
		 $pu = $dbh->query("SELECT * FROM result where session='$id'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 
				 $count=$count+1;
				?>
				 
				
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<td><a href=""><a href="<?php echo '?mid_num='.$x->result_id;?>" data-toggle="modal" class="btn btn-danger"><input type="button"value="Marks" name="num" class="btn btn-danger"/></a></a></td>
				 <?php 	
			}    
					?>
					</tbody>
				</table>
				</div>
				</div>
				</div><?php
				 }else {?>
					 <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Students Reports<a href="#report" data-toggle="modal"Style="margin-left:240px;" class="btn btn-primary"><input type="button"value="Print all"class="btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Term</th>
				<th>Year</th>
				<th>Action</th>
				</tr>
				</thead><tbody>
				<?php
				 $pu = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 $count=$count+1;
				?>
				 
				
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<td><a href=""><a href="<?php echo '?num='.$x->result_id;?>" data-toggle="modal" class="btn btn-danger"><input type="button"value="Marks" name="num" class="btn btn-danger"/></a></a></td>
				 </tr>
				 <?php 	
			}?></table>
				</div>
				</div>
				</div><?php
				
			}	?>	
		
				<div class="modal fade" tabindex="-1" role="dialog"  id="report" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						
						 <a href="#" class="btn btn-primary"
				onclick="PrintElem('#print2')" title="Print Report" ><button type="button"class="btn btn-primary" >Save To <img src="assets/img/pdf.png" width="30px" height="30px"/></button></a> <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print2">
						<?php
						$ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					  
						 $Class = $_POST['class'];
						 $counter=0;

		 $pu = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				  $lid=$x->student_lid;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth= $xt->DOB;
				 $image = $xt->photo;
				 $balance= $xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $sci_end= $x->science; 
                  $eng_end= $x->english; 
				  $sst_end= $x->sst;
                  $math_end= $x->math;
				$p = $dbh->query("SELECT * FROM result where session='$id' and student_lid='$lid'and class='$Class'and year='$Year'and term='$Term' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					 
					 $sci_mid= $xa->science; 
                  $eng_mid= $xa->english; 
				  $sst_mid= $xa->sst;
                  $math_mid= $xa->math;
				 }
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from graded_result where student_lid='" . $x->student_lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$d= $ag->grade_id;
					$sci=$ag->sci_agg;
					$math=$ag->math_agg;
					$sst=$ag->sst_agg;
					$eng=$ag->eng_agg;
					$div=$ag->div;
					$sci_avg=$ag->sci_av;
					$math_avg=$ag->math_av;
					$eng_avg=$ag->eng_av;
					$sst_avg=$ag->sst_av;
					$totalagg =$ag->total_agg;
					$totalavg =$ag->total_avg;
				}
						$sql = $dbh->query("select count(*) as allcount from graded_result where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
				 }
				 $L = $dbh->query("select * from upper_position where grade_id='" . $d . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
				 ?>
						<div style="margin-bottom:30px;">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					<table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="6"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="100px" width="85px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="6">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="7">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $eng_end;?></td>
				<td style="border:1px solid black;"><?php echo $eng_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sci_mid;?>  </td>
				<td style="border:1px solid black;"> <?php echo $sci_end;?> </td>
				<td style="border:1px solid black;"><?php echo $sci_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $sci ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sst_mid;?></td>
				<td style="border:1px solid black;"><?php echo $sst_end;?></td>
				<td style="border:1px solid black;"><?php echo $sst_avg;?></td>
				<td style="border:1px solid black;"><?php echo $sst ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">400</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$eng_mid+$sst_mid+$sci_mid);?> </td>
				<td style="border:1px solid black;"><?php echo ($math_end+$eng_end+$sst_end+$sci_end);?></td>
				<td style="border:1px solid black;"><?php echo $totalavg;?></td>
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Balance:<br/> <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					</div>
				 </div></div><?php } ?></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print2')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>
<div class="modal fade" tabindex="-1" role="dialog"  id="mid_report" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						
						 <a href="#" class="btn btn-primary"
				onclick="PrintElem('#print')" title="Print Report" ><button type="button"class="btn btn-primary" >Save To <img src="assets/img/pdf.png" width="30px" height="30px"/></button></a> <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<?php
						$ed = "EOT";
						 $count=0;
						 $id ="MID";
						 $Year = $_POST['year'];
						 $Term = $_POST['term'];
					  
						 $Class = $_POST['class'];
						 $counter=0;

		 $pu = $dbh->query("SELECT * FROM result where session='$id'and class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->result_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $image = $xt->photo;
				 $birth = $xt->DOB;
				 $balance=$xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $sci_mid= $x->science; 
                  $eng_mid= $x->english; 
				  $sst_mid= $x->sst;
                  $math_mid= $x->math;
				
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from mid_upper where result_id='$f' ORDER BY total desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id =$ag->mid_id;
					$sci=$ag->science;
					$math=$ag->math;
					$sst=$ag->sst;
					$eng=$ag->english;
					$div=$ag->div;
					
					$totalagg =$ag->total_agg;
					
				}
						$sql = $dbh->query("select count(*) as allcount from mid_upper where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
				 }
				 $L = $dbh->query("select * from mid_upper_position where mid_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}?>
						<div style="margin-bottom:30px;">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="4"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="4">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="5">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $math ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sci_mid;?>  </td>
				
				<td style="border:1px solid black;"><?php echo $sci;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $sst_mid;?></td>
				
				<td style="border:1px solid black;"><?php echo $sst ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">400</td>
				<td style="border:1px solid black;"> <?php echo ($math_mid+$eng_mid+$sst_mid+$sci_mid);?> </td>
				
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/> <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
				 </div></div><?php } ?></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>
					<?php if($count!=0){
					
					}else{
				 echo "<script>
					alert('No $Class pupil in term $Term of  $Year  available ');
					window.location ='home.php';
					</script>";
			 }
					}elseif (isset($_REQUEST['lower'])){
							$d = $_REQUEST['lower'];
						 $pu = $dbh->query("SELECT * FROM result_lower where lower_id='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?>
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report_lower'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "EOT";?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report_lower" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#lower" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" class="btn btn-danger"/></a>
					</div>
						<?php
				         $ed = "EOT";
						 $count=0;
						 $id ="MID";
		                 $counter=0;
		 $pu = $dbh->query("SELECT * FROM result_lower where lower_id='$d' and session='$ed' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth = $xt->DOB;
				 $image = $xt ->photo;
				 $balance=$xt->balance;
				  }
				  $lid=$x->student_lid;
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				 $count=$count+1;
				  $health_end= $x->health_habits; 
                  $lang_end= $x->laguage_devt_1; 
				  $social_end= $x->social_devt;
                  $math_end= $x->math_concepts;
				  
                  $reading_end= $x->reading;
				  
			$sql = $dbh->query("select count(*) as allcount from lower_grade where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
			
				$p = $dbh->query("SELECT * FROM result_lower where session='$id'and student_lid='$lid'and class='$clas'and year='$yea'and term='$period' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					 
				  $health_mid= $xa->health_habits; 
                  $lang_mid= $xa->laguage_devt_1; 
				  $social_mid= $xa->social_devt;
                  $math_mid= $xa->math_concepts;
				
				 $reading_mid= $xa->reading;}
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_grade where student_lid='" . $x->student_lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id=$ag->lower_grade_id;
				  $health_avg= $ag->health_avg; 
                  $lang_avg= $ag->ld1_avg; 
				  $social_avg= $ag->social_avg;
                  $math_avg= $ag->math_avg;
				$reading_avg= $ag->reading_avg;
					$total_end =$ag->total_end;
					$total_mid =$ag->total_mid;
					$total_avg =$ag->total_avg;
				 }$L = $dbh->query("select * from lower_position where lower_grade_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="lower" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
				
				
				 
			 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="5"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="100px" width="85px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="5">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="6">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths Concepts </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $math_end;?> </td>
				<td style="border:1px solid black;"><?php echo $math_avg;?> </td>
				
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $social_mid ;?></td>
				<td style="border:1px solid black;"><?php echo $social_end ;?></td>
				<td style="border:1px solid black;"><?php echo $social_avg ;?></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $health_mid ;?></td>
				<td style="border:1px solid black;"><?php echo $health_end ;?></td>
				<td style="border:1px solid black;"><?php echo $health_avg ;?></td>
			 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lang_mid ;?></td>
				<td style="border:1px solid black;"><?php echo $lang_end ;?> </td>
				<td style="border:1px solid black;"><?php echo $lang_avg ;?></td>
				 
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $reading_mid ;?></td>
				<td style="border:1px solid black;"><?php echo $reading_end ;?></td>
				<td style="border:1px solid black;"><?php echo $reading_avg ;?></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				 
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">500</td>
				<td style="border:1px solid black;"> <?php echo $total_mid;?> </td>
				<td style="border:1px solid black;"><?php echo $total_end;?></td>
				<td style="border:1px solid black;"><?php echo $total_avg;?></td>
				 
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="4" > Division: </td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="2">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Balance:<br/><?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="2"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="2">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="2">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				 
			 } 
					}elseif (isset($_REQUEST['mid_lower'])){
							$d = $_REQUEST['mid_lower'];
						 $pu = $dbh->query("SELECT * FROM result_lower where lower_id='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?>
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report_lower'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "MID";?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report_lower" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#mid_lower" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" class="btn btn-danger"/></a>
					</div>
						<?php
				         $ed = "EOT";
						 $count=0;
						 $id ="MID";
		                 $counter=0;
		 $pu = $dbh->query("SELECT * FROM result_lower where lower_id='$d' and session='$id' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  $birth=$xt->DOB;
				  $image=$xt->photo;
				  $balance=$xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				
				 $count=$count+1;
				  
				  $health_mid= $x->health_habits; 
                  $lang_mid= $x->laguage_devt_1; 
				  $social_mid= $x->social_devt;
                  $math_mid= $x->math_concepts;
				  
				 $reading_mid= $x->reading;
				 
			$sql = $dbh->query("select count(*) as allcount from mid_lower where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; }
				  
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from mid_lower where lower_id='$f' ORDER BY total desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id = $ag->mid_lid;
					$total_mid =$ag->total;
					
				 }$L = $dbh->query("select * from mid_lower_position where mid_lid='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						<div class="modal fade" tabindex="-1" role="dialog"  id="mid_lower" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
					 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="3"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img   src="staff/<?php echo $image; ?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="3">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="4">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Maths Concepts</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $math_mid;?> </td>
				
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> S.S.T</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > Social Dev't </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $social_mid;?> </td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $health_mid;?> </td>
				
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Language Dev't </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lang_mid;?> </td>
				<td style="border:1px solid black;"> </td>
				
				
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $reading_mid;?> </td>
				
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">500</td>
				<td style="border:1px solid black;"> <?php echo $total_mid;?> </td>
				
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="2" > Division: </td>
				<td style="border:1px solid black;"colspan="3">Position:  <?php echo $position;?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="2">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/><?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="2"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="2">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="2">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					
					</div>
					</div></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>

				
				<?php
				 
			 } 
					}elseif(isset($_REQUEST['num'])){
						$d = $_REQUEST['num'];
						 $pu = $dbh->query("SELECT * FROM result where result_id='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?> 
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "EOT";?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#report" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" name="num" class="btn btn-danger"/></a>
					</div>
					<?php
					reporting();
					}elseif(isset($_REQUEST['mid_num'])){
						$d = $_REQUEST['mid_num'];
						 $pu = $dbh->query("SELECT * FROM result where result_id='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?> 
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "MID";?>" />
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#mid" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" name="num" class="btn btn-danger"/></a>
					</div>
					<?php
					reporting_midd();
					}elseif(isset($_REQUEST['upper'])){
						$d = $_REQUEST['upper'];
						 $pu = $dbh->query("SELECT * FROM lower_upper where lower_upper_id='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?> 
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report_upper'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="period" value="<?php echo "EOT";?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" /> 
						<a href="" class="btn btn-warning"><input type="submit" name="report_upper" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#upper" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" name="num" class="btn btn-danger"/></a>
					</div>
					
					<div class="modal fade" tabindex="-1" role="dialog"  id="upper" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<?php 
						
				
				include('config.php');
	 $ed = "EOT";
	 
	 $c=$_REQUEST['upper'];
	$id ="MID";
	$count=0;
	          $pu = $dbh->query("SELECT * FROM lower_upper where session='$ed'and lower_upper_id='$c'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $image= $xt->photo;
				 $birth= $xt->DOB;
				 $balance= $xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				  $count=$count+1;
				   $lid=$x->student_lid;
				 $lug_end= $x->luganda; 
                  $eng_end= $x->english; 
				  $re_end= $x->re;
                  $num_end= $x->numbers; 
				  $lita_end= $x->lita;
                  $litb_end= $x->litb; 
				$sql = $dbh->query("select count(*) as allcount from lower_upper_final where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
	 	      $p = $dbh->query("SELECT * FROM lower_upper where  session='$id' and student_lid='".$x->student_lid."' and class='$clas'and year='$yea'and term='$period' ");
		 	 
				 while($xa = $p->fetch(PDO::FETCH_OBJ)){
					
					 $lug_mid= $xa->luganda; 
                  $eng_mid= $xa->english; 
				  $re_mid= $xa->re;
                  $num_mid= $xa->numbers; 
				  $lita_mid= $xa->lita;
                  $litb_mid= $xa->litb; }
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_upper_final where student_lid='" . $lid . "' and class='" . $x->class . "' and term='" . $x->term . "' and year='" . $x->year . "' ORDER BY total_avg");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id=$ag->lower_upper_final_id;
					$lug=$ag->luganda;
					$num=$ag->numbers;
					$lita=$ag->lita;
					$litb=$ag->litb;
					$re=$ag->re;
					$eng=$ag->english;
					$div=$ag->division;
					$lug_avg=$ag->avg_lug;
					$num_avg=$ag->avg_num;
					$lita_avg=$ag->avg_lita;
					$litb_avg=$ag->avg_litb;
					$re_avg=$ag->avg_re;
					$eng_avg=$ag->avg_eng;
					$totalagg =$ag->total_agg;
				$totalavg =$ag->total_avg;}
				$L = $dbh->query("select * from lower_upper_final_position where lower_upper_final_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position = $a->position;
					
					}
				?>
						
						<div style="margin-bottom:30px;">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
					
				
				
				 
			 <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="6"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image;?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="6">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="7">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				<td style="border:1px solid black;"><strong> E.O.T</strong> </td>
				<td style="border:1px solid black;"><strong>Average</strong> </td>
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $eng_end;?></td>
				<td style="border:1px solid black;"><?php echo $eng_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Numbers </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $num_mid;?> </td>
				<td style="border:1px solid black;"> <?php echo $num_end;?> </td>
				<td style="border:1px solid black;"><?php echo $num_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $num ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy A</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lita_mid;?>  </td>
				<td style="border:1px solid black;"> <?php echo $lita_end;?> </td>
				<td style="border:1px solid black;"><?php echo $lita_avg;?> </td>
				<td style="border:1px solid black;"><?php echo $lita ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Literacy B</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $litb_mid;?></td>
				<td style="border:1px solid black;"><?php echo $litb_end;?></td>
				<td style="border:1px solid black;"><?php echo $litb_avg;?></td>
				<td style="border:1px solid black;"><?php echo $litb ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > R.E </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $re_mid;?></td>
				<td style="border:1px solid black;"><?php echo $re_end;?></td>
				<td style="border:1px solid black;"><?php echo $re_avg;?></td>
				<td style="border:1px solid black;"><?php echo $re;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Health Habits </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Luganda </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lug_mid;?></td>
				<td style="border:1px solid black;"><?php echo $lug_end;?> </td>
				<td style="border:1px solid black;"><?php echo $lug_avg;?></td>
				<td style="border:1px solid black;"><?php echo $lug;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Maths</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">600</td>
				<td style="border:1px solid black;"> <?php echo ($lug_mid+$eng_mid+$lita_mid+$lita_mid+$re_mid+$num_mid);?> </td>
				<td style="border:1px solid black;"><?php echo ($lug_end+$eng_end+$lita_end+$lita_end+$re_end+$num_end);?></td>
				<td style="border:1px solid black;"><?php echo $totalavg;?></td>
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Division: <?php echo $div;?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position ;?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Class Teacher's Comment:<br/>................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>..............................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="5" > Balance:<br/>       <?php echo $balance;?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.............................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Head Teacher's  Comment<br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>............................................................. </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="5" > Next Term Begins On: <br/>.................................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...........................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					</div>
				 </div><?php }?></diV></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>
					
					
					<?php
					
					}elseif(isset($_REQUEST['mid_upper'])){
						$d = $_REQUEST['mid_upper'];
						 $pu = $dbh->query("SELECT * FROM lower_upper where lower_upper_id='$d' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
					 $class=$x->class;
					 $term=$x->term;
					 $year=$x->year;
				 }
						?> 
						<div style="border:5px ridge ghostwhite; border-radius:100px; padding:20px 20px 20px 20px; width:200px;
							margin:10px 10px 10px 10px;"><form method="post" onsubmit=" window.location='home.php?report_upper'" >
						<input type="hidden" name="class" value="<?php echo $class;?>" /> 
						<input type="hidden" name="term" value="<?php echo $term;?>" /> 
						<input type="hidden" name="year" value="<?php echo $year;?>" />
                        <input type="hidden" name="period" value="<?php echo "MID";?>" />						
						<a href="" class="btn btn-warning"><input type="submit" name="report_upper" value="Return to Names" class="btn btn-primary" /> </a>
						</form>
						<a href="#upper" data-toggle="modal" class="btn btn-danger"><input type="button"value="View Report" name="num" class="btn btn-danger"/></a>
					</div>
					
					<div class="modal fade" tabindex="-1" role="dialog"  id="upper" aria-hidden="true"><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-bg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" > <!--defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <marquee behavior="alternate" direction="right" scroll-amount="100px">
							<h4  style="color:blue;font-weight:normal"> Pupil Report </h4>
						  </marquee>
						</div>
					<div class="modal-body" >
						<div id="print">
						<?php 
						
				
				include('config.php');
	 $ed = "EOT";
	 
	 $c=$_REQUEST['mid_upper'];
	$id ="MID";
	$count=0;
	          $pu = $dbh->query("SELECT * FROM lower_upper where session='$id'and lower_upper_id='$c'");
		 	 
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $f= $x->lower_upper_id; 
				 $ter = $x->session;
				 $p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				 $birth= $xt->DOB;
				 $image= $xt->photo;
				 $balance =$xt->balance;
				  }
				
				 $clas= $x->class;
				 $yea = $x->year;
				 $period=$x->term;
				  $count=$count+1;
				  
				 $lug_mid= $x->luganda; 
                  $eng_mid= $x->english; 
				  $re_mid= $x->re;
                  $lita_mid= $x->lita; 
				  $litb_mid= $x->litb;
                  $num_mid= $x->numbers; 
				$sql = $dbh->query("select count(*) as allcount from lower_upper_mid where class='" . $clas . "' and term='" . $period . "' and year='" . $yea . "'");
         while($xs = $sql->fetch(PDO::FETCH_OBJ)){
		 $counter= $xs->allcount; 
	   }
	 	      
				//$AL = $dbh->query("SELECT * FROM result where session='$ed'and class='$Class'and year='$Year'and term='$Term' ORDER BY total_avg desc");
		 	  $AL = $dbh->query("select * from lower_upper_mid where lower_upper_id='" . $f . "'   ORDER BY total_mid desc");
				while($ag = $AL->fetch(PDO::FETCH_OBJ)){
					$id=$ag->lower_upper_mid_id;
					$lug=$ag->luganda;
					$lita=$ag->lita;
					$litb=$ag->litb;
					$eng=$ag->english;
					$re=$ag->re;
					$num=$ag->numbers;
					$totalagg= $ag->total_agg;
					$div=$ag->division;
					$total_mid = $ag->total_mid;
					}
					$L = $dbh->query("select * from lower_upper_mid_position where lower_upper_mid_id='" . $id . "' ");
				while($a = $L->fetch(PDO::FETCH_OBJ)){
					$position=$a->position;
					
					}
					?>
						
						<div style="margin-bottom:30px;">
						<div style="border:black solid 4px;" >
					<div style="border:black ridge 5px;padding:5px 5px 5px 5px;">
					
					  <table border="1" width="100%" cellspacing="0">
				<tr>
				<td style="padding-left:10px;" rowspan="2"><center><img src="assets/img/loog.png" alt="logo" height="100px" /></center></td>
				<td colspan="4"><center><h2>STERAC NURSERY AND PRIMARY <br/>SCHOOL-BUYAMBA</h2>P.O BOX 389 KYOTERA <br/>
				Tel: 0782417595 /0758722651<br/>
									TERMINAL REPORT </center></td>
				<td rowspan="2"><center><img src="staff/<?php echo $image?>" alt="logo" height="120px" width="100px"/></center></td>

				</tr>
				<tr >


				</tr>
				<tr>
				<td style="border:1px solid black;"> Term: <b style="text-transform:uppercase;"><?php echo $period?> </b></td>
				<td style="border:1px solid black;"colspan="4">Name: <b style="text-transform:uppercase;"><?php echo $e;?> </b> </td>
				<td style="border:1px solid black;">REG NO: </td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> Class:  <b style="text-transform:uppercase; "><?php echo $clas?></b></td>
				<td style="border:1px solid black;"colspan="5">Date Of Birth: <?php echo $birth?>    &nbsp &nbsp Closing Date:</td>
				</tr>
				<tr>
				<td style="border:1px solid black;"> <strong>Subject</strong> </td>
				<td style="border:1px solid black;" ><strong>Full Marks</strong></td>
				<td style="border:1px solid black;"><strong>MID </strong></td>
				
				<td style="border:1px solid black;"><strong>Grade</strong> </td>
				<td style="border:1px solid black;"> <strong>Teacher's Remarks </strong></td>
				<td style="border:1px solid black;"><strong>Initial </strong></td>

				</tr>
				
				 <tr>
				<td style="border:1px solid black;"> English </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $eng_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $eng ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 
				 <tr>
				<td style="border:1px solid black;"> Numbers </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $num_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $num ;?> </td>
				<td style="border:1px solid black;">   </td>
				<td style="border:1px solid black;"></td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Literacy A</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lita_mid;?>  </td>
				
				<td style="border:1px solid black;"><?php echo $lita ;?> </td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Literacy B</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $litb_mid;?></td>
				
				<td style="border:1px solid black;"><?php echo $litb ;?></td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;" > R.E </td>
				<td style="border:1px solid black;" >100</td>
				<td style="border:1px solid black;"> <?php echo $re_mid ;?></td>
				
				<td style="border:1px solid black;"><?php echo $re ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Luganda </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"><?php echo $lug_mid ;?></td>
				
				<td style="border:1px solid black;"><?php echo $lug ;?></td>
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Math</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>
				
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> Writing & Reading</td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"> Science </td>
				<td style="border:1px solid black;">100</td>
				<td style="border:1px solid black;"> </td>
				<td style="border:1px solid black;"></td>
				
				<td style="border:1px solid black;">  </td>
				<td style="border:1px solid black;"></td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"> TOTAL </td>
				<td style="border:1px solid black;">600</td>
				<td style="border:1px solid black;"> <?php echo $total_mid;?> </td>
				
				<td style="border:1px solid black;"><?php echo $totalagg;?> </td>
				<td style="border:1px solid black;"></td>
				<td style="border:1px solid black;"> </td>

				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Division: <?php echo $div?></td>
				<td style="border:1px solid black;"colspan="3">Position: <?php echo $position?></b>&nbsp Out Of:<b style="text-transform:uppercase; "><?php echo $counter ?></b></td>


				</tr>
				
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Class Teacher's Comment:<br/>.......................................................................</td>
				<td style="border:1px solid black;"colspan="3">Class Teacher's Signature:<br/>.......................................................</td>


				</tr>
				 <tr>
				<td style="border:1px solid black;"colspan="3" > Balance:<br/>              <?php echo $balance ?></td>
				<td style="border:1px solid black;"colspan="3"> Bursar's Signature:<br/>.....................................................</td>


				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Head Teacher's  Comment<br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Head Teacher's Signature<br/>..................................................... </td>

				</tr>
				<tr>
				<td style="border:1px solid black;"colspan="3" > Next Term Begins On: <br/>.........................................................................</td>
				<td style="border:1px solid black;"colspan="3">Visitation Day:<br/>...................................................</td>

				</tr>
				</table>
				<br />
				<table border="1" width="100%" >
				<tr> 
				<td colspan="10"><center> PRIMARY SECTION GRADING SYSTEM</center></td>

				</tr>
				<tr> 
				<td>Marks</td>
				<td>85-100</td>
				<td>75-84</td>
				<td>70-74</td>
				<td>65-69</td>
				<td>60-64</td>
				<td>55-59</td>
				<td>50-54</td>
				<td>40-49</td>
				<td>00-39</td>

				</tr>
				<tr>
				<td>Score</td>
				<td>D1</td>
				<td>D2</td>
				<td>C3</td>
				<td>C4</td>
				<td>C5</td>
				<td>C6</td>
				<td>P7</td>
				<td>P8</td>
				<td>F9</td>

				</tr>
				</table>
				<strong><center><p>THIS REPORT IS ONLY VALID IF STAMPED</p></center></strong>
					
					
					</div>
				 </div><?php }?></diV></div>
					</div>
					
	<div class="modal-footer"> 
				
				
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
				<a href="#" 
				onclick="PrintElem('#print')" title="Print Report" ><img src="assets/img/pdf.png" width="30px" height="30px"/></a>
		
		
		
	</div>

</div>	<!--end of modal-content-->						  
</div>	<!-- end of modal-sm  div --> 						  
</div>
					
					
					<?php
					
					}elseif(isset($_REQUEST['best'])){
						?>
						  <div class="panel panel-default">
                        <div class="panel-heading">
                         Best 10 Students Reports
							</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Class</th>
				<th>Average Mark</th>
				<th>Term</th>
				<th>Year</th>
				
				</tr>
				</thead><tbody>
					<?php
					// if(isset($_POST['report'])){
						 $ed = "EOT";
						 $count;
						 $id ="MID";
	     $Year = $_POST['year'];
	     $Term = $_POST['term'];
	  
	     $Class = $_POST['class'];
		 $count=0;

		 $pu = $dbh->query("SELECT * FROM graded_result where class='$Class'and year='$Year'and term='$Term' order by total_avg DESC LIMIT 10");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				$p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				
				 $count=$count+1;
				 $class=$x->class;
				 $avg=$x->total_avg;
				
				?>
				 
				
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $class?></td>
				<td><?php echo $avg?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<?php 	
			 }      	 if($count==0){
				echo "<script>
					alert('No $Class pupil in term $Term of  $Year  available ');
					window.location ='home.php';
					</script>";
			 }					
					?>
					</tbody>
				</table>
				</div>
				</div>
				</div>
				<?PHP
					}elseif(isset($_REQUEST['worst'])){
						?>
						<div class="panel panel-default">
                        <div class="panel-heading">
                          Worst 10  Students 
							</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
				<tr>
				<th>#</th>
				<th>Student</th>
				<th>Class</th>
				<th>Average Mark</th>
				<th>Term</th>
				<th>Year</th>
				
				</tr>
				</thead><tbody>
					<?php
					// if(isset($_POST['report'])){
						 $ed = "EOT";
						 $count=0;
						 $id ="MID";
	     $Year = $_POST['year'];
	     $Term = $_POST['term'];
	  
	     $Class = $_POST['class'];
		 $counter=0;

		 $pu = $dbh->query("SELECT * FROM graded_result where class='$Class'and year='$Year'and term='$Term' order by total_avg ASC LIMIT 10");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				$p = $dbh->query("SELECT * FROM student_lower where student_lid='".$x->student_lid."'");
				  while($xt = $p->fetch(PDO::FETCH_OBJ)){
				 $e= $xt->name;
				  }
				 
				 $count=$count+1;
				 $class=$x->class;
				 $avg=$x->total_avg;
				
				?>
				 
				
				<tr>
				<td><?php echo $count?></td>
				<td><?php echo $e?></td>
				<td><?php echo $class?></td>
				<td><?php echo $avg?></td>
				<td><?php echo $Term?></td>
				<td><?php echo $Year?></td>
				<?php 	
			 }      if($count==0){
				echo "<script>
					alert('No $Class pupil in term $Term of  $Year  available ');
					window.location ='home.php';
					</script>";
			 }	
				 
					?>
					</tbody>
				</table>
				
				</div>
				</div>
				</div>
				<?php
					}elseif(isset($_REQUEST['total'])){
						 $ed = "EOT";
						 $count=0;
						 $id ="MID";
	     $Year = $_POST['year'];
	     $Term = $_POST['term'];
	  
	     $Class = $_POST['class'];
		 $counter=0;
          
		 $pu = $dbh->query("select count(*) as allcount FROM graded_result where class='$Class'and year='$Year'and term='$Term' ");
		 	
				 while($x = $pu->fetch(PDO::FETCH_OBJ)){
				 $count=$x->allcount;
				 }
				 echo "<script>
					alert('$count  pupils  of  $Class  in  term  $Term  of   $Year  are available ');
					window.location ='home.php';
					</script>";
					}
					else{
							?>
							
							<div class='content-tittle'>***WELCOME TO ***</div>
							<div style="border:5px ridge ghostwhite; margin-right:-105px;border-radius:15px;">
							<center><p style="margin-left:200px">Results & Report Management System  </p></center>
							<div id="sliderFrame">
						    <div id="slider">
							<img src="assets/img/im1.png" alt="1" />
							<img src="assets/img/im2.png" alt="2" />
						</div>
						</div>
				       </div>
							<?php
							}
							?>
													 
											 
						</div></center>

							<!-- END Page content -->

                                	
                       </div> 

                    </div>   
                    <div class="clearfix"></div>  
				</div>

            </div>
			 <script src="assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
           <script src="assets/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
          <script src="assets/vendor/datatables-responsive/dataTables.responsive.js"></script>
			<script >
		$(document).ready(function() {
			$('#example').DataTable();
		} );

	</script>
	<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>
			<?php include('include/footer.php');