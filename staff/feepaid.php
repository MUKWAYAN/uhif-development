<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php $class=$_POST['class'];
       $term=$_POST['term'];
	   $year =$_POST['year'];?> 
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
	             $count_student=mysql_query("select * from student_lower where class='".$class."' and term ='".$term."' and year='".$year."'and balance<='0' ");
	             $count = mysql_num_rows($count_student);
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> Payment list</div>
                          <div class="muted pull-right">
								Number of payments: <span class="badge badge-info"><?php  echo $count; ?></span>
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
		 <form method="post" action="print_feepaid.php">
		 <input type ="hidden" value="<?php echo $class?>" name="class"/>
		 <input type ="hidden" value="<?php echo $term?>" name="term"/>
		 <input type ="hidden" value="<?php echo $year?>" name="year"/>
		<a class="btn btn-info"> <input type ="submit" class="btn btn-info " id="print" data-placement="left" value="Print List" title="Click to Print" class=""/><i class="icon-print icon-large"></i></a> 
		 </form>
		    		      
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
					<th>Parent Name </th>
					<th>Contact/Address</th>
					<th>Fees Balance </th>
			        <th> Total Amount</th>
					
						
                   		
                    				
		    </tr>
		</thead>
<tbody>
<!-----------------------------------Content------------------------------------>
<?php
		$student_query = mysql_query("select * from student_lower where class='".$class."' and term ='".$term."' and year='".$year."'and balance<='0' ")or die(mysql_error());
		while($row = mysql_fetch_array($student_query)){
		$username = $row['name'];
	
		?>
									
		<tr>
		<td><?php echo $row['name']; ?></td>
		    <td><?php echo $row['parent']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><?php echo $row['balance']; ?></td>
			<td><?php echo $row['fees']; ?></td>
			
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
<?php include('footer.php'); ?>
</div>
<?php include('script.php'); ?>
 </body>
</html>