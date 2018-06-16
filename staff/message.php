<section class="listings">
		<div class="wrapper">
		
			<ul class="properties_list">
			<form method="post">
				<table>
					<tr>
						<td style="color: #003300; font-weight: bold; font-size: 16px">Reply Message:</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>
							<textarea name="message" placeholder="Enter Message Here" class="text"></textarea>
						</td>
					</tr>
					<tr>
						<td><input type="submit" name="send" value="Send Message"></td>
					</tr>
				</table>
			</form>
				<?php
					//if(isset($_POST['send'])){
						
											
						//$message = $_POST['message'];
						
						
					//	$qry = "INSERT INTO message (message,student_id,time,status)
						//	VALUES('$message','$session_id',NOW(),'staff')";
						//	$result = mysql_query($qry)or die(mysql_error());
							//if($result == TRUE){
							//	echo "<script type = \"text/javascript\">
								//			alert(\"Message Successfully Send\");
								//			window.location = (\"dashboard.php\")
										///	</script>";
							//} else{
							//	echo "<script type = \"text/javascript\">
								//			alert(\"Message Not Send. Try Again\");
								//			</script>";
						//	}
					//}
				?>
			</ul>
		</div>
	</section>