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

$.fn.dataTable.ext.buttons.pass = {
	className: 'pass',
	action: function (e,dt,node,config){
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
			alert("Please make a selection to pass");
		}
	}
};

$.fn.dataTable.ext.buttons.approve = {
	className: 'approve',
	action: function (e,dt,node,config){
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			var myString = val.substr(val.indexOf("_") +1);
			if($(this).parent().hasClass("multiselect-on")){
				line_items.push(myString);
			}
		});
		if(line_items != ""){
			$("#inv_line_items").val(line_items);
			$("#inv_form").submit();
			//$("#inv_dialog").dialog("open");
			
		}else{
			alert("Please make a selection to approve");
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
        $('.approve').hide();
		$('.pass').hide();
		$( "#kwrdtxt" ).prop( "disabled", true );
		$("#kwrdtxt").css('background-color', '#BDBDBD');
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
		"autoWidth": true,
		"aoColumnDefs":[
			{'bSortable': false, 'aTargets': [14]}
		],
		"scrollCollapse": true,
		"paging": false,
		"jQueryUI": true,
		dom: "Bfrtip",
		buttons:[
            'excelHtml5',
			//'pdfHtml5',
			'print',
			{
				extend: 'pass',
				text: 'Pass'
			},
			{
				extend: 'approve',
				text: 'Approve'
			}
		],
	});
	/*End Page Load-----------------------------------------*/
	
	/*Tabs-----------------------------------------------*/
	$("#tabs").tabs({
		activate: function(event, ui){
			
			if(ui.newTab.index() == "0"){
				$('.approve').hide();
				$('.pass').hide();
			}
			if(ui.newTab.index() == "1"){
				$('.pass').show();
				$('.pass').css('background','#CEF6CE');
				$('.approve').hide();
			}
			if(ui.newTab.index() == "2"){
				$('.approve').show();
				$('.pass').hide();
				$('.approve').css('background','#CEF6CE');
			}
			if(ui.newTab.index() == "3"){
				$('.approve').hide();
				$('.pass').hide();
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
			dateFormat: "dd-mm-yy"
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
			dateFormat: "dd-mm-yy"
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
	$("#clear_report_values").click(function(){
	    $("#customer").val('');
		$("#carrier").val('');
		$("#invoice").val('');
		$("#from").val("--Begin Date--");
		$("#to").val("--End Date--");
		$("#kwrds").val('');
		$("#kwrdtxt").val('');
		var uri = window.location.toString();
		if (uri.indexOf("&") > 0) {
			var clean_uri = uri.substring(0, uri.indexOf("&"));
			window.history.replaceState({}, document.title, clean_uri);
		}
		
	});
	
	/*$(function(){
		$("#inv_dialog").dialog({
			autoOpen: false,
			maxWidth:400,
			width: 400,
			modal: true
		});
	});*/	
	
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
	
	$("#approve").click(function(){
		var aprv_notes = $("#aprv_notes").val();
		if(aprv_notes == ""){
			alert("You must enter notes as to why you are approving this item.")
		}else{
			$("#aprv_form").submit();
		}
	});
	
	 $("#kwrds").change(function(){
		//var make=$(this).val();
		$( "#kwrdtxt" ).prop( "disabled", false );
		$( "#kwrdtxt" ).focus();
		$("#kwrdtxt").css("background-color", "white");
		
		/*$.ajax({
			 type: "POST",
			 url: "select_model.php",
			 data: {make: make},
			 cache: false,
			 success: function(html){
				//alert(html);
				$("#model").html(html);
			} 
		});*/
	});
	
	$("#kwrdtxt").focus(function(){
		$(this).select();
	});
		
	/*$("#add").click(function(){
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
	});*/
	
	$("#aprv_cancel").click(function(e){
		$("#aprv_dialog").dialog("close");
	});
	
	/*$("#inv_cancel").click(function(e){
		$("#inv_dialog").dialog("close");
		$("#service_charge").val('');
	});*/
	
	/*$("#no_charge").click(function(e){
		$("#dialog").dialog("close");
		window.open("create_invoice_pdf.php?invoice_items="+ line_items+"&service_charge=0",'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
		
	});*/
	
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
	<legend>Search Selections</legend>
	<fieldset style="border-radius:5px;">
		
		<ul id="navlist" style="margin-top:15px;margin-bottom:15px;">
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
				<?if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL"){
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
						echo '<input type="text" name="to" id="to" style="width:75px"  value="--End Date--"/></input>';
					}
				?>
			</li>
		 </ul>
	</fieldset>
	<legend style="margin-top:15px">Search Keywords</legend>
	<fieldset style="border-radius:5px;">
		
		<center>
		<ul id="navlist" style="margin-left:40%;margin-bottom:15px;">
			<li>
				<select  id="kwrds" name="kwrds" style="margin-top:10px;float:left">
					<?if(isset($_REQUEST['kwrdtxt']) && $_REQUEST['kwrdtxt'] != "NULL"){?>
						<option value="<?echo $_REQUEST['kwrds'];?>"><?echo $_REQUEST['kwrds'];?></option>
					<?
					}else{
						?><option value="NULL">select keyword</option><?
					}
						$sqlColumns = "SELECT * FROM dayton";
						$queryColumns = mysql_query($sqlColumns, $con);
						while ($rowColumns=mysql_fetch_assoc($queryColumns)){
							foreach($rowColumns as $col => $val){
								if(strrpos($col,"_")!= false){
									$display = str_replace("_"," ",$col)
									?><option value='<?echo $col?>' ><?echo $display?></option><?
								}else{
							?>
								<option value='<?echo $col?>' ><?echo $col?></option>
							<?
								}
							}
						}
					?>
				</select>
			</li>
			<li style="margin-top:10px;float:left;margin-right:-5px;margin-left:1.5px;">contains value</li>
			<li>
				<?if(isset($_REQUEST['kwrdtxt'])){
					?><input id="kwrdtxt" name="kwrdtxt" type="text" value="<?echo $_REQUEST['kwrdtxt']?>" style="margin-top:10px;float:left"/><?
				}else{	
					?><input id="kwrdtxt" name="kwrdtxt" type="text" value="Type Keyword Value" style="margin-top:10px;float:left"/><?
				}
				?>
			</li>
		</center>
	</fieldset>
		<center>
			<fieldset id="button_field_set" class="button_field_set">
				<input id="clear_report_values" name="clear_values" type="submit" value="CLEAR" class="wide" style="margin-top:10px;float:left"/>
				<input id="apply" name="apply"  type="submit" value="RUN REPORT" class="wide" style="margin-top:10px;float:right"/>
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
		<li><a href="#tabs-4">Approved</a></li>
	</ul>
	<?
	//Begin mysql query.
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
								invoice_date,
								min_price,
								max_price,
								min_weight,
								max_weight
				FROM dayton as thedata
				LEFT JOIN
						  (
							SELECT carrier_id,
								   carrier_name 
							FROM carriers
						  ) 
				AS car ON thedata.carrier_id = car.carrier_id
				LEFT JOIN
						  (
							SELECT customer_name,
								   customer_id 
							FROM customers
						  )
				AS cust ON thedata.customer_id = cust.customer_id
				LEFT JOIN
						  (
							SELECT min_price,
								   max_price,
								   min_weight,
								   max_weight,
								   customer_id,
								   carrier_id
							FROM min_max
						  )
				AS mm ON thedata.customer_id = mm.customer_id
				AND thedata.carrier_id = mm.carrier_id";
	
    //Build middle part of mysql query based on user input from form.
	if(isset($_REQUEST['customer']) && $_REQUEST['customer'] != "NULL" ){
		$customer = $_REQUEST['customer'];
		SWITCH ($_REQUEST['carrier']){
			CASE "NULL":
			$sqlMid= " WHERE thedata.customer_id ='" .$customer. "'";
			BREAK;
			DEFAULT:
			$sqlMid = "";
			$carrier = $_REQUEST['carrier'];
			$sqlMid = " WHERE thedata.customer_id ='" .$customer. "'
					    AND thedata.carrier_id ='" .$carrier. "'";
		    BREAK;
		}
	}
	
	if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
		$carrier = $_REQUEST['carrier'];
		SWITCH ($_REQUEST['customer']){
			CASE "NULL":
			$sqlMid = " WHERE thedata.carrier_id = '" .$carrier. "'";
			BREAK;
			DEFAULT:
			$sqlMid = "";
			$customer = $_REQUEST['customer'];
			$sqlMid = " WHERE thedata.customer_id= '" .$customer. "'
						AND thedata.carrier_id= '".$carrier."'";
			BREAK;
		}
	}
	
	if(isset($_REQUEST['invoice']) && $_REQUEST['invoice'] != "NULL"){
		$invoice = $_REQUEST['invoice'];
		echo "this is the invoice number:".$invoice;
		SWITCH ($sqlMid){
			CASE "":
			$sqlMid = " WHERE thedata.statement_number = '" .$invoice. "'";
			BREAK;
			DEFAULT:
			$sqlMid .=  " AND thedata.statement_number = '" .$invoice. "'";
		}
    }
	
	if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--" && isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--"){
		$begin_date = $_REQUEST['from'];
		$end_date = $_REQUEST['to'];
		SWITCH ($sqlMid){
			CASE "":
			$sqlMid = " WHERE thedata.invoice_date BETWEEN '" .$from. "' AND '" .$to. "'";
			BREAK;
			DEFAULT:
			$sqlMid .= " AND thedata.invoice_date BETWEEN '" .$from. "' AND '" .$to. "'";
			BREAK;
		} 
	}
	
	if(isset($_REQUEST['kwrds']) && $_REQUEST['kwrds'] != "NULL"){
		$keyword = $_REQUEST['kwrds'];
		$value = $_REQUEST['kwrdtxt'];
		SWITCH ($sqlMid){
			CASE "":
			$sqlMid = " WHERE thedata." .$keyword. " like '%" .$value. "%'";
			BREAK;
			DEFAULT:
			$sqlMid .= " AND thedata. " .$keyword. " like '%" .$value. "%'";
			BREAK;
		} 
	}
	?>
	
	<div id="tabs-1">
	<?
		//Finish mysql query based on the tab.
		if ($sqlMid != ""){
			$sqlFin0 = " AND thedata.status = 0 ORDER BY inv_id";
			$sql0 = $sqlStrt ."".  $sqlMid ."".  $sqlFin0;
		}else{
			$sqlFin0 = " WHERE thedata.status = 0 ORDER BY inv_id";
			$sql0 = $sqlStrt ."".$sqlFin0;
		}
		echo $sqlGetMinMax;
		display_table($sql0,$customer,$carrier,$invoice,$to,$from,1);
		//echo $sql0;
	?>
	</div>
	
	<div id="tabs-2">
	<?
		if($sqlMid != ""){
			$sqlFin1 = " AND thedata.status = 1 ORDER BY inv_id";
			$sql1 = $sqlStrt ."". $sqlMid ."". $sqlFin1;
		}else{
			$sqlFin1 = " WHERE thedata.status = 1 ORDER BY inv_id";
			$sql1 = $sqlStrt ."". $sqlFin1;
		}
		display_table($sql1,$customer,$carrier,$invoice,$to,$from,2);
		//echo $sql1;
		?>
	</div>
	
	<div id="tabs-3">
	<?
		if ($sqlMid != ""){
			$sqlFin2 = " AND thedata.status = 2 ORDER BY inv_id";
			$sql2 = $sqlStrt ."". $sqlMid ."". $sqlFin2;
		}else{
			$sqlFin2 = " WHERE thedata.status = 2 ORDER BY inv_id";
			$sql2 = $sqlStrt ."". $sqlFin2;
		}
		display_table($sql2,$customer,$carrier,$invoice,$to,$from,3);
		//echo $sql2;
	?>
	</div>
	
	<div id="tabs-4">
	<?
		if ($sqlMid != ""){
			$sqlFin3 = " AND thedata.status = 3 ORDER BY inv_id";
			$sql3 = $sqlStrt ."". $sqlMid ."". $sqlFin3;
			
		}else{
			$sqlFin3 = " WHERE thedata.status = 3 ORDER BY inv_id";
			$sql3 = $sqlStrt ."". $sqlFin3;
		}
		display_table($sql3,$customer,$carrier,$invoice,$to,$from,4);
		//echo $sql3;
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
			<input type="hidden" id="inv_line_items" name="inv_line_items">
			<input type="hidden" id="customer_id" name="customer_id" value="<?echo $_REQUEST['customer']?>">
			<input type="hidden" id="carrier_id" name="carrier_id" value="<?echo $_REQUEST['carrier']?>">
			<input type="hidden" id="invoice_number" name="invoice_number" value="<?echo $_REQUEST['invoice']?>">
			<input type="hidden" id="begin_date" name="begin_date" value="<?echo $_REQUEST['from']?>">
			<input type="hidden" id="end_date" name="end_date" value="<?echo $_REQUEST['to']?>">
			<ul style="list-style-type:none;margin:0;padding:0;display: inline-block;">
				<li>
					<!--<input id="add" name="add" type="submit" value="ADD" style="font-size:8px;" class="wide">-->
				</li>
				
			</ul>
		</center>
	</form>
</div>
<?

    	
?>