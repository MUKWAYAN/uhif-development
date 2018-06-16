<?php error_reporting(0);
include('header.php'); ?>
<?php include('session.php'); ?>
<?php $class=$_POST['class'];
       $term=$_POST['term'];
	   $year =$_POST['year'];
	   ?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('feespaid_sidebar.php'); ?>
			
				<div class="span9" id="content">
                     <div class="row-fluid">
					 
					  <script type="text/javascript">
		              $(document).ready(function(){
		              $('#add').tooltip('show');
		              $('#add').tooltip('hide');
		              });
		             </script> 
					 <div id="sc" align="center"><image src="images/sclogo.png" width="45%" height="45%"/></div>
				<?php	
	             $count_student=mysql_query("SELECT * from student_lower where class ='".$class."' and term='".$term."'and year='".$year."' and balance >'0' ");
	             $count = mysql_num_rows($count_student);
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Payment list</div>
                          <div class="muted pull-right">
								Number of <?php echo $class?> class payments: <span class="badge badge-info"><?php  echo $count; ?></span>
							 </div>
						  </div>
						  
                 <h4 id="sc">
					<div align="right" id="sc">Date:
						<?php
                            $date = new DateTime();
                            echo $date->format('l, F jS, Y');
                         ?></div>
				 </h4>

													
<div class="container-fluid">
  <div class="row-fluid"> 
     <div class="empty">
	     <div class="pull-right">
		  		      
		   <script type="text/javascript">
		     $(document).ready(function(){
		     $('#print').tooltip('show');
		     $('#print').tooltip('hide');
		     });
		   </script>        	   
         </div>
      </div>
    </div> 
</div>
	
<div class="block-content collapse in">
    <div class="span12">
	<form action="" method="post">
  	<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
		<thead>		
		        <tr>			        
                	<th>Student Name </th>
					<th>Amount Paid</th>
					<th> Date of Payment</th>
					<th>Balance</th>
					
					<th>Action</th>
		    </tr>
		</thead>
<tbody>
<!-----------------------------------Content------------------------------------>
<?php
		$student_query = mysql_query("SELECT * from student_lower where class ='".$class."' and term='".$term."'and year='".$year."' and balance >'0' ")or die(mysql_error());
		while($row = mysql_fetch_array($student_query)){
		$username = $row['student_lid'];
	    $total=$row['balance'];
		
		?>
									
		<tr>
		<form method="post" action="" name="pay">
		<input type="hidden" name="student" value="<?php echo $username;?>" class="input focused"  id="focusedInput" required/>
		<input type="hidden" name="topay" value="<?php echo $total;?>" class="input focused"  id="focusedInput" required/>
		<td><?php echo $row['name']; ?></td>
		    <td><input type="number" name="fee" class="input focused" placeholder="Enter amount paid" id="focusedInput"required/></td>
			<td><input type="date" name="dat" class="input focused"  id="focusedInput"required/></td>
			<td><?php echo $row['balance']; ?></td>
			 
			<td><input type="submit" name="pay" value="save" class="btn btn-primary" data-placement="right" title="Click to Save"/></td>
			</form>
			
            </tr>
											
		<?php } ?>   

</tbody>
</table>
</form>		
		
			  		
</div>
</div>
</div>
</div>
</div>
	
</div>	
<?php 
if(isset($_POST['pay'])){
	$fee =$_POST['fee'];
	$date= $_POST['dat'];
	$username=$_POST['student'];
	$total=$_POST['topay'];
	$balance = $total-$fee;
	$student_query = mysql_query("SELECT * from student_lower where student_lid ='".$username."'  ")or die(mysql_error());
		while($row = mysql_fetch_array($student_query)){
		$yea = $row['year'];
	    $clas=$row['class'];
	    $period=$row['term'];
		}
	mysql_query("insert into fees_lower (fees_id,student_lid,date,paid,balance,class,term,year) values('','$username','$date','$fee','$balance','$clas','$period','$yea')")or die(mysql_error());
	mysql_query("UPDATE student_lower SET balance='".$balance."' where student_lid ='".$username."' ")or die(mysql_error());
  echo "  <form method='post' action='payfee.php'  name='fee' ng-app='amt' ng-controller='value'enctype='multipart/form-data'>
                              
							   <input type='hidden' name='year' value='" .$yea. "' class='input' style='width:50px' required />
							    <input type='hidden' name='class' value='" .$clas. "' class='input' style=' width:50px' required />
								 <input type='hidden' name='term'value='".$period. "' class='input' style=' width:50px' required />
								  
								 <input type='submit'  class='btn btn-danger' name='fee' title='click me please' value='click me to continue please'/></form>";
} 
?>
<?php include('footer.php'); ?>
</div>
<?php include('script.php'); ?>
 </body>
</html>
