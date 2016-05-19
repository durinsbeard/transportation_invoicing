<?
include('includes/connect.php');
require('report_functions.php');
?>
<link href="css/dataTables.jqueryui.css" rel="stylesheet">
<link href="css/dataTables.foundation.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/jquery.dataTables.css" rel="stylesheet">
<link href="css/buttons.dataTables.min.css" rel="stylesheet">

<script src="js/jquery-ui.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/dataTables.buttons.min.js " type="text/javascript"></script>
<script src="js/jszip.min.js" type="text/javascript"></script>
<script src="js/pdfmake.min.js" type="text/javascript"></script>
<script src="js/vfs_fonts.js " type="text/javascript"></script>
<script src="js/buttons.html5.min.js" type="text/javascript"></script>
<script src="js/buttons.jqueryui.js" type="text/javascript"></script>
<script src="js/buttons.jqueryui.min.js" type="text/javascript"></script>
<script src="js/buttons.print.js" type="text/javascript"></script>
<script src="js/buttons.print.min.js" type="text/javascript"></script>


<script>
var line_items = [];

$.fn.dataTable.ext.buttons.approve = {
	className: 'approve',
	action: function (e,dt,node,config ){
		//alert(ui.newTab.index());
		//alert(this.text());
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1);
			if($(this).parent().hasClass("multiselect-on")){
				line_items.push(myString);
			}
		});
		if(line_items != ""){
			$("#aprv_dialog").dialog("open");
			$("#aprv_line_items").val(line_items);
		}else{
			alert("Please make a selection to appprove");
		}
	}
};

$.fn.dataTable.ext.buttons.invoice = {
	className: 'invoice',
	action: function (e,dt,node,config ){
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1);
			if($(this).parent().hasClass("multiselect-on")){
				line_items.push(myString);
			}
		});
		if(line_items != ""){
			$("#inv_dialog").dialog("open");
			$("#inv_line_items").val(line_items);
		}else{
			alert("Please make a selection to invoice");
		}
	}
};

/*function format ( d ) {
	// `d` is the original data object for the row
	return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
		'<tr>'+
			'<td>Full name:</td>+
			'<td>'+d.name+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td>Extension number:</td>'+
			'<td>'+d.extn+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td>Extra info:</td>'+
			'<td>And any further details here (images etc)...</td>'+
		'</tr>'+

    '</table>';

}*/



$(document).ready(function(){
	
	$(window).load(function(){
        $('.approve').show();
		$('.approve').css('background','#CEF6CE');
		$('.invoice').hide();
	});

    /*var table = $('#example'String).DataTable({
		"ajax"String: "../ajax/data/objects.txt",
		"columns": [
		{
			"className":      'details-control',
			"orderable":      false,
			"data":           null,
			"defaultContent": ''String
		},
			{ "data": "name"},
			{ "data": "position"},
			{ "data": "office"},
			{ "data": "salary"}
		],
			"order": [[1, 'asc']]

    });

	 Add event listener for opening and closing details
	$('#example tbody').on('click', 'td.details-control', function(){
		var tr = $(this).closest('tr');
		var row = table.row( tr );

		if( row.child.isShown() ){
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else{
			// Open this row
			row.child( format(row.data()) ).show();
			tr.addClass('shown');
		}
	});
	/*Page load--------------------------------------------*/
	//$("#service_charge").mask("$");
	$("#invoice_selected").hide();
	$("#invoice_all").hide();

	
	$("table.display").dataTable({
	    //"scrollY": "600px",
		"aoColumnDefs":[
			{'bSortable': false, 'aTargets': [14]}
		],
		"scrollCollapse": true,
		"paging": false,
		"jQueryUI": true,
		dom: "Bfrtip",
		buttons:[
            'excelHtml5',
			'pdfHtml5',
			'print',
			{
				extend: 'approve',
				text: 'Pass'
			},
			{
				extend: 'invoice',
				text: 'Invoice'
			}
		],
		
	});
	/*End Page Load-----------------------------------------*/
	
	/*Tabs-----------------------------------------------*/
	$("#tabs").tabs({
		activate: function(event, ui){
			
			if(ui.newTab.index() == "0"){
				$('.approve').hide();
				$('.invoice').hide();
			}
			if(ui.newTab.index() == "1"){
				$('.approve').show();
				$('.approve').css('background','#CEF6CE');
				$('.invoice').hide();
			}
			if(ui.newTab.index() == "2"){
				$('.approve').hide();
				$('.invoice').show();
				$('.invoice').css('background','#CEF6CE');
			}
			if(ui.newTab.index() == "3"){
				$('.approve').hide();
				$('.invoice').hide();
			}
		}
	});
	/*End Tabs------------------------------------------------*/
	
	/*Date Picker---------------------------------------------*/
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
	/*End Datepicker--------------------------------------------- */
  	
	/*Checkboxes-------------------------------------------------*/
	$.fn.multiselect = function(){
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
					}else{
						checkbox.parent().removeClass("multiselect-on");
						line_items =[];
					}
						
				});
			});
		});
	};
    
	$(function(){
		 $(".multiselect").multiselect();
	});
	
	$("#approve").change(function(){
		
	});
	
	
	
	$("#approve_all_checkbox").change(function(){
		//var aprv_items = [];
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1)
			if($(this).parent().hasClass("multiselect-on")){
				this.checked = false;
				$(this).parent().removeClass("multiselect-on");
				line_items =[];
			}else{
				if(val.indexOf("apv") >= 0){
					this.checked = true;
					$(this).parent().addClass("multiselect-on");
					//alert('hello');
					//aprv_items.push(myString);
				}
			}
		});
	});
	
	$("#invoice_all_checkbox").change(function(){
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1)
			if($(this).parent().hasClass('multiselect-on')){
				this.checked = false;
				$(this).parent().removeClass("multiselect-on");
				line_items =[];
			}else{
				if(val.indexOf("inv") >= 0){
					this.checked = true;
					$(this).parent().addClass("multiselect-on");
					//aprv_items.push(myString);
				}
			}
		});
	});
	/*End Checkboxes----------------------------------------------- -*/

	/*Processing----------------------------------------------------*/
	/*$("#approve_button").click(function(){
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1);
			if($(this).parent().hasClass("multiselect-on")){
				line_items.push(myString);
			}
		});
		if(line_items != ""){
			$("#aprv_dialog").dialog("open");
			$("#aprv_line_items").val(line_items);
		}else{
			alert("Please make a selection to appprove");
		}
	});*/
	
	/*$("#invoice_button").click(function(){
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1);
			if($(this).parent().hasClass("multiselect-on")){
				line_items.push(myString);
			}
		});
		if(line_items != ""){
			$("#inv_dialog").dialog("open");
			$("#inv_line_items").val(line_items);
		}else{
			alert("Please make a selection to invoice");
		}
	});*/
	
	$("#clear_report_values").click(function(){
	    $("#customer").val('');
		$("#carrier").val('');
		$("#invoice").val('');
		$("#from").val("--Begin Date--");
		$("#to").val("--End Date--");
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
		
	$("#add").click(function(){
		//alert("Hi there");
		var service_charge = $("#service_charge").val();
		//var name = $("#name").val();
		//var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		if (service_charge === '') {
		alert("Please fill in service charge");
		e.preventDefault();
		}else{
			$("#dialog").dialog("close");
			$("#service_charge").val('');
			window.open("create_invoice_pdf.php?invoice_items="+ line_items+"&service_charge="+ service_charge,'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
			$("#inv_form").submit();
		}
	});
	
	$("#aprv_cancel").click(function(e){
		$("#aprv_dialog").dialog("close");
	});
	
	$("#inv_cancel").click(function(e){
		$("#inv_dialog").dialog("close");
		$("#service_charge").val('');
	});
	
	jQuery("#no_charge").click(function(e){
		jQuery("#dialog").dialog("close");
		window.open("create_invoice_pdf.php?invoice_items="+ line_items+"&service_charge=0",'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
		
	});
	
	$("#clear_all").click(function(){
		$("input[type=checkbox]").each(function (){
			$(this).prop('checked',false);
			$(this).parent().removeClass("multiselect-on");
			line_items = [];
		});
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
						while($rowCustomers=mysql_fetch_array($queryCustomers)){
							 ?><option value="<?echo $rowCustomers['customer_id']?>"><?echo $rowCustomers['customer_name']?></option><?
						}  
				}else{
					echo "<option value='NULL'>--Select Customer--</option>";
					$sqlCustomers = "SELECT * from customers
									 ORDER BY customer_name";
					$queryCustomers = mysql_query($sqlCustomers,$con);
					while($rowCustomers=mysql_fetch_array($queryCustomers)){
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
						while($rowCarriers=mysql_fetch_array($queryCarriers)){
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
						while($rowInvoices=mysql_fetch_array($queryInvoices)){
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
				<?
				if(isset($_REQUEST['from'])){
					echo '<input type="text" name="from" id="from" style="width:75px" value="'.$_REQUEST['from'].'"/>';
				}else{
					echo '<input type="text" name="from" id="from" style="width:75px"value="--Begin Date--"/>';
				}
				?>
			</li>
			<li style="font-size:10px;">
				To:
				<?
				if(isset($_REQUEST['to'])){
					echo '<input type="text" name="to" id="to" style="width:75px" value="'.$_REQUEST['to'].'"/>';
				}else{
					echo '<input type="text" name="to" id="to" style="width:75px"  value="--End Date--"/>';
				}
				?>
			</li>
		 </ul>
		<center>
			<fieldset id="button_field_set" class="button_field_set">
				<input style="float:left" id="clear_report_values" name="clear_values" type="submit" value="CLEAR" class="wide" style="margin-top:10px;"/>
				<input style="float:right"id="apply" name="apply" id="apply" type="submit" value="RUN REPORT" class="wide" style="margin-top:10px;"/>
			</fieldset>
		</center>
	<div>
		</form>
  
</center>
<div id="tabs" class="report_data"  style="border:none;">
	<ul class="report_data" style="height:30px;">
		<!--<li><a href="#tabs-1">All</a></li>-->
		<li><a href="#tabs-1">Pending Review</a></li>
		<li><a href="#tabs-2">Disputed</a></li>
		<li><a href="#tabs-3">Review & Approve</a></li>
		<li><a href="#tabs-4">Invoiced</a></li>
	</ul>
	<?
	$sqlStrt = "SELECT DISTINCT line_item_id,
								inv_id,
								pro_number,
								carrier_name,
								status,
								customer_name,
								invoice_date,
								thedata.customer_id,
								thedata.carrier_id,
								shipper_name, 
								shipper_state, 
								consignee_name, 
								consignee_state,
								pallets,
								weight, 
								gross_amount,
								BOL,
								invoice_date
				FROM dayton as thedata";
	?>
	<div id="tabs-1">
		<?//Approved Shipments
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlAprvd= " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							 AS car ON thedata.carrier_id = car.carrier_id
							 LEFT JOIN 
                             (SELECT customer_id, customer_name FROM customers) 
                             AS cust ON thedata.customer_id = cust.customer_id
							 WHERE thedata.customer_id ='".$customer."'
                             AND thedata.status=1
							 ORDER BY inv_id";
				
			}else{
					$sqlAprvd = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
			$carrier = $_REQUEST['carrier'];
		    if ($customer == "NULL"){
				              /*JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
							  AS mm on thedata.carrier_id = mm.carrier_id 
							  AND thedata.weight BETWEEN mm.min_weight AND mm.max_weight
							  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price*/
				$sqlAprvd = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							  AS cc ON thedata.carrier_id = cc.carrier_id
							  LEFT JOIN (SELECT customer_id, customer_name FROM customers) 
							  AS cust ON thedata.customer_id = cust.customer_id
							  WHERE thedata.carrier_id = '".$carrier."'
							  AND thedata.customer_id = 0
							  AND thedata.status = 1
							  ORDER BY inv_id";
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
							  AND thedata.status = 1
							  ORDER BY inv_id";
		    }
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
			$invoice = $_REQUEST['invoice'];
			if ($sqlAprvd == ""){
				$sqlAprvd = " LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                  ON thedata.carrier_id = car.carrier_id
			                  LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                  ON thedata.customer_id = cust.customer_id
			                  WHERE thedata.status = 2
							  AND thedata.statement_number = '".$invoice."'
							  ORDER BY inv_id";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id
								 ORDER BY inv_id";
			}else{
				$sqlAprvd .=  " AND thedata.statement_number = '".$invoice."'
								ORDER BY inv_id";
			}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--" && strlen($_REQUEST['to']) > 0){
			$begin_date = $_REQUEST['from'];
			$end_date = $_REQUEST['to'];
			if ($sqlAprvd == ""){
				
				$sqlAprvd = " LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                  ON thedata.carrier_id = car.carrier_id
			                  LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                  ON thedata.customer_id = cust.customer_id
			                  WHERE thedata.invoice_date BETWEEN '".$from."' AND '".$to."'
							  AND thedata.status = 1
							  ORDER BY inv_id";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id";
			}else{
				$sqlAprvd .= " AND thedata.invoice_date BETWEEN '".$from."' AND '" .$to."'
							   ORDER BY inv_id";
			} 
		}
	if ($sqlAprvd != ""){
		$sqlAprvdFinal = $sqlStrt ." ". $sqlAprvd;
		display_table($sqlAprvdFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,3);
	    //echo $sqlAprvdFinal;
	}
	?>
			
	</div>
	<div id="tabs-2">
		<?
		//Rejected Shipments
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlRej = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							AS car ON thedata.carrier_id = car.carrier_id
							LEFT JOIN 
                            (SELECT customer_id, customer_name FROM customers) 
                            AS cust ON thedata.customer_id = cust.customer_id
							WHERE thedata.customer_id ='".$customer."'
							AND thedata.status = 0
							ORDER BY inv_id";
							
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
							     ON mm.customer_id = cust.customer_id
								 WHERE mm.customer_id = '".$customer."'
								 AND mm.carrier_id = 0";
			}else{
					$sqlRej = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
		
				if ($customer == "NULL"){
					$sqlRej = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							    AS car ON thedata.carrier_id = car.carrier_id
							    LEFT JOIN 
							    (SELECT customer_id, customer_name FROM customers) 
							    AS cust ON thedata.customer_id = cust.customer_id
							    WHERE thedata.carrier_id ='".$carrier."'
								AND thedata.status = 0
								ORDER BY inv_id";
					
					$sqlGetMinMax = "SELECT * FROM min_max AS mm
									 LEFT JOIN 
									 (SELECT carrier_id,carrier_name from carriers) as car
									 ON mm.carrier_id = car.carrier_id
									 WHERE mm.carrier_id = '".$carrier."'
									 AND mm.customer_id = 0";
							
				}else{
					$sqlRej = "";
					$sqlRej =  " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							     AS car ON thedata.carrier_id = car.carrier_id
							     LEFT JOIN 
							     (SELECT customer_id, customer_name FROM customers) 
							     AS cust ON thedata.customer_id = cust.customer_id
							     WHERE thedata.customer_id = '".$customer."'
							     AND thedata.carrier_id= '".$carrier."'
							     AND thedata.status = 0
								 ORDER BY inv_id";
					
					$sqlGetMinMax = "SELECT * FROM min_max AS mm
									 LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
									 AS car ON mm.carrier_id = car.carrier_id
									 LEFT JOIN 
									 (SELECT customer_id, customer_name FROM customers) 
									 AS cust ON mm.customer_id = cust.customer_id
									 WHERE mm.carrier_id = '".$carrier."'
									 AND mm.customer_id = '".$customer."'
									 AND thedata.status = 0";
							    
				}
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
				$invoice = $_REQUEST['invoice'];
				if ($sqlRej == ""){
					$sqlRej = " LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                    ON thedata.carrier_id = car.carrier_id
			                    LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                    ON thedata.customer_id = cust.customer_id
			                    WHERE thedata.status = 0
							    AND thedata.statement_number = '".$invoice."'
								ORDER BY inv_id";
		
					$sqlGetMinMax = "SELECT * FROM min_max as mm
									 LEFT JOIN 
									 (SELECT customer_id,customer_name from customers) as cust
									 ON mm.customer_id = cust.customer_id
									 LEFT JOIN 
									 (SELECT carrier_id,carrier_name from carriers) as car
									 ON mm.carrier_id = car.carrier_id";
									
					
				}else{
					$sqlRej .=  " AND thedata.statement_number = '".$invoice."'
								  ORDER BY inv_id";
					
				}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--" && strlen($_REQUEST['to']) > 0){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				if ($sqlRej == ""){
					$sqlRej = "LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                   ON thedata.carrier_id = car.carrier_id
			                   LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                   ON thedata.customer_id = cust.customer_id
			                   WHERE thedata.status = 0
							   AND thedata.invoice_date BETWEEN '".$from."' AND '".$to."'
							   ORDER BY inv_id";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id";
					
				}else{
					$sqlRej .= " AND thedata.invoice_date BETWEEN '".$from."' AND '" .$to."'
								 ORDER BY inv_id";
				} 
		}
	if($sqlRej!= ""){
		$sqlRejFinal = $sqlStrt ." ". $sqlRej;
		display_table($sqlRejFinal,$sqlGetMinMax,$customer,$carrier,$invoice,$to,$from,1);
	    //echo $sqlRejFinal;
	}
	?>
	</div>
	<div id="tabs-3">
		<?//Approved Shipments
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlAprvd= " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							 AS car ON thedata.carrier_id = car.carrier_id
							 LEFT JOIN 
                             (SELECT customer_id, customer_name FROM customers) 
                             AS cust ON thedata.customer_id = cust.customer_id
							 WHERE thedata.customer_id ='".$customer."'
                             AND thedata.status=2
							 ORDER BY inv_id";
				
			}else{
					$sqlAprvd = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
			$carrier = $_REQUEST['carrier'];
		    if ($customer == "NULL"){
				              /*JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
							  AS mm on thedata.carrier_id = mm.carrier_id 
							  AND thedata.weight BETWEEN mm.min_weight AND mm.max_weight
							  AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price*/
				$sqlAprvd = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							  AS cc ON thedata.carrier_id = cc.carrier_id
							  LEFT JOIN (SELECT customer_id, customer_name FROM customers) 
							  AS cust ON thedata.customer_id = cust.customer_id
							  WHERE thedata.carrier_id = '".$carrier."'
							  AND thedata.customer_id = 0
							  AND thedata.status = 2
							  ORDER BY inv_id";
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
							  AND thedata.status = 2
							  ORDER BY inv_id";
		    }
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
			$invoice = $_REQUEST['invoice'];
			if ($sqlAprvd == ""){
				$sqlAprvd = " LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                  ON thedata.carrier_id = car.carrier_id
			                  LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                  ON thedata.customer_id = cust.customer_id
			                  WHERE thedata.status = 2
							  AND thedata.statement_number = '".$invoice."'
							  ORDER BY inv_id";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id
								 ORDER BY inv_id";
			}else{
				$sqlAprvd .=  " AND thedata.statement_number = '".$invoice."'
								ORDER BY inv_id";
			}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--" && strlen($_REQUEST['to']) > 0){
			$begin_date = $_REQUEST['from'];
			$end_date = $_REQUEST['to'];
			if ($sqlAprvd == ""){
				
				$sqlAprvd = " LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                  ON thedata.carrier_id = car.carrier_id
			                  LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                  ON thedata.customer_id = cust.customer_id
			                  WHERE thedata.invoice_date BETWEEN '".$from."' AND '".$to."'
							  AND thedata.status = 2
							  ORDER BY inv_id";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id";
			}else{
				$sqlAprvd .= " AND thedata.invoice_date BETWEEN '".$from."' AND '" .$to."'
							   ORDER BY inv_id";
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
		if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL"){
			$customer = $_REQUEST['customer'];
			if ($carrier == "NULL"){
				$sqlInv= " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
						   AS car ON thedata.carrier_id = car.carrier_id
						   LEFT JOIN 
                           (SELECT customer_id, customer_name FROM customers) 
                           AS cust ON thedata.customer_id = cust.customer_id
						   WHERE thedata.customer_id ='".$customer."'
                           AND thedata.status=3
						   ORDER BY inv_id";
			}else{
				$sqlInv = "";
			}
		}
		if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
			$carrier = $_REQUEST['carrier'];
			if ($customer == "NULL"){
				$sqlInv = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							AS car ON thedata.carrier_id = car.carrier_id
							LEFT JOIN 
                            (SELECT customer_id, customer_name FROM customers) 
                            AS cust ON thedata.customer_id = cust.customer_id
							WHERE thedata.carrier_id ='".$carrier."'
                            AND thedata.customer_id= 0
                            AND thedata.status=3
							ORDER BY inv_id";
							  
			}else{
				$sqlInv = "";
				$sqlInv = " LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
							AS car ON thedata.carrier_id = car.carrier_id
							LEFT JOIN 
                            (SELECT customer_id, customer_name FROM customers) 
                            AS cust ON thedata.customer_id = cust.customer_id
							WHERE thedata.customer_id ='".$customer."'
                            AND thedata.carrier_id= '".$carrier."'
                            AND thedata.status=3
							ORDER BY inv_id";
			}
		}
		if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL" && strlen($_REQUEST['invoice']) > 0){
			$invoice = $_REQUEST['invoice'];
			if ($sqlInv == ""){
				$sqlInv = " LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                ON thedata.carrier_id = car.carrier_id
			                LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                ON thedata.customer_id = cust.customer_id
			                WHERE thedata.status = 3
							AND thedata.statement_number = '".$invoice."'
							ORDER BY inv_id";
				
							
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id";
			}else{
				$sqlInv .=  " AND thedata.statement_number = '".$invoice."'
							  ORDER BY inv_id";
			}  
		}
		if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--" && strlen($_REQUEST['from']) > 0
		&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--" && strlen($_REQUEST['to']) > 0){
			$begin_date = $_REQUEST['from'];
			$end_date = $_REQUEST['to'];
			if ($sqlInv == ""){
				
				$sqlInv = "   LEFT JOIN(SELECT carrier_id,carrier_name FROM carriers) as car
			                  ON thedata.carrier_id = car.carrier_id
			                  LEFT JOIN(SELECT customer_name,customer_id FROM customers)as cust
			                  ON thedata.customer_id = cust.customer_id
			                  WHERE thedata.status = 3
							  AND thedata.invoice_date BETWEEN '".$from."' AND '".$to."'
							  ORDER BY inv_id";
				
				$sqlGetMinMax = "SELECT * FROM min_max as mm
								 LEFT JOIN 
								 (SELECT customer_id,customer_name from customers) as cust
								 ON mm.customer_id = cust.customer_id
								 LEFT JOIN 
								 (SELECT carrier_id,carrier_name from carriers) as car
								 ON mm.carrier_id = car.carrier_id";
				
			}else{
				$sqlInv .= " AND thedata.invoice_date BETWEEN '".$from."' AND '".$to."'
							 ORDER BY inv_id";
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
<!--Approve form-->
<div id="aprv_dialog" title="ENTER NOTES FOR APPROVAL">
	<form id="aprv_form" action="submits/approve_submit.php" method="POST">
		<center>
			<textarea autofocus id="aprv_notes" name="aprv_notes" rows="15" cols="50"></textarea> 
		</center>
		</br>
		<center>
			<input type="hidden" id="aprv_line_items" name="aprv_line_items">
			<input type="hidden" id="customer_id" name="customer_id" value="<?echo $_REQUEST['customer']?>">
			<input type="hidden" id="carrier_id" name="carrier_id" value="<?echo $_REQUEST['carrier']?>">
			<input type="hidden" id="invoice_number" name="invoice_number" value="<?echo $_REQUEST['invoice']?>">
			<input type="hidden" id="begin_date" name="begin_date" value="<?echo $_REQUEST['from']?>">
			<input type="hidden" id="end_date" name="end_date" value="<?echo $_REQUEST['to']?>">
			<input id="approve" name="approve" type="button" value="APPROVE" style="font-size:8px;float:right;margin-right:100px" class="wide">
			<input id="aprv_cancel" type="button" value="CANCEL" style="font-size:8px;float:left;margin-left:100px;" class="wide">
		</center>
	</form>
</div>

<!--Invoice form-->
<div id="inv_dialog" title="INVOICE LINE ITEMS">
	<form id="inv_form" action="submits/invoice_submit.php" method="POST">
		<center>
			<table>
				<tr>
					<td>
						Service Charge:
					</td>
					<td>
						<input autofocus id="srv_chrg" name="srv_chrg" type="text" style="font-size:8px;" value="0">
					</td>
				</tr>
				<tr>
					<td>
						Admin Fee:
					</td>
					<td>
						<input  id="admin_fee" name="admin_fee" type="text" style="font-size:8px;" value="0"><br>
					</td>
				</tr>
				<tr>
					<td>
						Subscription Fee:
					</td>
					<td>
						<input  id="sub_fee" name="sub_fee" type="text" style="font-size:8px;" value="0">
					</td>
				</tr>
			</table>
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
				
			</ul>
		</center>
	</form>
</div>
<?

    	
?>