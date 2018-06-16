     <link href="bootstrap/css/admin_background.css" rel="stylesheet" media="screen"/>
<link rel="shortcut icon" href="images/logo.png" />
	 <div class="span3" id="sidebar">
	              <img id="admin_avatar" class="img-circle" src="<?php echo $row['thumbnails']; ?>">
	                 
                  <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                           <li class="active"> 
						   <a href="dashboard.php"><i class="icon-chevron-right"></i><i class="icon-home"></i>&nbsp;Dashboard</a> 
						   </li>
						 
						 <!------/.* manage Students sidebar*------->						
						 <li>						
						    <a href="javascript:;" role="button" class="dropdown-toggle" data-toggle="collapse" data-target="#bs"><i class="icon-chevron-right"></i><i class="icon-user"></i>&nbsp;Manage Student
						    <div class="muted pull-right"><i class="caret"></i></div></a>					
						    <ul id="bs" class="collapse">						
                            <li class="">
                            <a href="studentDetail.php"><i class="icon-chevron-right"></i><i class="icon-user"></i> Stundents Details</a>
                            </li>
						   				
						    <li>
                            <a href="add_student.php"><i class="icon-chevron-right"></i><i class="icon-laptop"></i> Add Student
							</a>
                            </li>
												   							
						    </ul>
						</li>
                         
                          <!------/.* finance sidebar*------->
					    <li>						
						    <a href="javascript:;" role="button" class="dropdown-toggle" data-toggle="collapse" data-target="#bs1"><i class="icon-chevron-right"></i><i class="icon-globe"></i>&nbsp;Fees
							<div class="muted pull-right"><i class="caret"></i></div></a>						
						    <ul id="bs1" class="collapse">						
                            <li class="">
                            <a href="feepaid.php"><i class="icon-chevron-right"></i><i class="icon-file"></i> Paid Fees</a>
                            </li>
						    <li class="">
                            <a href="balances.php"><i class="icon-chevron-right"></i><i class="icon-file"></i> Fees Balances</a>
                            </li>
							
						    </ul>
						</li>
						
					 
						
						
					  <!------/.* notification sidebar*------->
					    <li class="">
				           <a href="mesange.php"><i class="icon-chevron-right"></i><i class="icon-globe"></i>&nbsp;Contact Admin
				           
				           </a>
			            </li>
						<!--------Search Sidebar------>
                         
                        <li class="active">
                           <a href="javascript:;" role="button" class="dropdown-toggle" data-toggle="collapse" data-target="#bs4"><i class="icon-chevron-right"></i><i class="icon-search icon-large"></i>&nbsp;Advance Search 
						   <div class="muted pull-right"><i class="caret"></i></div></a>
                           <ul id="bs4" class="collapse">
                           <li>
                           <a href="#myModal" data-toggle="modal" tabindex="1"><i class="icon-chevron-right"></i><i class="icon-search"></i>&nbsp;Student</a>
                           </li>
                          
                           
                           </ul>
                        </li>
                  </ul>					
				<?php include('search_form.php'); ?>
				<?php include('search_form.php'); ?>										
    </div>