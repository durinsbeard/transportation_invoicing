<?include('includes/connect.php');?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<link href="JS/jquery-ui.css" rel="stylesheet">
<link href="JS/dataTables.jqueryui.css" rel="stylesheet">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="JS/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="JS/jquery-ui.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
	/*var get_report = "<?echo $_GET["report"]?>";
	
	if(get_report == "customer_report"){
		$("#customer").val("<?echo $_GET["customer"]?>");
		
	}else if(get_report == "carrier_report"){
		$("#carrier").val("<?echo $_GET["carrier"]?>");	
	}
	
	$("apply").click(function(){
		<?unset($_GET["customer"])?>;
		<?unset($_GET["carrier"])?>;
		<?unset($_GET["invoice"])?>;
		<?unset($_GET["from"])?>;
		<?unset($_GET["to"])?>;
	});*/
	
	var post_customer = "<?echo $_POST["customer"]?>";
	var post_carrier = "<?echo $_POST["carrier"]?>";
	var post_invoice = "<?echo $_POST["invoice"]?>";
	var post_from = "<?echo $_POST["from"]?>";
	var post_to = "<?echo $_POST["to"]?>";
	var get_customer = "<?echo $_GET["customer"]?>";
	var get_carrier = "<?echo $_GET["carrier"]?>";
	var get_invoice = "<?echo $_GET["invoice"]?>";
	var get_from = "<?echo $_GET["from"]?>";
	var post_to = "<?echo $_POST["to"]?>";
	
	
	if(post_customer === ""){
		$("#customer").val("--Select Customer--");
	}else{
		$("#customer").val("<?echo $_POST["customer"]?>");
	}
	
	if(post_carrier === ""){
		$('#carrier').val("--Select Carrier--");
	}else{
		$("#carrier").val("<?echo $_POST["carrier"]?>");
	}
	
	if(post_invoice === ""){
		$('#invoice').val("Select Invoice #");
	}else{
		$("#invoice").val("<?echo $_POST["invoice"]?>");
	}
	
	if(post_from=== ""){
		$('#from').val("--Select Begin Date--");
	}else{
		$("#from").val("<?echo $_POST["from"]?>");
	}
	
	if(post_to === ""){
		$('#to').val("--Select End Date--");
	}else{
		$("#to").val("<?echo $_POST["to"]?>");
	}
	
	$(function(){
	   $( "#from" ).datepicker({
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly:true,
			buttonText: "Select begin date",
			showWeek: true,
			showOtherMonths: true,
			selectOtherMonths:false,
			dateFormat: "yy-mm-dd",
			showOn: "both"
		});
		$( "#to" ).datepicker({
			showOn: "button",
			buttonImage: "images/calendar.gif",
			buttonImageOnly:true,
			buttonText: "Select end date",
			showWeek: true,
			showOtherMonths: true,
			selectOtherMonths:false,
			dateFormat: "yy-mm-dd",
			showOn: "both"
		});
		$(document).tooltip();
	});

	$("#clear_values").click(function(){
		$('#customer').val("--Select Customer--");
		$('#carrier').val("--Select Carrier--");
		$('#invoice').val("Select Invoice #");
		$('#from').val("--Select Begin Date--");
		$('#to').val("--Select End Date--");
	});
	
	$("#tabs").tabs({
		"activate": function(event, ui){
			$( $.fn.dataTable.tables( true )).DataTable().columns.adjust();
		}	
	});
	
	$("table.display").dataTable({
		//"scrollY": "300px",
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
					<option >--Select Customer--</option>
					<?
						include('includes/connect.php');
						$sqlCustomers = "SELECT *  from customers
										 ORDER BY customer_name";
						$queryCustomers = mysql_query($sqlCustomers,$con);
						while($rowCustomers=mysql_fetch_array($queryCustomers))
						{
							?><option value="<?echo $rowCustomers['customer_id']?>"><?echo $rowCustomers['customer_name']?></option><?
						}             
					?>
				</select>
			</li>
			<li style="font-size:10px;">
				Carrier:
				<select name="carrier" id="carrier" >
					<option>--Select Carrier--</option>
					<?
						$sqlCarriers = "SELECT *  from carriers
										ORDER BY carrier_name";
							$queryCarriers = mysql_query($sqlCarriers,$con);
						while($rowCarriers=mysql_fetch_array($queryCarriers))
						{
							echo "<option value=".(string)$rowCarriers['carrier_id'].">".$rowCarriers['carrier_name']."</option>";
						}             
					?>
				</select>
			</li>
			<li style="font-size:10px;">
					Invoice #:
					<select name="invoice" id="invoice" >
					<option>Select Invoice #</option>
					<?
						$sqlInvoice = "SELECT DISTINCT statement_number  from dayton
									   WHERE statement_number <> 0	
									   ORDER BY statement_number";
							$queryInvoice = mysql_query($sqlInvoice,$con);
						while($rowInvoice=mysql_fetch_array($queryInvoice))
						{
							echo "<option value=".(string)$rowInvoice['statement_number'].">".$rowInvoice['statement_number']."</option>";
						}             
					?>
					</select>
			</li>
			<li style="font-size:10px;">
				Start Date:
				<input type="text" name="from" id="from" value="--Select Start Date--"/>
				
			</li>
			<li style="font-size:10px;">
				End Date:
				<input type="text" name="to" id="to" value="--Select End Date--"/>
			</li>
		 </ul>
		<center>
			<table>
				<tr>
					<td>
						<input id="clear_values" type="button" value="CLEAR" class="wide" style="margin-top:10px;"/>
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
	<div id="tabs-1" style="border:none;">
		<?
		if(isset($_REQUEST['customer']) 
		|| $_REQUEST['customer'] != "--Select Customer--" 
	    && $_REQUEST['carrier']=="--Select Carrier--" 
		&& $_REQUEST['invoice']=="Select Invoice #" 
		&& !$_REQUEST['status'] 
		&& $_REQUEST['from'] == "--Select Begin Date--" 
		&& $_REQUEST['to'] == "--Select End Date--"){
			include("Reporting/reports/customer_report.php");
		}else if (isset($_GET['carrier']) || $_POST['customer'] =="--Select Customer--" && $_POST['carrier'] !="--Select Carrier--" && $_POST['invoice']=="Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/reports/carrier_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['carrier'] != "Select Carrier" && $_POST['invoice']=="Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/reports/customer_carrier_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/reports/customer_carrier_invoice_report.php");
		}else if ($_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['customer']=="--Select Customer--" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/reports/carrier_invoice_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['invoice'] != "Select Invoice #" && $_POST['carrier']=="--Select Carrier--" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/reports/customer_invoice_report.php");
		}else if ($_POST['customer']=="--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] != "--Select Begin Date--" && $_POST['to'] != "--Select End Date--"){
			include("Reporting/reports/carrier_invoice_date_report.php");
		}else if ($_POST['customer']!="--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] != "--Select Begin Date--" && $_POST['to'] != "--Select End Date--"){
			//include("Reporting/reports/customer_carrier_invoice_date_report.php");
		}
		?>
	</div>
	<div id="tabs-2">
		<?
		if(isset($_GET['customer']) || $_POST['customer'] != "--Select Customer--" && $_POST['carrier']=="--Select Carrier--" && $_POST['invoice']=="Select Invoice #" && !$_POST['status'] && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/approved/customer_report.php");
		}else if ($_POST['customer'] =="--Select Customer--" && $_POST['carrier'] !="--Select Carrier--" && $_POST['invoice']=="Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/approved/carrier_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['carrier'] != "Select Carrier" && $_POST['invoice']=="Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/approved/customer_carrier_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/approved/customer_carrier_invoice_report.php");
		}else if ($_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['customer']=="--Select Customer--" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/approved/carrier_invoice_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['invoice'] != "Select Invoice #" && $_POST['carrier']=="--Select Carrier--" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/approved/customer_invoice_report.php");
		}else if ($_POST['customer']=="--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] != "--Select Begin Date--" && $_POST['to'] != "--Select End Date--"){
			include("Reporting/approved/carrier_invoice_date_report.php");
		}else if ($_POST['customer']!="--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] != "--Select Begin Date--" && $_POST['to'] != "--Select End Date--"){
			include("Reporting/approved/customer_carrier_invoice__date_report .php");
		}
		?>
	</div>
	<div id="tabs-3">
		<?if(isset($_GET['customer']) || $_POST['customer'] != "--Select Customer--" && $_POST['carrier']=="--Select Carrier--" && $_POST['invoice']=="Select Invoice #" && !$_POST['status'] && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/rejected/customer_report.php");
		}else if ($_POST['customer'] =="--Select Customer--" && $_POST['carrier'] !="--Select Carrier--" && $_POST['invoice']=="Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/rejected/carrier_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['carrier'] != "Select Carrier" && $_POST['invoice']=="Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/rejected/customer_carrier_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/rejected/customer_carrier_invoice_report.php");
		}else if ($_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['customer']=="--Select Customer--" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/rejected/carrier_invoice_report.php");
		}else if ($_POST['customer'] != "--Select Customer--" && $_POST['invoice'] != "Select Invoice #" && $_POST['carrier']=="--Select Carrier--" && $_POST['from'] == "--Select Begin Date--" && $_POST['to'] == "--Select End Date--"){
			include("Reporting/rejected/customer_invoice_report.php");
		}else if ($_POST['customer']=="--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] != "--Select Begin Date--" && $_POST['to'] != "--Select End Date--"){
			include("Reporting/rejected/carrier_invoice_date_report.php");
		}else if ($_POST['customer']!="--Select Customer--" && $_POST['carrier'] != "--Select Carrier--" && $_POST['invoice'] != "Select Invoice #" && $_POST['from'] != "--Select Begin Date--" && $_POST['to'] != "--Select End Date--"){
			include("Reporting/rejected/customer_carrier_invoice_date_report.php");
		}
		?>
	</div>
</div>
