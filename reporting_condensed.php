<?include('includes/connect.php');?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="JS/jquery-ui.css" rel="stylesheet">
<link href="JS/dataTables.jqueryui.css" rel="stylesheet">
<script src="JS/jquery-ui.js" type="text/javascript"></script>
<script src="JS/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	
	$('#clear_values').click(function(){
		$('#customer').val('');
		$('#carrier').val('');
		$('#invoice').val('');
		$('#to').val('');
		$('#from').val('');
		
	});
	
	$(function(){
		$("#inv_dialog").dialog({
			autoOpen: false,
			maxWidth:400,
			width: 400,
			modal: true
		});
	});	
	
	$(function(){
		$("#aprv_dialog").dialog({
			autoOpen: false,
			maxWidth:500,
            maxHeight: 400,
            width: 500,
            height: 400,
			modal: true
		});
	});	
	
	$(function(){
	   $( "#from" ).datepicker({
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
		$( "#to" ).datepicker({
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
  
    $("#clear_values").click(function(){
		$('#report_form')[0].reset();
	});
	
	$("#tabs").tabs({
		"activate": function(event, ui){
			$( $.fn.dataTable.tables( true )).DataTable().columns.adjust();
		}	
	});
	
	$("table.display").dataTable({
	    //"scrollY": "600px",
		"scrollCollapse": true,
		"paging": false,
		"jQueryUI": true
	});
	
}); 
</script>

<center>
<form name="report_form" id="report_form" action="<?echo $_SERVER['PHP_SELF'];?>" method="post" style="margin-top:10px;">
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
								   FROM `dayton`
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
			<table>
				<tr>
					<td>
						<input id="clear_values" name="clear_values" type="submit" value="CLEAR" class="wide" style="margin-top:10px;"/>
					</td>
					<td>
						<input id="apply" name="apply" id="apply" type="submit" value="SUBMIT" class="wide" style="margin-top:10px;"/>
					</td>
				</tr>
			</table>
		</center>
		</form>
  
</center>
<div id="tabs" class="report_data" style="border:none;">
	<ul class="report_data" style="height:30px;">
		<li><a href="#tabs-1">All</a></li>
		<li><a href="#tabs-2">Approved</a></li>
		<li><a href="#tabs-3">Rejected</a></li>
	</ul>
	<div id="tabs-1">
	<?
		$sqlStrt = "SELECT DISTINCT 
				         line_item_id, 
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
							AS cc ON thedata.carrier_id = cc.carrier_id
			                LEFT JOIN 
			                (SELECT customer_id, customer_name FROM customers) 
			                AS cust ON thedata.customer_id = cust.customer_id
			                WHERE thedata.customer_id ='".$customer."'";
				
				$sqlGetMinMax = "SELECT * FROM min_max
								 WHERE customer_id = '".$customer."'
								 AND carrier_id IS NULL";
			}else{
					$sqlAll = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
		
				if ($customer == "NULL"){
				$sqlAll = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							AS cc ON thedata.carrier_id = cc.carrier_id
			                LEFT JOIN 
			                (SELECT customer_id, customer_name FROM customers) 
			                AS cust ON thedata.customer_id = cust.customer_id
			                WHERE thedata.carrier_id ='".$carrier."'";
				
				$sqlGetMinMax = "SELECT * FROM min_max
								 WHERE carrier_id = '".$carrier."'
								 AND customer_id IS NULL";
				}else{
				$sqlAll = "";
				$sqlAll = " INNER JOIN (SELECT customer_id,carrier_id FROM carriers_customers) as cc
							 ON cc.customer_id = '".$customer."' 
							 AND cc.carrier_id = '".$carrier."'
							 WHERE thedata.customer_id = '".$customer."' 
							 AND thedata.carrier_id = '".$carrier."'";
				
				$sqlGetMinMax = "SELECT * FROM min_max
								 WHERE carrier_id = '".$carrier."'
							     AND customer_id = '".$customer."'";
                
				
			
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
		
		display_table($sqlAllFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from);
		
	}
	?>		    
	</div>
	<div id="tabs-2">
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
							 AND mm.carrier_id = 0";
				
				$sqlGetMinMax = "SELECT * FROM min_max
								 WHERE customer_id = '".$customer."'
								 AND carrier_id = 0";
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
			                  LEFT JOIN 
			                  (SELECT customer_id, customer_name FROM customers) 
			                  AS cust ON thedata.customer_id = cust.customer_id
			                  WHERE thedata.carrier_id = '".$carrier."'
							  AND mm.customer_id = 0";
				
				$sqlGetMinMax = "SELECT * FROM min_max
								 WHERE carrier_id = '".$carrier."'
								 AND customer_id = 0";
				}else{
					$sqlAprvd = "";
					$sqlAprvd = " INNER JOIN min_max as mm
								  ON thedata.customer_id = mm.customer_id
								  AND thedata.carrier_id = mm.carrier_id
								  AND  thedata.weight BETWEEN mm.min_weight AND mm.max_weight 
								  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
								  WHERE thedata.customer_id= '".$customer."'
								  AND thedata.carrier_id= '".$carrier."'";
		            
					$sqlGetMinMax = "SELECT * FROM min_max
								     WHERE carrier_id = '".$carrier."'
									 AND customer_id = '".$customer."'";		
				}
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
				$invoice = $_REQUEST['invoice'];
				if ($sqlAprvd == ""){
					$sqlAprvd = " JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
								  AS mm thedata.weight BETWEEN mm.min_weight AND mm.max_weight
								  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
					              WHERE thedata.statement_number = '".$invoice."'";
					
					$sqlGetMinMax = "SELECT * FROM min_max'";
					 
					
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
								  WHERE thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
					
				}else{
					$sqlAprvd .= " AND thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				} 
		}
	if ($sqlAprvd != ""){
	
		$sqlAprvdFinal = $sqlStrt ." ". $sqlAprvd;
		display_table($sqlAprvdFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from);
	    //echo $sqlAprvdFinal;
	}
		
	?>
	</div>
	<div id="tabs-3">
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
							AND mm.customer_id = '".$customer."'
							AND mm.carrier_id 0";
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
							AND mm.carrier_id = '".$carrier."'
							AND mm.customer_id = 0";
							
				}else{
					$sqlRej = "";
					$sqlRej = " INNER JOIN min_max as mm
								ON thedata.customer_id = mm.customer_id
								AND thedata.carrier_id = mm.carrier_id
								AND  thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight 
							    OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price
								WHERE thedata.customer_id = '".$customer."'
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
					            WHERE thedata.statement_number = '".$invoice."'";
					
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
								WHERE thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
					
				}else{
					$sqlRej .= " AND thedata.invoice_date BETWEEN '".$begin_date."' AND " .$end_date."'";
				} 
		}
	if ($sqlRej!= ""){
	
		$sqlRejFinal = $sqlStrt ." ". $sqlRej;
		display_table($sqlRejFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from);
	    //echo $sqlRejFinal;
	}
	?>
		
	</div>
</div>
<?
function display_table($sql_statement,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from){
		
		include('includes/connect.php');
		$sql=$sql_statement;
		$findMinMax = mysql_query($sqlGetMinMax,$con);
		$foundMinMax = mysql_fetch_array($findMinMax);
		//echo $sqlGetMinMax;
		$query = mysql_query($sql,$con);
		
		if (mysql_num_rows($query) <> 0){
		?><table width="100%" class="display" id="example" cellspacing="0">
			<thead>
				<tr>
					<th style="font-size:10px;">
						Invoice Number<?echo $customer;?>
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
						<?
							if($sqlGetMinMax != "n/a"){
								$findMinMax = mysql_query($sqlGetMinMax,$con);
								$foundMinMax = mysql_fetch_array($findMinMax);
								if(mysql_num_rows($findMinMax) != 0){
									SWITCH($row['status']){
										case 0:
										case 2:
										case 3:
											$weight= $row['weight']."lbs";
											break;
										case 1:
											if($row['weight'] < $foundMinMax['min_weight'] || $row['weight'] > $foundMinMax['max_weight']){
												$weight="<font style='color:red;'>".$row['weight']."lbs</font>";
											}
											break;
									}
								}
							}else{
								$weight = $row['weight']."lbs";
							}
							echo $weight;
						?>
					</th>
					<th style="font-size:10px;">
						Gross Amount
					</th>
					<th style="font-size:10px;">
						BOL #
					</th>
					<th style="font-size:10px;">
						Status
					</th>
					<th>
						Process
					</th>
				</tr>
				</thead>
		<?
				
				while($row=mysql_fetch_array($query)){	
					if (mysql_num_rows($findMinMax) <> 0){
						if ($row["gross_amount"] < $foundMinMax["min_price"] || $row["gross_amount"] > $foundMinMax["max_price"]){
								$status = "<font style='color:red;'><b>Rejected</b><font>";
								$gross_amount = "<font style='color:red;'><b>$".$row['gross_amount']."</b></font>";
						}else if($row["weight"] < $foundMinMax["min_weight"] || $row["weight"] > $foundMinMax["max_weight"]){
								$status = "<font style='color:red;'><b>Rejected</b><font>";
								$weight = "<font style='color:red;'><b>".$row['weight']." lbs</b></font>";
								
						}else{
								$status = "<font style='color:green;'><b>Approved</b><font>";
								$gross_amount = "$".$row['gross_amount'];
								$weight = $row['weight']." lbs";
								
						}
					}else{
								$status = "<font style='color:black;'><b>No Rules Applied</b><font>";
								$gross_amount = "$".$row['gross_amount'];
								$weight = $row['weight']." lbs";
					}
				?>
				<tr>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
						<a style="display:block;" href="?form=line_item_information&report=carrier_report&line_item=<?echo$row['line_item_id']?>&carrier=<?echo $carrier?>" title="view">
							<?echo $row['statement_number']?>
						</a>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
						<?echo $row['customer_name']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
						<?echo $row['carrier_name']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:150px;">
						<?echo $row['invoice_date']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:350px;font-size:10px;">
						<?echo $row['shipper_name']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
						<?echo $row['shipper_state']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:350px;font-size:10px;">
						<?echo $row['consignee_name']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
						<?echo $row['consignee_state']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
						<?echo $weight?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
						<?echo $gross_amount?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
						<?echo $row['BOL']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
						<?echo $status?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
						
					</td >
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
<!--Approve form-->
<div id="aprv_dialog" title="Enter Reason for approval">
	<form id="aprv_form" action="submits/approve_submit.php" method="POST">
		<center>
			<textarea autofocus rows="15" cols="50">
			
			</textarea> 
		</center>
		</br>
		<center>
			<input type="hidden" id="aprv_line_items" name="aprv_line_items">
			<input type="hidden" id="customer_id" name="customer_id" value="<?echo $_REQUEST['customer']?>">
			<input type="hidden" id="carrier_id" name="carrier_id" value="<?echo $_REQUEST['carrier']?>">
			<input type="hidden" id="invoice_number" name="invoice_number" value="<?echo $_REQUEST['invoice']?>">
			<input type="hidden" id="begin_date" name="begin_date" value="<?echo $_REQUEST['from']?>">
			<input type="hidden" id="end_date" name="end_date" value="<?echo $_REQUEST['to']?>">
			<input id="approve" name="approve" type="submit" value="APPROVE" style="font-size:8px;float:right;margin-right:100px" class="wide">
			<input id="aprv_cancel" type="button" value="CANCEL" style="font-size:8px;float:left;margin-left:100px;" class="wide">
		</center>
	</form>
</div>

<!--Invoice form-->
<div id="inv_dialog" title="Add Service Charge">
	<form id="inv_form" action="submits/invoice_submit.php" method="POST">
		<center>
			<label>Service Charge:</label>
			<input autofocus id="service_charge" name="service_charge" type="text" style="font-size:8px;">
		</center>
		</br>
		<center>
			<input type="hidden" id="inv_line_items" name="inv_line_items">
			<input type="hidden" id="customer_id" name="customer_id" value="<?echo $_REQUEST['customer']?>">
			<input type="hidden" id="carrier_id" name="carrier_id" value="<?echo $_REQUEST['carrier']?>">
			<input type="hidden" id="invoice_number" name="invoice_number" value="<?echo $_REQUEST['invoice']?>">
			<input type="hidden" id="begin_date" name="begin_date" value="<?echo $_REQUEST['from']?>">
			<input type="hidden" id="end_date" name="end_date" value="<?echo $_REQUEST['to']?>">
			<ul style="list-style-type:none;margin:0;padding:0;display: inline-block;">
				<li>
					<input id="add" name="add" type="submit" value="ADD" style="font-size:8px;" class="wide">
				</li>
				<li>
					<input id="no_charge" name="no_charge" type="submit" value="NO SERVICE CHARGE" style="font-size:8px;" class="wide">
				</li>
				<li>
					<input id="inv_cancel" type="button" value="CANCEL" style="font-size:8px;" class="wide">
				</li>
			</ul>
		</center>
	</form>
</div>