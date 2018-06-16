<div class="row">

				<div class='span12'>
					<div id="footer"> &copy;&nbsp;2018 view<a href="#grp61" data-toggle="modal" title="View Group Details" onclick="return alert(' ** Click OK to view SAMPLE REPORT **')"> SAMPLE REPORT </a></div>
				</div>
			
			<div class="modal fade" id="grp61" role="dialog" ><!-- defines the modal feature with id referenced by button trigger or link -->
							<div class="modal-lg"><!-- defines the size of the modal dialog -->
    
					<!-- Modal content-->
					  <div class="modal-content" ><!-- defines the main content of the modal-->
						<div class="modal-header"><!-- DEFINES the heading of the modal -->
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">VIEW SAMPLE REPORT</h4>
						</div>
					<div class="modal-body" >
					<div class="one">
					<center> <h2>******** Primary School*******</h2>
					<h4>End Of Year Report</center>
						
						<strong><p>Name:..............................................................................................Class:............................
						
						Term:...........................Year :.............................Position:..........................out of:................</p></strong></br>
						
						<center><table width="auto" border="1px black" height="auto" cellpadding="2px" cellspacing="2px" style="margin:2px 2px 2px 2px">
                            <tr>
								
								<th>Subject      </th>
								<th>B.O.T</th>
								<th>Mid Term</th>
								<th>End of Term</th>
								<th>Final Mark</th>
								<th>Grade</th>
								<th>Comment</th>
								<th>Teacher's Signature</th>
							</tr>
							 
						
							 
						</table></center></br>
                           <p>Class teacher's comment.........................................................................................................
						   .................................................................................................................................................</p>
						   <p>Head teacher's comment ........................................................................................................</p>
						   <p>Signature:.....................................................Stamp:.................................................................</p>
                           <p>Next Term begins on....................................And Ends on........................................................</p>						
							</div>
					</div>
					
	<div class="modal-footer"> 
				<button class="btn btn-primary" data-dismiss="modal"> Close</button> <!-- Closing button -->
	</div>

</div>	<!-- end of modal-content -->							  
</div>	<!-- end of modal-sm  div -->								  
</div>
			</div>
			

        
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/bootstrap-transition.js"></script>
		<script src="assets/js/bootstrap-alert.js"></script>
		<script src="assets/js/bootstrap-modal.js"></script>
		<script src="assets/js/bootstrap-dropdown.js"></script>
		<script src="assets/js/bootstrap-scrollspy.js"></script>
		<script src="assets/js/bootstrap-tab.js"></script>
		<script src="assets/js/bootstrap-tooltip.js"></script>
		<script src="assets/js/bootstrap-popover.js"></script>
		<script src="assets/js/bootstrap-button.js"></script>
		<script src="assets/js/bootstrap-collapse.js"></script>
		<script src="assets/js/bootstrap-carousel.js"></script>
		<script src="assets/js/bootstrap-typeahead.js"></script>


  
    <script type="text/javascript" src="assets/js/jquery.jshowoff.min.js"></script>
	<script type="text/javascript" src="assets/js/scriptbreaker-multiple-accordion-1.js"></script>
		<script language="JavaScript">

		$(document).ready(function() {
			$(".topnav").accordion({
				accordion:false,
				speed: 500,
				closedSign: '<img src="assets/img/minus.png">',
				openedSign: '<img src="assets/img/plus.png">'
			});
		});

		</script>

    <script type="text/javascript">		
        $(document).ready(function(){ $('#features').jshowoff(); });
    </script>
 <script type="text/javascript"> 

		function PrintElem(elem)
        {
        Popup($(elem).html());
        }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=auto,width=760');
        mywindow.document.write('<html><head><title>localhost<?php echo $_SERVER['PHP_SELF'];?></title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/print.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
			
</script>

    <script type="text/javascript" language="javascript" src="assets/js/jquery.carouFredSel-5.6.1.js"></script>
    <script type="text/javascript" language="javascript">
        $('#foo2').carouFredSel({
            prev: '#prev2',
            next: '#next2',
            pagination: "#pager2",
            auto: false
        });
    </script>
<link type="text/css" href="assets/js/themes/base/ui.all.css" rel="stylesheet" />  

<link type="text/css" href="assets/js/themes/base/ui.all.css" rel="stylesheet" />   
<script type="text/javascript" src="assets/js/ui/ui.core.js"></script>
<script type="text/javascript" src="assets/js/ui/ui.datepicker.js"></script>
<script type="text/javascript" src="assets/js/ui/i18n/ui.datepicker-id.js"></script>
    <script type="text/javascript"> 
      $(document).ready(function(){
        $("#tanggal").datepicker({
					dateFormat  : "dd MM yy",        
          changeMonth : true,
          changeYear  : true					
        });
      });
    </script>		
</body>
</html>

