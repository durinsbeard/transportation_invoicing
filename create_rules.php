<?include('includes/connect.php');?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="JS/jquery-ui.css" rel="stylesheet">
<link href="JS/dataTables.jqueryui.css" rel="stylesheet">
<script src="JS/jquery-ui.js" type="text/javascript"></script>
<script src="JS/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
function validate_form(){
	var select_rules = document.getElementById('select_rules').value;
	var min_price = document.getElementById('min_price').value;
	var max_price = document.getElementById('max_price').value;
	var min_weight = document.getElementById('min_weight').value;
	var max_weight = document.getElementById('max_weight').value;
	var customer_only = document.getElementById('customer_only').value;
	var carrier_only = document.getElementById('carrier_only').value;
	var customer = document.getElementById('customer').value;
	var carrier = document.getElementById('carrier').value;
	
	if (select_rules == 1){
		if (customer_only == "NULL"){
			alert("You must select a customer before proceeding.");
			return false;
		}else if (min_price == "" || max_price == "" || parseFloat(min_price) >= parseFloat(max_price) 
					|| parseFloat(max_price) <= parseFloat(min_price)){
			alert("The minimum and maximum price must be present and minimum price must be less than maximum price");
			
			return false;
		}else if (min_weight == "" || max_weight == "" || parseFloat(min_weight).toFixed(2) >= parseFloat(max_weight).toFixed(2) 
							|| parseFloat(max_weight) <= parseFloat(min_weight)){
			alert("The minimum and maximum weight must be present and the minimum weight must be less than the maximim weight");
			return false;
		}else{
			if (confirm("Are you sure you want to apply rules?")){
				return true;
			}else{
				return false;
			}
		}
	}else if (select_rules == 2){
		if (carrier_only == "NULL"){
			alert("You must select a carrier before proceeding.");
			return false;
		}else if (min_price == "" || max_price == "" || parseFloat(min_price) >= parseFloat(max_price) 
				 || parseFloat(max_price) <= parseFloat(min_price)){
			alert("The minimum and maximum price must be present and minimum price must be less than maximum price");
			return false;
		}else if (min_weight == "" || max_weight == "" || parseFloat(min_weight) >= parseFloat(max_weight) 
				  || parseFloat(max_price) <= parseFloat(min_price)){
			alert("The minimum and maximum weight must be present and the minimum weight must be less than the maximim weight");
			return false;
		}else{
			if (confirm("Are you sure you want to apply rules?")){
				return true;
			}else{
				return false;
			}
		}
	}else if (select_rules == 3){
		if (customer == "NULL"){
			alert("You must select a customer before proceeding.");
			return false;
		}else if(carrier == "NULL"){
			alert("You must select a carrier before proceeding.");
			return false;
		}else if (min_price == "" || max_price == "" || parseFloat(min_price) >= parseFloat(max_price) 
				 || parseFloat(max_price) <= parseFloat(min_price)){
			alert("The minimum and maximum price must be present and minimum price must be less than maximum price");
			return false;
		}else if (min_weight == "" || max_weight == "" || parseFloat(min_weight) >= parseFloat(max_weight) 
				  || parseFloat(max_price) <= parseFloat(min_price)){
			alert("The minimum and maximum weight must be present and the minimum weight must be less than the maximim weight");
			return false;
		}else{
			if (confirm("Are you sure you want to apply rules?")){
				return true;
			}else{
				return false;
			}
		}
	}
}

function get_value(radio_value){
	document.getElementById('select_rules').value = radio_value;
}
$(document).ready(function(){
	$("#cust_car_lab").css("font-weight", "bold");
	$("#cust_car_lab").css("font-size", "12px");
	$(".carrier_tr").hide();
	$(".customer_tr").hide();
	
	$("input[type=checkbox]").click(function (){
			var count=-1;
			$("input:checked").each(function (){
				count++;
				$("#num_states").val(count); 
		});
	});
	
	$("#customer_only").change(function (){
		if ($("#select_rules").val() == 1){
		   var customer=$(this).val();
		   var data_string = "customer="+ customer;
		   
		   $.ajax({
				type: "POST",
				url: "populate_values_if_dup.php",
				data:data_string,
				dataType: "json",
				success: function (data) //on recieve of reply
				{
				   //alert(data);
				   if (data != false){
						var min_weight = data[0],max_weight = data[1], min_val = data[2],max_val = data[3];
						//alert("There are existing rules for this customer.");
						
						$("#max_price").val(max_val);
						$("#min_price").val(min_val);
						$("#min_weight").val(min_weight);
						$("#max_weight").val(max_weight);
						$("#states").val(states);
						$("#carrier").prop("selected", function(){
							return this.defaultSelected;
						});

					}else{
						$("#max_price").val("");
						$("#min_price").val("");
						$("#min_weight").val("");
						$("#max_weight").val("");
				   }
				}
			});
		}
	});
	
	$("#carrier_only").change(function (){
		if ($("#select_rules").val() == 2){
		   var carrier=$(this).val();
		   var data_string = "carrier="+ carrier;
		   $.ajax({
				type: "POST",
				url: "populate_values_if_dup.php",
				data:data_string,
				dataType: "json",
				success: function (data) //on recieve of reply
				{
				  if (data != false){
						var min_weight = data[0],max_weight = data[1], min_val = data[2],max_val = data[3];
						//alert("There are existing rules for this customer.");
						$.each(data, function(index, value){
							//alert("INDEX: " + index + " VALUE: " + value);
						});
						$("#max_price").val(max_val);
						$("#min_price").val(min_val);
						$("#min_weight").val(min_weight);
						$("#max_weight").val(max_weight);
						
						
				   }else{
						$("#max_price").val("");
						$("#min_price").val("");
						$("#min_weight").val("");
						$("#max_weight").val("");
				   }
				}
			});
		}
	});
	
	jQuery.fn.multiselect = function(){
		$(this).each(function(){
			var checkboxes = $(this).find("input:checkbox");
			checkboxes.each(function(){
				var checkbox = $(this);
				// Highlight pre-selected checkboxes
				if (checkbox.prop("checked"))
					checkbox.parent().addClass("multiselect-on");
	 
				// Highlight checkboxes that the user selects
				checkbox.click(function(){
					if (checkbox.prop("checked"))
						checkbox.parent().addClass("multiselect-on");
					else
						checkbox.parent().removeClass("multiselect-on");
				});
			});
		});
	};

	$(function(){
		 $(".multiselect").multiselect();
	});
	
	$("#clear_states").click(function(){
		$("#num_states").val("");
		$("#shipper_state :checked").removeAttr("checked");
		$("#shipper_state label").parent().find("label").removeClass("multiselect-on");
	});
	
	$("#radiobutt input[type=radio]").each(function(val){
		$(this).click(function(){
			if(val==0){ //1st radiobutton
					//$('<option>').val('999').text('999').appendTo('#carrier);
					$("#shipper_state :checked").removeAttr("checked");
					$("#shipper_state label").parent().find('label').removeClass("multiselect-on");
					$("#max_price").val("");
					$("#min_price").val("");
					$("#min_weight").val("");
					$("#max_weight").val("");
					$("#num_states").val("");
					$("#customer").val("NULL");
					$("#carrier").val("NULL");
					$("#carrier_only").val("NULL");
					$("#cust_lab").css("font-weight", "bold");
					$("#cust_lab").css("font-size", "12px");
					$("#car_lab").css("font-weight", "normal");
					$("#car_lab").css("font-size", "10px");
					$("#cust_car_lab").css("font-weight", "normal");
					$("#cust_car_lab").css("font-size", "10px");
					$(".multiselect").css("display","none");
					$(".customer_tr").show();
					$(".carrier_tr").hide();
					$(".customer_carrier_tr").hide();
					$(".carrier_tr").hide();
					$("#message").hide();
					
			}
			else{
					$("#carrier").prop("selectedIndex",0);
					$("#carrier").removeAttr("disabled"); 
					$("#carrier").css("background-color", "#FAFAFA");
					$(".multiselect").css("display","block");
					
			}
			if(val==1){ //2nd radiobutton
					$("#shipper_state :checked").removeAttr("checked");
					$("#shipper_state label").parent().find('label').removeClass("multiselect-on");
					$("#max_price").val("");
					$("#min_price").val("");
					$("#min_weight").val("");
					$("#max_weight").val("");
					$("#num_states").val("");
					$("#customer").val("NULL");
					$("#customer_only").val("NULL");
					$("#carrier").val("NULL");
					$("#car_lab").css("font-weight", "bold");
					$("#car_lab").css("font-size", "12px");
					$("#cust_lab").css("font-weight", "normal");
					$("#cust_lab").css("font-size", "10px");
					$("#cust_car_lab").css("font-weight", "normal");
					$("#cust_car_lab").css("font-size", "10px");
					$(".carrier_tr").show();
					$(".customer_carrier_tr").hide();
					$(".customer_tr").hide();
					$("#message").hide();
			}else{
					$("#customer").removeAttr("disabled"); 
					$("#customer").css("background-color", "#FAFAFA");
			}
			if(val==2){ //3rd radiobutton
					$("#shipper_state :checked").removeAttr("checked");
					$("#shipper_state label").parent().find("label").removeClass("multiselect-on");
					$("#shipper_state :checked").removeAttr("checked");
					$("#shipper_state label").parent().find("label").removeClass("multiselect-on");
					$("#cust_car_lab").css("font-weight", "bold");
					$("#cust_car_lab").css("font-size", "12px");
					$("#car_lab").css("font-weight", "normal");
					$("#car_lab").css("font-size", "10px");
					$("#cust_lab").css("font-weight", "normal");
					$("#cust_lab").css("font-size", "10px");
					$("#max_price").val("");
					$("#min_price").val("");
					$("#min_weight").val("");
					$("#max_weight").val("");
					$("#customer").val("NULL");
					$("#customer_only").val("NULL");
					$("#carrier").val("NULL");
					$("#carrier_only").val("NULL");
					$(".customer_tr").hide();
					$(".carrier_tr").hide();
					$(".customer_carrier_tr").show();
					$("#message").hide();
			}
		});
	});

	
			
});
</script>
<?
if(isset($_GET['message']))
{
	if($_GET['message']==1){
		echo "<center>
					<div id='message'  style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:
					20px;font-family:arial;color:white;'><center>Successfully applied rules.</center></div>
			  </center>";	
	}else if($_GET['message']==2){
		echo "<center>
				<div id='message' style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;
				height:25px;font-size:20px;font-family:arial;'><center>There was an error submitting to information. Please contact support</center></div>
			  </center>";	
		
	}else if($_GET['message']==3){
		echo "<center>
					<div id='message'  style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;
					margin-top:50px;height:25px;font-size:20px;font-family:arial;color:white;'>
					<center>Successfully updated rules.</center>
					</div>
			  </center>";
	}
}
?>

</html>
	<input type="hidden" name="select_rules" id="select_rules" value="3">
	 <center>
		<span class="rules selection" id="radiobutt" style="margin-top:10px;">
			 <label id="cust_lab" style="margin-right:3px;color:#800000;font-weght:bold;">Create Universal Customer Rules</label><input type="radio" name="rad1" value="1" onclick="get_value(this.value)"/>
			 <label id="car_lab" style="margin-right:3px;margin-left:10px;color:#800000;font-weght:bold;">Create Universal Carrier Rules</label><input type="radio" name="rad1" value="2" onclick="get_value(this.value)"/>
			 <label id="cust_car_lab"style="margin-right:3px;margin-left:10px;color:#800000;font-weght:bold;">Create Customer and Carrier Specific Rules</label><input type="radio" name="rad1" value="3" checked="checked" onclick="get_value(this.value)"/>
		</span>
	</center>
	<center>
		<span class="display_rules" id="display_rules" style="margin-top:10px;display:none;">
			 
		</span>
	</center>
	
	<form id="create_rules" action="submits/submit_rules.php" method="post"> 
	<table class="contentTable" cellpadding="5">
	<tr class="customer_tr">
		<td style="text-align:center;border:1px solid;border-color:#A4A4A4;border-radius:5px;font-size:12px;" colspan="4">
			<h5 style="color:#800000;">Customer</h5>
		</td>
	</tr>
	<tr class="customer_tr" colspan="4" style="align:center">
		<td style="text-align:center;" colspan="4">
			<select name="customer_only" id="customer_only">
				<option value="NULL">--Select Customer--</option>
				
				<?
					
						$sqlCustomers = "SELECT *  from customers
										 ORDER BY customer_name";
						$queryCustomers = mysql_query($sqlCustomers,$con);
						while($rowCustomers=mysql_fetch_array($queryCustomers))
						{
							
							/*if($firstInitial!=substr(strtoupper($rowCustomers['customer_name']),0,1))	
							{
								echo '<optgroup label='. substr(strtoupper($rowCustomers['customer_name']),0,1).'>';
								if ($firstInitial != "")
								{
									echo "</optgroup>";
									
								}*/      
							echo "<option value=".(string)$rowCustomers['customer_id']." style='margin-left;2px;'>".$rowCustomers['customer_name']."</option>";
							$firstInitial=strtoupper(substr($rowCustomers['customer_name'],0,1));
							//}

							echo '</optgroup>';
										  
						}             
				?>
			</select>
		</td>
	</tr>
	<tr class="carrier_tr">
		<td style="text-align:center;border:1px solid;border-color:#A4A4A4;border-radius:5px;font-size:12px;" colspan="4">
			<h5 style="color:#800000;">Carrier</h5>
		</td>
	</tr>
	<tr class="carrier_tr">
		<td style="text-align:center;" colspan="4">
			<select name="carrier_only" id="carrier_only" >
				<option value="NULL">--Select Carrier--</option>
				<?
					$sqlCarriers = "SELECT *  from carriers
										  ORDER BY carrier_name";
						$queryCarriers = mysql_query($sqlCarriers,$con);
					while($rowCarriers=mysql_fetch_array($queryCarriers))
					{
						//Use strtoupper for consistent lettering.
						/*if($firstInitial!=substr(strtoupper($rowCarriers['carrier_name']),0,1))	
						{
							if ($firstInitial != "")
							{
								echo "</optgroup>";
								echo '<optgroup label='. substr(strtoupper($rowCarriers['carrier_name']),0,1).'>';
							}*/      
						echo "<option value=".(string)$rowCarriers['carrier_id'].">".$rowCarriers['carrier_name']."</option>";
						//$firstInitial=strtoupper(substr($rowCarriers['carrier_name'],0,1));
						//}

						echo '</optgroup>';
									  
					}             
				?>
			</select>
		</td>
	</tr>
	<tr class="customer_carrier_tr">
		<td style="text-align:center;border:1px solid;border-color:#A4A4A4;border-radius:5px;font-size:12px;" colspan="4">
			<h5 style="color:#800000;">Customer/Carrier</h5>
		</td>
	</tr>
	<tr  class="customer_carrier_tr">
		<td style="text-align:right;">
			Select Customer:
		</td>
		<td>
			<select name="customer" id="customer">
				<option value="NULL">--Select Customer--</option>
				
				<?
						$sqlCustomers = "SELECT *  from customers
										 ORDER BY customer_name";
						$queryCustomers = mysql_query($sqlCustomers,$con);
						while($rowCustomers=mysql_fetch_array($queryCustomers))
						{
							
							/*if($firstInitial!=substr(strtoupper($rowCustomers['customer_name']),0,1))	
							{
								echo '<optgroup label='. substr(strtoupper($rowCustomers['customer_name']),0,1).'>';
								if ($firstInitial != "")
								{
									echo "</optgroup>";
									
								}*/    
							echo "<option value=".(string)$rowCustomers['customer_id']." style='margin-left;2px;'>".$rowCustomers['customer_name']."</option>";
							//$firstInitial=strtoupper(substr($rowCustomers['customer_name'],0,1));
							//}

							echo '</optgroup>';
										  
						}             
				?>
			</select>
		</td>
	
		<td style="text-align:right;">
			Select Carrier:
		</td>
		<td>
			<select name="carrier" id="carrier">
				<option value="NULL">--Select Carrier--</option>
				<?
					$sqlCarriers = "SELECT *  from carriers
									ORDER BY carrier_name";
					$queryCarriers = mysql_query($sqlCarriers,$con);
					while($rowCarriers=mysql_fetch_array($queryCarriers))
					{
						//Use strtoupper for consistent lettering.
						/*if($firstInitial!=substr(strtoupper($rowCarriers['carrier_name']),0,1))	
						{
							if ($firstInitial != "")
							{*/
								//echo "</optgroup>";
								//echo '<optgroup label='. substr(strtoupper($rowCarriers['carrier_name']),0,1).'>';
							//}      
						echo "<option value=".(string)$rowCarriers['carrier_id'].">".$rowCarriers['carrier_name']."</option>";
						//$firstInitial=strtoupper(substr($rowCarriers['carrier_name'],0,1));
						//}
						echo '</optgroup>';
									  
					}             
				?>
			</select>
		</td>

	<tr>
		<td style="text-align:center;border:1px solid;border-color:#A4A4A4;border-radius:5px;font-size:12px;" colspan="4">
			<h5 style="color:#800000;">Cost Range</h5>
		</td>
	</tr>
	<tr>
		<td style="text-align:right;">
			Minimum Price Limit:
		</td >
		<td style="align:left;">
			<input type="number" name="min_price" id="min_price">
		</td>
		<td style="text-align:right;">
			Maximum Price Limit:
		</td>
		<td style="align:left;">
			<input type="number" name="max_price" id="max_price">
		</td>
	</tr>
	<tr>
		<td style="text-align:center;border:1px solid;border-color:#A4A4A4;border-radius:5px;font-size:12px;" colspan="4">
			<h5 style="color:#800000;">Weight Range</h5>
		</td>
	</tr>
	<tr>
		<td style="text-align:right;">
			Minimum Weight Limit:
		</td >
		<td style="align:left;">
			<input type="number" name="min_weight" id="min_weight">
		</td>
		<td style="text-align:right;">
			Maximum Weight Limit:
		</td>
		<td style="align:left;">
			<input type="number" name="max_weight" id="max_weight">
		</td>
	</tr>
	
	</table>
	<div class="multiselect states" name="shipper_state" id="shipper_state" style="margin-left:1%">
		<table style="vertical-align:top;">
			<thead>
				<tr>
					<th colspan="19" style="font-size:10px;color:#800000;">
						Select Applicable States
					</th>
				</tr>
			</thead>
			<tr>
			<?
				$sqlStates = "SELECT *  from states
							  ORDER BY state_nm";
				$queryStates = mysql_query($sqlStates,$con);
				
				while($rowStates=mysql_fetch_array($queryStates))
				{
					
					if($firstInitial!=substr(strtoupper($rowStates['state_nm']),0,1))
					{
						
						echo '<td style="border:1px solid;border-color:#D8D8D8;border-radius:5px;text-align:left;vertical-align:top;width:100px;height:150px;">
							  <label style="color:#800000;">
							  <b><font size="3px" >'. substr(strtoupper($rowStates['state_nm']),0,1).'</font></b>
							  </label>';
					}      
					?>
						<label style="display:block;padding-left:15px;text-indent:-15px;font-size:10px;cursor:pointer;">
						<input type="checkbox" name="states[]" id="states" style="opacity:0;position:absolute;" 
							   value="<?echo $rowStates['state_id']?>" style="width:8px;height:8px;padding:0;margin:0;vertical-align:bottom;
							   position:relative;top:-1px*overflowhidden;border:solid .5px;"/>
						<?echo $rowStates['state_nm']?>
						</label>
					<?
						$firstInitial=strtoupper(substr($rowStates['state_nm'],0,1));
						
				}
				?>
					</td>
			</tr>
			<tr>
				<th colspan="19" style="font-size:10px;">
					<input type="button" value="clear states" id="clear_states">
				</th>
			</tr>

		</table>
	</div>
			<input type="hidden" id="num_states" name="num_states" >
		
		<input id="apply" name="apply_rules" type="submit" value="APPLY RULES" class="wide" formaction="submits/submit_rules.php" onclick="return validate_form()" style="margin-left:44.5%;"/>
	
	</form>
