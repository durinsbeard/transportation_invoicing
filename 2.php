<?
include('includes/connect.php');

?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="JS/jquery-ui.css" rel="stylesheet">
<link href="JS/dataTables.jqueryui.css" rel="stylesheet">
<script src="JS/jquery-ui.js" type="text/javascript"></script>
<script src="JS/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
var line_items = [];
$(document).ready(function(){
	jQuery.fn.multiselect = function(){
		$(this).each(function(){
			var checkboxes = $(this).find("input:checkbox");
			checkboxes.each(function(){
				var checkbox = $(this);
				// Highlight pre-selected checkboxes
				if (checkbox.prop("checked")){
					checkbox.parent().addClass("multiselect-on");
				}
				// Highlight checkboxes that the user selects
				checkbox.click(function(){
					if (checkbox.prop("checked")){
							checkbox.parent().addClass("multiselect-on");
							var val = $(this).val();
					}else{
						
						checkbox.parent().removeClass("multiselect-on");
						checkbox.removeProp("checked");
						var val = $(this).val();
						var remove = val.substr(val.indexOf("_") + 1);
						line_items = jQuery.grep(line_items, function(value){
                          return value != remove;
						});
						
					}
					
				});
			});
		});
	}
    $(function(){
		 $(".multiselect").multiselect();
	});
	
	$('#clear_values').click(function(){
			$('#customer').val('');
			$('#carrier').val('');
			$('#invoice').val('');
			$('#to').val('');
			$('#from').val('');
	});
	
	$(function(){
	   $("#from").datepicker({
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly:true,
			buttonText: "Select begin date",
			showWeek: true,
			showOtherMonths: true,
			selectOtherMonths:false,
			showOn: "both",
			dateFormat: "yy-mm-dd"
		});
		$("#to").datepicker({
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly:true,
			buttonText: "Select end date",
			showWeek: true,
			showOtherMonths: true,
			selectOtherMonths:false,
			showOn: "both",
			dateFormat: "yy-mm-dd"
		});
		$(document).tooltip();
	});
  	
	$("#tabs").tabs({
		"activate": function(event, ui){
			$( $.fn.dataTable.tables( true )).DataTable().columns.adjust();
		}	
	});
	
	$("#tabs").bind("tabsactivate", function (event, ui){
		if(ui.newTab.index() == 0){
			$("#invoice_selected").show();
			$("#invoice_all").show();
			$("#approve_selected").show();
			$("#approve_all").show();
		}
		if(ui.newTab.index() == 1){
			$("#invoice_selected").hide();
			$("#invoice_all").hide();
			$("#approve_selected").show();
			$("#approve_all").show();
		}
		if(ui.newTab.index() == 2){
			$("#approve_selected").hide();
			$("#approve_all").hide();
			$("#invoice_selected").show();
			$("#invoice_all").show();
		}
	    if(ui.newTab.index() == 3){
			$("#invoice_selected").hide();
			$("#invoice_all").hide();
			$("#approve_selected").hide();
			$("#approve_all").hide();
			$("#clear_all").hide();
		}
		
	});

	$('#invoice_selected').click(function(){
		$("input[type=checkbox]").each(function (){
				var val = $(this).val();
				var myString = val.substr(val.indexOf("_") +1)
					if($(this).parent().hasClass('multiselect-on')){
						if(val.indexOf("apv") >= 0){
							alert("You have selected a rejected item to invoice.");
							exit;
						}else{
							line_items.push(myString);
						}
					}
				
		});
			if(line_items != ""){
				window.open("invoice.php?invoice_items="+ line_items+"",'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
			}else{
				alert("You must make a selection.");
			}
	});
	
	$('#invoice_all').click(function(){
		var inv_items = [];
		$("input[type=checkbox]").each(function (){
				var val = $(this).val();
				var myString = val.substr(val.indexOf("_") +1)
				
				if(val.indexOf("inv") >= 0){
					$(this).prop('checked',true);
					$(this).parent().addClass("multiselect-on");
					line_items.push(myString);
					
				}
				
		});
			
			window.open("invoice.php?invoice_items="+ line_items+"",'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
	});
	
	$('#approve_selected').click(function(){
		$("input[type=checkbox]").each(function (){
				var val = $(this).val();
				var myString = val.substr(val.indexOf("_") +1)
					if($(this).parent().hasClass('multiselect-on')){
						if(val.indexOf("inv") >= 0){
							alert("You an item that has already been approved.");
							exit;
						}else{
							line_items.push(myString);
						}
					}
				
		});
			if(line_items != ""){
				window.open("approve.php?approve_items="+ line_items+"",'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
			}else{
				alert("You must make a selection.");
			}
	});
	
	$('#approve_all').click(function(){
		var aprv_items = [];
		$("input[type=checkbox]").each(function (){
				var val = $(this).val();
				var myString = val.substr(val.indexOf("_") +1)
				if(val.indexOf("apv") >= 0){
					this.checked = true;
					$(this).parent().addClass("multiselect-on");
					aprv_items.push(myString);
				}
				
		});
			
			window.open("approve.php?approve_items="+ aprv_items+"",'Ratting','width=1024,height=768,top=300,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
	});
	
	$('#clear_all').click(function(){
		$("input[type=checkbox]").each(function (){
			$(this).prop('checked',false);
			$(this).parent().removeClass("multiselect-on");
			line_items = [];
				
		});
			
			
	});
	
	$("table.display").dataTable({
	    //"scrollY": "600px",
		"scrollCollapse": true,
		"paging": false,
		"jQueryUI": true
	});
	
	var table = $('#example'String).DataTable( {
		buttons: [
		'copy'String, 'excel'String, 'pdf'String
		]
	});
	
}); 
</script>
<center>
<form name="report_form" id="report_form" action="<?echo $_SERVER['PHP_SELF'];?>" method="post" style="margin-top:10px;">
<div id="selections">
		<ul id="navlist">
			<li id="active" style="font-size:10px;">
				Customer:
				<select name="customer" id="customer" >
					
				<?if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
					$sqlCustomer = "SELECT * from customers
								    WHERE customer_id = '".$_REQUEST['customer']."'";
					$queryCustomer = mysql_query($sqlCustomer,$con);
					$rowCustomer=mysql_fetch_array($queryCustomer);
					 ?><option value="<?echo $rowCustomer['customer_id']?>"><?echo $rowCustomer['customer_name']?></option><?
					$sqlCustomers = "SELECT * from customers
									 WHERE customer_id != '".$customer."'
									 ORDER BY customer_name";
						$queryCustomers = mysql_query($sqlCustomers,$con);
						while($rowCustomers=mysql_fetch_array($queryCustomers))
						{
							 ?><option value="<?echo $rowCustomers['customer_id']?>"><?echo $rowCustomers['customer_name']?></option><?
						}  
				}else{
					echo "<option value='NULL'>--Select Customer--</option>";
					$sqlCustomers = "SELECT * from customers
									 ORDER BY customer_name";
					$queryCustomers = mysql_query($sqlCustomers,$con);
					while($rowCustomers=mysql_fetch_array($queryCustomers))
					{
						 ?><option value="<?echo $rowCustomers['customer_id']?>"><?echo $rowCustomers['customer_name']?></option><?
					}  
				}
				?>
				</select>
			</li>
			<li style="font-size:10px;">
				Carrier:
				<select name="carrier" id="carrier" >
				<?if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
					$sqlCarrier = "SELECT * from carriers
								   WHERE carrier_id = '".$_REQUEST['carrier']."'";
					$queryCarrier = mysql_query($sqlCarrier,$con);
					$rowCarrier=mysql_fetch_array($queryCarrier);
					 ?><option value="<?echo $rowCarrier['carrier_id']?>"><?echo $rowCarrier['carrier_name']?></option><?
					$sqlCarriers = "SELECT * from carriers 
									WHERE carrier_id != '".$carrier."'
									ORDER BY carrier_name";
						$queryCarriers = mysql_query($sqlCarriers,$con);
						while($rowCarriers=mysql_fetch_array($queryCarriers))
						{
							?><option value="<?echo $rowCarriers['carrier_id']?>"><?echo $rowCarriers['carrier_name']?></option><?
						}  
				}else{
					echo '<option value="NULL">--Select Carrier--</option>';
					$sqlCarriers = "SELECT * from carriers
									ORDER BY carrier_name";
					$queryCarriers = mysql_query($sqlCarriers,$con);
					while($rowCarriers=mysql_fetch_array($queryCarriers)){
							?><option value="<?echo $rowCarriers['carrier_id']?>"><?echo $rowCarriers['carrier_name']?></option><?
					}  
				}
				?>
				</select>
			</li>
			<li style="font-size:10px;">
				Invoice #:
				<select name="invoice" id="invoice" >
				<?if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
					$sqlInvoice = "SELECT statement_number
								   FROM dayton
                                   WHERE statement_number = '".$_REQUEST['invoice']."'";
					$queryInvoice = mysql_query($sqlInvoice,$con);
					$rowInvoice=mysql_fetch_array($queryInvoice);
					 ?><option value="<?echo $rowInvoice['statement_number']?>"><?echo $rowInvoice['statement_number']?></option><?
					$sqlInvoices = "SELECT DISTINCT statement_number
									FROM dayton
									WHERE statement_number != '".$_REQUEST['invoice']."'
									ORDER BY statement_number";
						$queryInvoices = mysql_query($sqlInvoices,$con);
						while($rowInvoices=mysql_fetch_array($queryInvoices))
						{
							?><option value="<?echo $rowInvoices['statement_number']?>"><?echo $rowInvoices['statement_number']?></option><?
						}
				}else{
					?><option value="NULL">Select Invoice #</option><?
					$sqlInvoices = "SELECT DISTINCT statement_number 
									FROM dayton
									ORDER BY statement_number";
					$queryInvoices = mysql_query($sqlInvoices,$con);
					while($rowInvoices=mysql_fetch_array($queryInvoices)){
							?><option value="<?echo $rowInvoices['statement_number']?>"><?echo $rowInvoices['statement_number']?></option><?
							
					}  
				}
				?>
				</select>
			</li>
			<li style="font-size:10px;">
				From:
				<input type="text" name="from" id="from" value="--Select Begin Date--"/>
			</li>
			<li style="font-size:10px;">
				To:
				<input type="text" name="to" id="to" value="--Select End Date--"/>
			</li>
		 </ul>
		<center>
			<fieldset id="button_field_set" class="button_field_set">
						<input style="float:left" id="clear_values" name="clear_values" type="submit" value="CLEAR" class="wide" style="margin-top:10px;"/>
					
						<input style="float:right"id="apply" name="apply" id="apply" type="submit" value="SUBMIT" class="wide" style="margin-top:10px;"/>
			</fieldset>
		</center>
	<div>
		</form>
  
</center>
<div id="tabs" class="report_data"  style="border:none;">
	<ul class="report_data" style="height:30px;">
		<li><a href="#tabs-1">All</a></li>
		<li><a href="#tabs-2">Rejected</a></li>
		<li><a href="#tabs-3">Approved</a></li>
		<li><a href="#tabs-4">Invoiced</a></li>
		
	</ul>
	<div id="tabs-1">
	<?
		
		
		$sqlStrt = "SELECT DISTINCT line_item_id,
									carrier_name,
									status,
									customer_name,
									statement_number,
									invoice_date,
									thedata.customer_id,
									thedata.carrier_id,
									shipper_name, 
									shipper_state, 
									consignee_name, 
									consignee_state, 
									weight, 
									gross_amount, 
									BOL 
					FROM dayton as thedata";
	
		//All Shipments
		//finish the query based on user choices.
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlAll = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							AS car ON thedata.carrier_id = car.carrier_id
			                LEFT JOIN 
			                (SELECT customer_id, customer_name FROM customers) 
			                AS cust ON thedata.customer_id = cust.customer_id
			                WHERE thedata.customer_id ='".$customer."'";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
							     ON mm.customer_id = cust.customer_id
								 WHERE mm.customer_id = '".$customer."'
								 AND mm.carrier_id IS NULL";
			}else{
					$sqlAll = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
		
				if ($customer == "NULL"){
				$sqlAll = " LEFT JOIN (SELECT customer_name, customer_id FROM customers) 
							AS cust ON thedata.customer_id = cust.customer_id
			                LEFT JOIN 
			                (SELECT carrier_id, carrier_name FROM carriers) 
			                AS car ON thedata.carrier_id = car.carrier_id
			                WHERE thedata.carrier_id ='".$carrier."'";
				
				$sqlGetMinMax = "SELECT * FROM min_max AS mm
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
							     ON mm.carrier_id = car.carrier_id
								 WHERE mm.carrier_id = '".$carrier."'
								 AND mm.customer_id IS NULL";
				}else{
				$sqlAll = "";
				$sqlAll = " INNER JOIN (SELECT customer_id,carrier_id FROM carriers_customers) as cc
							 ON cc.customer_id = '".$customer."' 
							 AND cc.carrier_id = '".$carrier."'
							 LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							 AS car ON thedata.carrier_id = car.carrier_id
			                 LEFT JOIN 
			                 (SELECT customer_id, customer_name FROM customers) 
			                 AS cust ON thedata.customer_id = cust.customer_id
							 WHERE thedata.customer_id = '".$customer."' 
							 AND thedata.carrier_id = '".$carrier."'";
				
				$sqlGetMinMax = "SELECT * FROM min_max AS mm
								 LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								 AS car ON mm.carrier_id = car.carrier_id
								 LEFT JOIN 
								 (SELECT customer_id, customer_name FROM customers) 
								 AS cust ON mm.customer_id = cust.customer_id
								 WHERE mm.carrier_id = '".$carrier."'
							     AND mm.customer_id = '".$customer."'";
                }
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
				$invoice = $_REQUEST['invoice'];
				if ($sqlAll == ""){
					$sqlAll = " WHERE thedata.statement_number = '".$invoice."'";
					
				}else{
					$sqlAll .=  " AND thedata.statement_number = '".$invoice."'";
					
				}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Select Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--Select End Date--" && strlen($_REQUEST['to']) > 0){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				if ($sqlAll == ""){
					$sqlAll = " WHERE thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				}else{
					$sqlAll .= " AND thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				} 
			
		}
	if ($sqlAll != ""){
		
		$sqlAllFinal = $sqlStrt ." ". $sqlAll;
		
		display_table($sqlAllFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,1);
		//echo $sqlAllFinal;
		
	}
	?>	
	</div>
	<div id="tabs-2">
		<?//Rejected Shipments
		 //finish the query based on user choices.
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlRej = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
							AS mm on thedata.customer_id = mm.customer_id 
							AND thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight
							OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price
				            LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							AS cc ON thedata.carrier_id = cc.carrier_id
			                LEFT JOIN 
			                (SELECT customer_id, customer_name FROM customers) 
			                AS cust ON thedata.customer_id = cust.customer_id
			                WHERE thedata.customer_id = '".$customer."'
							AND thedata.status <> 2
							AND mm.customer_id = '".$customer."'
							AND mm.carrier_id IS NULL";
			}else{
					$sqlRej = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
		
				if ($customer == "NULL"){
					$sqlRej = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								AS mm on thedata.carrier_id = mm.carrier_id 
								AND thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight
								OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price
								LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								AS cc ON thedata.carrier_id = cc.carrier_id
								LEFT JOIN 
								(SELECT customer_id, customer_name FROM customers) 
								AS cust ON thedata.customer_id = cust.customer_id
								WHERE thedata.carrier_id = '".$carrier."'
								AND thedata.status <> 2
								AND mm.carrier_id = '".$carrier."'
								AND mm.customer_id IS NULL";
							
				}else{
					$sqlRej = "";
					$sqlRej = " INNER JOIN min_max as mm
								ON thedata.customer_id = mm.customer_id
								AND thedata.carrier_id = mm.carrier_id
								AND  thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight 
							    OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price
								LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								AS car ON thedata.carrier_id = car.carrier_id
								LEFT JOIN 
								(SELECT customer_id, customer_name FROM customers) 
								AS cust ON thedata.customer_id = cust.customer_id
								WHERE thedata.customer_id = '".$customer."'
								AND thedata.status <> 2
								AND mm.customer_id = '".$customer."'
								AND thedata.carrier_id= '".$carrier."'
								AND mm.carrier_id= '".$carrier."'";
							    
				}
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
				$invoice = $_REQUEST['invoice'];
				if ($sqlRej == ""){
					$sqlRej = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								AS mm thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight
								OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price
					            WHERE thedata.statement_number = '".$invoice."'
								AND thedata.status <> 2";
					
				}else{
					$sqlRej .=  " AND thedata.statement_number = '".$invoice."'";
					
				}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Select Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--Select End Date--" && strlen($_REQUEST['to']) > 0){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				if ($sqlRej == ""){
					$sqlRej = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								AS mm thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight
								OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price 
								WHERE thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'
								AND thedata.status <> 2";
					
				}else{
					$sqlRej .= " AND thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				} 
		}
	if ($sqlRej!= ""){
	
		$sqlRejFinal = $sqlStrt ." ". $sqlRej;
		display_table($sqlRejFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,2);
	    //echo $sqlRejFinal;
	}
	?>
			
	</div>
	<div id="tabs-3">
		<?//Approved Shipments
		 //finish the query based on user choices.
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlAprvd= " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
							 AS mm on thedata.customer_id = mm.customer_id 
							 AND thedata.weight BETWEEN mm.min_weight AND mm.max_weight
							 AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
							 LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							 AS cc ON thedata.carrier_id = cc.carrier_id
							 LEFT JOIN 
							 (SELECT customer_id, customer_name FROM customers) 
							 AS cust ON thedata.customer_id = cust.customer_id
							 WHERE thedata.customer_id = '".$customer."'
							 AND mm.carrier_id IS NULL";
				
			}else{
					$sqlAprvd = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
		
				if ($customer == "NULL"){
					$sqlAprvd = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								  AS mm on thedata.carrier_id = mm.carrier_id 
								  AND thedata.weight BETWEEN mm.min_weight AND mm.max_weight
								  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
								  LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								  AS cc ON thedata.carrier_id = cc.carrier_id
								  LEFT JOIN (SELECT customer_id, customer_name FROM customers) 
								  AS cust ON thedata.customer_id = cust.customer_id
								  WHERE thedata.carrier_id = '".$carrier."'
								  AND mm.customer_id IS NULL
								  AND thedata.status = 0 OR thedata.status = 2";
				}else{
					$sqlAprvd = "";
					$sqlAprvd = " INNER JOIN min_max as mm
								  ON thedata.customer_id = mm.customer_id
								  AND thedata.carrier_id = mm.carrier_id
								  AND  thedata.weight BETWEEN mm.min_weight AND mm.max_weight 
								  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
								  LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								  AS car ON thedata.carrier_id = car.carrier_id
			                      LEFT JOIN 
			                      (SELECT customer_id, customer_name FROM customers) 
			                      AS cust ON thedata.customer_id = cust.customer_id
								  WHERE thedata.customer_id= '".$customer."'
								  AND thedata.carrier_id= '".$carrier."'
								  AND thedata.status = 0 OR thedata.status = 2";
		        }
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
				$invoice = $_REQUEST['invoice'];
				if ($sqlAprvd == ""){
					$sqlAprvd = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								  AS mm thedata.weight BETWEEN mm.min_weight AND mm.max_weight
								  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
					              WHERE thedata.statement_number = '".$invoice."'
								  AND thedata.status = 0 OR thedata.status = 2";
				}else{
					$sqlAprvd .=  " AND thedata.statement_number = '".$invoice."'";
				}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Select Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--Select End Date--" && strlen($_REQUEST['to']) > 0){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				if ($sqlAprvd == ""){
					$sqlAprvd = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								  AS mm thedata.weight BETWEEN mm.min_weight AND mm.max_weight
								  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price 
								  WHERE thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'
								  AND thedata.status = 0 OR thedata.status = 2";
					
				}else{
					$sqlAprvd .= " AND thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				} 
		}
	if ($sqlAprvd != ""){
		$sqlAprvdFinal = $sqlStrt ." ". $sqlAprvd;
		display_table($sqlAprvdFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,3);
	    //echo $sqlAprvdFinal;
	}
	?>
	</div>
	<div id="tabs-4">
		<?//Approved Shipments
		 //finish the query based on user choices.
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlInv= " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
						   AS mm on thedata.customer_id = mm.customer_id 
						   LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
						   AS cc ON thedata.carrier_id = cc.carrier_id
						   LEFT JOIN 
						   (SELECT customer_id, customer_name FROM customers) 
						   AS cust ON thedata.customer_id = cust.customer_id
						   WHERE thedata.customer_id = '".$customer."'
						   AND thedata.status = 1
						   AND mm.carrier_id IS NULL";
				
			}else{
					$sqlInv = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
		
				if ($customer == "NULL"){
					$sqlInv = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								AS mm on thedata.carrier_id = mm.carrier_id 
								LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								AS cc ON thedata.carrier_id = cc.carrier_id
								LEFT JOIN (SELECT customer_id, customer_name FROM customers) 
								AS cust ON thedata.customer_id = cust.customer_id
								WHERE thedata.carrier_id = '".$carrier."'
								AND thedata.status = 1
								AND mm.customer_id IS NULL";
								  
				}else{
					$sqlInv = "";
					$sqlInv = " INNER JOIN min_max as mm
								ON thedata.customer_id = mm.customer_id
								AND thedata.carrier_id = mm.carrier_id
								LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
								AS car ON thedata.carrier_id = car.carrier_id
			                    LEFT JOIN 
			                    (SELECT customer_id, customer_name FROM customers) 
			                    AS cust ON thedata.customer_id = cust.customer_id
								WHERE thedata.customer_id= '".$customer."'
								AND thedata.carrier_id= '".$carrier."'
								AND thedata.status = 1";
		        }
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
				$invoice = $_REQUEST['invoice'];
				if ($sqlInv == ""){
					$sqlInv = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								AS mm thedata.weight BETWEEN mm.min_weight AND mm.max_weight
								AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
					            WHERE thedata.statement_number = '".$invoice."'
								AND thedata.status = 1";
				}else{
					$sqlInv .=  " AND thedata.statement_number = '".$invoice."'";
				}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Select Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--Select End Date--" && strlen($_REQUEST['to']) > 0){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				if ($sqlInv == ""){
					$sqlInv = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								AS mm thedata.weight BETWEEN mm.min_weight AND mm.max_weight
								AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price 
								WHERE thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'
								AND thedata.status = 1";
					
				}else{
					$sqlInv .= " AND thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				} 
		}
	if ($sqlInv != ""){
		$sqlInvFinal = $sqlStrt ." ". $sqlInv;
		display_table($sqlInvFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,4);
	    //echo $sqlInvFinal;
	}
	?>
	</div>
</div>

<div style="margin-right:25%;margin-left:25%">
	<input style="float: left; margin: 0px 3px 5px 0px;height:20px;width:100px;"  id="invoice_selected"  
	type="button" src=""  title="invoice selected" value="INVOICE SELECTED" class="wide"/>
	

	<input style="float: left; margin: 0px 3px 5px 0px;height:20px;width:100px;"  id="invoice_all"  
	type="button" value="INVOICE ALL" class="wide"/>
	

	<input style="float: left; margin: 0px 3px 5px 0px;height:20px;width:100px;" id="approve_selected"  
	type="button" value="APPROVE SELECTED" class="wide"/>
	

	
	<input style="float: left; margin: 0px 3px 5px 0px;height:20px;width:100px;"  id="approve_all"  
	type="button" value="APPROVE ALL" class="wide"/>
	
	
	<input style="float: left; margin: 0px 3px 5px 0px;height:20px;width:75px;"  id="clear_all"  
	type="button" value="CLEAR ALL" class="wide"/>
</div>
<?
function display_table($sql_statement,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,$tab){
		include('includes/connect.php');
		$sql=$sql_statement;
		$findMinMax = mysql_query($sqlGetMinMax,$con);
		$foundMinMax = mysql_fetch_array($findMinMax);
		//echo $sqlGetMinMax;
		$query = mysql_query($sql,$con);
		$getNames = mysql_fetch_array($findMinMax);
		if (mysql_num_rows($query) <> 0){
			?>
			<center>
			<?
			if (mysql_num_rows($findMinMax) <> 0){
				if($customer != "NULL"){
					if (mysql_num_rows($findMinMax) <> 0){
							echo "Customer:<b><font style='color:#8A084B;font-style:italic;'>".$foundMinMax['customer_name']."
							      </font></b><img src='images/imageedit_1_5599377889.gif' style='vertical-align: text-bottom'> ";
					}
				}
				if($carrier != "NULL"){
					if (mysql_num_rows($findMinMax) <> 0){
						echo "Carrier:<b><font style='color:#8A084B;font-style:italic;'>".$foundMinMax['carrier_name']."
							  </font></b><img src='images/imageedit_1_5599377889.gif' style='vertical-align: text-bottom'>";
					}
				}
				echo "Price Threshold:<b><font style='color:#8A084B;font-style:italic;'>$".
				      $foundMinMax['min_price']  ."<>$".$foundMinMax['max_price'].
				      "</font></b><img src='images/imageedit_1_5599377889.gif' style='vertical-align: text-bottom'>
				      Weight Threshold:<b><font style='color:#8A084B;font-style:italic;'>"
				     .$foundMinMax['min_weight']."lbs<>".$foundMinMax['max_weight']."lbs</b></font>";
			}
			?>
			</center>
			<table width="100%" class="display" id="example" cellspacing="0" >
				<thead>
					<tr>
						<th style="font-size:10px;">
							Invoice # <?echo $tab;?>
						</th>
						<th style="font-size:10px;">
							Customer
						</th>
						<th style="font-size:10px;">
							Carrier
						</th>
						<th style="font-size:10px;">
							Date
						</th>
						<th style="font-size:10px;">
							Shipper Name
						</th>
						<th style="font-size:10px;">
							Shipper State
						</th>
						<th style="font-size:10px;">
							Consignee Name
						</th>
						<th style="font-size:10px;">
							Consignee State
						</th>
						<th style="font-size:10px;">
							Weight
						</th>
						<th style="font-size:10px;">
							Gross Amount
						</th>
						<th style="font-size:10px;">
							BOL #
						</th>
						<th style="font-size:10px;">
							<div id="status">
								Status
							</div>
						</th>
						<th style="font-size:10px;" id="procss_all">
							<div id="status">
								Process
							</div>
						</th>
					</tr>
				</thead>
				<?
				while($row=mysql_fetch_array($query)){	
				?>
					<tr>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<a style="display:block;" href="#" title="view"
							onClick=window.open('line_item_information.php?line_item=<?echo $row['line_item_id']?>','Ratting','width=550,height=600,0,status=0,');window.focus();>
								<?echo $row['statement_number']?>
							</a>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
							<?echo strtolower($row['customer_name'])?>
						</td >
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
							<?echo strtolower($row['carrier_name'])?>
						</td >
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
							<?echo $row['invoice_date']?>
						</td >
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<?echo strtolower($row['shipper_name'])?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<?echo $row['shipper_state']?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;font-size:10px;">
							<?echo strtolower($row['consignee_name'])?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<?echo strtolower($row['consignee_state'])?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<?
							if (mysql_num_rows($findMinMax) <> 0){
								if($row["status"] == 0){
									if ($row["weight"] < $foundMinMax["min_weight"] || $row["weight"] > $foundMinMax["max_weight"]){
										$weight = "<font style='color:red;'>".$row['weight']."lbs</font>".$row["line_item_id"];
										
									}else{
										$weight = $row['weight']."lbs";
									}
								}
								if($row["status"] == 1 || $row["status"] == 2){
									$weight = $row['weight']."lbs";
								}
							}else{
								$weight = $row['weight']."lbs";
							}
									
							
							echo $weight;
							?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
							<?
							
							if (mysql_num_rows($findMinMax) <> 0){
								if($row["status"] == 0){
									if ($row["gross_amount"] < $foundMinMax["min_price"] || $row["gross_amount"] > $foundMinMax["max_price"]){
										$amount = "<font style='color:red;'>$".$row['gross_amount'];
										
									}else{
										$amount = "$".$row['gross_amount'];
									}
								}
								if($row["status"] == 1 || $row["status"] == 2){
									$amount = "$".$row['gross_amount'];
								}
							}else{
								$amount = "$".$row['gross_amount'];
							}
							echo $amount;
							?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
							<?echo $row['BOL']?>
						</td>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
							<?	
							if (mysql_num_rows($findMinMax) <> 0){
								if($row["status"]==0){
									if($row["gross_amount"] < $foundMinMax["min_price"] || $row["gross_amount"] > $foundMinMax["max_price"] 
										|| $row["weight"] < $foundMinMax["min_weight"] || $row["weight"] > $foundMinMax["max_weight"]){
										
											  $status ="<font style='color:red'>Rejected</font>";
											  $process="<div class='multiselect process' name='approve_line_items' id='approve_line_items' style='margin-left:-5px'>
														<label id='approve' style='display: block;padding-left:15px;text-indent:-15px;font-size:10px;cursor:pointer;'>
														<input type='checkbox' name='approved_items[]' id='approved_items' style='opacity:0;position:absolute;' value='apv_".$row['line_item_id']."'
														style='width:20px;height:20px;padding:0;margin:0;vertical-align:bottom;
														position:relative;top:-1px*overflowhidden;border:solid .5px;'/>
														<img src='images/approve_item.png'>
														</label>
														</div>";
								
									}else{
									$status ="<font style='color:green'>Approved</font>";
									$process="<div class='multiselect process' name='invoice_line_items' id='invoice_line_items' style='margin-left:-5px'>
											  <label id='invoice' style='display: block;padding-left:15px;text-indent:-15px;font-size:10px;cursor:pointer;'>
											  <input type='checkbox' name='invoiced_items[]' id='invoice_items' style='opacity:0;position:absolute;' value='inv_".$row['line_item_id']."'
											  style='width:20px;height:20px;padding:0;margin:0;vertical-align:bottom;
											  position:relative;top:-1px*overflowhidden;border:solid .5px;'/>
											  <img src='images/invoice_item.png'>
											  </label>
											  </div>";
									}
								}
								if ($row["status"] == 1){
									$status = "<font style='color:grey;'>Invoiced</font>";
									$process="<img src='images/1438012034_mail.png'>";
								}
								if ($row["status"] == 2){
									$status ="<font style='color:green'>Approved</font>";
									$process="<div class='multiselect process' name='invoice_line_items' id='invoice_line_items' style='margin-left:-5px'>
											  <label id='invoice' style='display: block;padding-left:15px;text-indent:-15px;font-size:10px;cursor:pointer;'>
											  <input type='checkbox' name='invoiced_items[]' id='invoice_items' style='opacity:0;position:absolute;' value='inv_".$row['line_item_id']."'
											  style='width:20px;height:20px;padding:0;margin:0;vertical-align:bottom;
											  position:relative;top:-1px*overflowhidden;border:solid .5px;'/>
											  <img src='images/invoice_item.png'>
											  </label>
											  </div>";
								}
								
							}else{
								$status = "<font style='color:black;'><b>No Rules Applied</b><font>";
								$process="";
							}
							echo $status;
							
							?>
						</td >
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:50px;">
							<?echo $process."------".$row["status"];?>
						</td>
					</tr>
				<?
				}
			?>
				<tbody>
			</table>
			
		<?
		}else{
				echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:500px;margin-top:50px;'><center>No results.</center></div></center>";	
		}
				
    }	
?>