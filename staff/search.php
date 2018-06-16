<?php include('header.php'); ?>
<?php include('session.php'); ?>
<?php
 $username = $_POST['username'];
?>
    <body>
		<?php include('navbar.php'); ?>
        <div class="container-fluid">
            <div class="row-fluid">
				<?php include('search_sidebar.php'); ?>
				<div class="span9" id="content">
                     <div class="row-fluid">
					 
					 <div class="empty">
			 	         <div class="alert alert-success">
                            <strong> Advance Search Result List</strong>
                       </div>
			        </div>
				
					 <h2 id="sc" align="center"><image src="images/sclogo.png" width="45%" height="45%"/></h2>
					 <?php	
	             $count_student=mysql_query("select * from student_lower where name LIKE '%$username%' ");
							 
	             $count = mysql_num_rows($count_student);
                 ?>	 
				   <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                             <div class="muted pull-left"><i class="icon-reorder icon-large"></i> student Search Result List</div>
                          <div class="muted pull-right">
								Number of Search Students : <span class="badge badge-info"><?php  echo $count; ?></span>
							 </div>
						  </div>
						  
<h4 id="sc">Students List 
    <div align="right" id="sc">Date:
		<?php
            $date = new DateTime();
             echo $date->format('l, F jS, Y');
        ?></div>
 </h4>						  
                  					  
<br/>
 	
<div class="block-content collapse in">
    <div class="span12">
	<form action="" method="post">
  	<table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
		<thead>		
		        <tr>			        
                	<th>Pupil Name</th>
					<th>Parent Name </th>
					<th>Address</th>
			        <th>Fees Balance</th>
					<th>Term </th>
					<th>Class </th>
                    <th>Year </th>
                    					
		    </tr>
		</thead>
<tbody>
<?php
		$search_query = mysql_query("select * from student_lower where name LIKE '%$username%'")or die(mysql_error());
		while($row = mysql_fetch_array($search_query)){
		$RegNo = $row['name'];
		?>
		<tr>
		
		
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['parent']; ?></td>
			<td><?php echo $row['address']; ?></td>
			<td><?php echo $row['balance']; ?></td>
			<td><?php echo $row['term']; ?></td>
			<td><?php echo $row['class']; ?></td>	
            <td><?php echo $row['year']; ?></td>
			
						
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