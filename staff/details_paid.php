
<!-----------------------------------------------Advance Search Form Modal --------------------------------------------------->
<div id="detailfee" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
<h3 id="myModalLabel">Specify Details</h3>
</div>

<div class="modal-body">
    <form class="form-horizontal" method="post" action="feepaid.php">
	
	          <div class="control-group">
		      <label class="control-label" for="inputEmail">Class:</label>
			  <div class="controls">
			    <select name="class" class="input focused" id="focusedInput" required="required"  >
								<option value="" > >> Select Class  << </option>
								<option value="Baby " >Baby class </option>
								<option value="Top " > Top Class</option>
								<option value="Primary one" > Primary one </option>
								<option value="Primary two" > Primary two</option>
								<option value="Primary three" > Primary three</option>
								<option value="Primary four" > Primary four</option>
								<option value="Primary five" > Primary five</option>
								<option value="Primary six" > Primary Six</option>
								<option value="Primary seven" > Primary Seven</option>
							   </select>
			  
		      </div>
	          </div>
				 <div class="control-group">
		      <label class="control-label" for="inputEmail">Term:</label>
			  <div class="controls">
			 <select name="term" class="input focused" id="focusedInput" required="required"  >
								<option value="" > >> Select Term << </option>
								<option value="one" > Term One</option>
								<option value="two" > Term Two</option>
								<option value="three" > Term Three</option>
								
							    </select>
			  
		      </div>
	          </div>			
			
			  	 <div class="control-group">
		      <label class="control-label" for="inputEmail">Year:</label>
			  <div class="controls">
			   <select name="year" class="input focused" id="focusedInput" required="required"  >
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
			 
		      </div>
	          </div>		  			
			  
												
                <div class="control-group">
                <div class="controls">
                <button type="submit" id="search" data-placement="left" title="Click to Search" class="btn btn-primary"><i class="icon-search"></i> Submit</button>
				 <script type="text/javascript">
		        $(document).ready(function(){
		        $('#search').tooltip('show');
		        $('#search').tooltip('hide');
		        });
		        </script> 
                </div>
                </div>
				
    </form>
</div>

<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i> Close</button>
</div>
</div>