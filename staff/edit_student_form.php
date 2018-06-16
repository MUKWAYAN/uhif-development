<div class="row-fluid">				  
   <a href="add_student.php" class="btn btn-info" id="add" data-placement="right" title="Click to Add New" ><i class="icon-plus-sign icon-large"></i> Add New  Student</a>
   <script type="text/javascript">
	$(document).ready(function(){
	$('#add').tooltip('show');
	$('#add').tooltip('hide');
	});
	</script> 
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"><i class="icon-pencil icon-large"></i> Edit Student Info.</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
								<?php
								$query = mysql_query("select * from student_lower where student_lid = '$get_student_id'")or die(mysql_error());
								$row = mysql_fetch_array($query);
								?>
								
								 <!-- --------------------form ---------------------->						
							<form method="post">
					<div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" value="<?php echo $row['name']; ?>" name="name" id="focusedInput" type="text" placeholder = "full name E.g. John Mwiti" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" value="<?php echo $row['parent']; ?>" name="username" id="focusedInput" type="text" placeholder = "Registration number" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused"  value="<?php echo $row['address']; ?>" name="form" id="focusedInput" type="text" placeholder = "Form E.g. 4N" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" value="<?php echo $row['fees']; ?>" name="contacts" id="focusedInput" type="text" placeholder = "mobile number E.g. 072534344" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
																  </p>		
										
									
								 </p>
								  <div class="control-group">
                                <p> <div class="controls">
                                   <p>
                                     <input class="input focused" value="<?php echo $row['DOB']; ?>" name="contact_name" id="focusedInput" type="text" placeholder = "parent/Guardian E.g. Beny Alan" required> 
                                   </p>
                                 </div>
                                  </div>
								  </p>
								
								  </p>
                                    </div>
										
                                
                                        
										<div class="control-group">
                                          <div class="controls">
 <button name="update" class="btn btn-info" id="update" data-placement="right" title="Click to Save"><i class="icon-plus-sign icon-large"> Update</i></button>
												<script type="text/javascript">
	                                            $(document).ready(function(){
	                                            $('#save').tooltip('show');
	                                            $('#save').tooltip('hide');
	                                            });
	                                            </script>
                                          </div>
                                        </div>
                                </form>
					</div>
                </div>
            </div>
              <!-- /block -->
      
<?php		
if (isset($_POST['update'])){
$name = $_POST['name'];
$username = $_POST['username'];
$form = $_POST['form'];
$contacts= $_POST['contacts'];
$contact_name = $_POST['contact_name'];



mysql_query("update student set Name = '$name',username ='$username',Form='$form',contacts='$contacts',contact_name='$contact_name' where student_id='$get_student_id'") 
or die(mysql_error());

mysql_query ("insert into activity_log (date,username,action)
 values(NOW(),'$admin_username','Edited Student $name')")or die(mysql_error());
?>
<script>
  window.location = "add_student.php";
 $.jGrowl(" Student Successfully Update", { header: 'Student Update' });  
</script>
<?php
}
?>
