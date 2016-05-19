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

var line_items = [];

$.fn.dataTable.ext.buttons.invoice = {
	
	className: 'invoice',
	action: function (e,dt,node,config){
		line_items = [];
		$("input[type=checkbox]").each(function (){
			var val = $(this).val();
			if($(this).prop("checked")){
				line_items.push(val);
			}
		});
		if(line_items != ""){
			$("#inv_line_items").val(line_items);
			//alert(line_items);
			window.open("create_invoice_pdf.php?invoice_numbers="+ line_items,'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
			//$("#inv_form").submit();
			//$("#inv_dialog").dialog("open");
			
		}else{
			alert("Please make a selection to invoice");
		}
	}
};

$(document).ready(function(){
	$(window).load(function(){
		$('.invoice').show();
		$('.invoice').css('background','#CEF6CE');
	});
   
	/*Page load--------------------------------------------*/
	$("table.display").dataTable({
	    //"scrollY": "600px",
		"scrollCollapse": true,
		"paging": false,
		"jQueryUI": true,
		dom: "Bfrtip",
		buttons:[
            'excelHtml5',
			//'pdfHtml5',
			'print',
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
				$('.invoice').show();
				$('.invoice').css('background','#CEF6CE');
				//$('#get_tab').val(ui.newTab.index());
			}
			if(ui.newTab.index() == "1"){
				$('.invoice').hide();
				//$('#selections').show();
				//$('#get_tab').val(ui.newTab.index());
			}
			if(ui.newTab.index() == "2"){
				$('.invoice').hide();
				//$('#selections').show();
				//$('#get_tab').val(ui.newTab.index());
			}
			
		}
	});
	$("form").submit(function(){
		//alert("Submitted");
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
			dateFormat: "d-m-yy"
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
			dateFormat: "d-m-yy"
		});
		$(document).tooltip();
	});
	/*End Datepicker--------------------------------------------- */
  	
	/*Checkboxes-------------------------------------------------*/
	
    
	$(function(){
		 $(".multiselect").multiselect();
	});
	
	
	/*End Checkboxes----------------------------------------------- -*/
	$('.check:button').click(function(){
         $('input[type="checkbox"]').each(function (){
			var chk = $(this);
			
			chk.prop("checked", !chk.prop("checked"));
			if(!chk.prop("checked")){
				line_items = [];
			}
		 });
       
    });
	
	/*Processing----------------------------------------------------*/
	$("#clear_report_values").click(function(){
	    $("#customer").val('');
		$("#carrier").val('');
		$("#srcl_invoice_num").val('');
		$("#from").val("--Begin Date--");
		$("#to").val("--End Date--");
			
	});
	
	$('#invoice_items').click(function(){
		   var paramChangeBoxes = $('input:checkbox.change');
		   if ($(this).is(':checked')) {
			  paramChangeBoxes.attr('disabled', 'disabled');
			  $('#chkBox1').attr('disabled', 'disabled');
		   }
		  else {
			  paramChangeBoxes.removeAttr('disabled');
			  $('#chkBox1').removeAttr('disabled');
		   }
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
		
	$("#inv_cancel").click(function(e){
		$("#inv_dialog").dialog("close");
		$("#service_charge").val('');
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
			<li style="font-size:10px;">
				SRCL Invoice #:
				<select name="srcl_invoice_num" id="srcl_invoice_num" >
				<?if(isset($_REQUEST['srcl_invoice_num']) && $_REQUEST['srcl_invoice_num'] != "NULL" && strlen($_REQUEST['srcl_invoice_num']) > 0){
					$sqlInvoice = "SELECT srcl_inv_num
								   FROM srcl_invoice_table
                                   WHERE srcl_inv_num = '".$_REQUEST['srcl_invoice_num']."'";
					$queryInvoice = mysql_query($sqlInvoice,$con);
					$rowInvoice=mysql_fetch_array($queryInvoice);
					 ?><option value="<?echo $rowInvoice['srcl_inv_num']?>"><?echo $rowInvoice['srcl_inv_num']?></option><?
					$sqlInvoices = "SELECT srcl_inv_num
									FROM srcl_invoice_table
									WHERE srcl_inv_num != '".$_REQUEST['srcl_invoice_num']."'
									ORDER BY srcl_inv_num";
						$queryInvoices = mysql_query($sqlInvoices,$con);
						while($rowInvoices=mysql_fetch_array($queryInvoices)){
							?><option value="<?echo $rowInvoices['srcl_inv_num']?>"><?echo $rowInvoices['srcl_inv_num']?></option><?
						}
				}else{
					?><option value="NULL">--select invoice--</option><?
					$sqlInvoices = "SELECT srcl_inv_num
									FROM srcl_invoice_table";
					$queryInvoices = mysql_query($sqlInvoices,$con);
					while($rowInvoices=mysql_fetch_array($queryInvoices)){
							?><option value="<?echo $rowInvoices['srcl_inv_num']?>"><?echo $rowInvoices['srcl_inv_num']?></option><?
							
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
	</div>
  </form>
</center>

<div id="tabs" class="report_data"  style="border:none;">
	<ul class="report_data" style="height:30px;">
		<!--<li><a href="#tabs-1">All</a></li>-->
		<li><a href="#tabs-1">SRCL Invoice</a></li>
		<li><a href="#tabs-2">Carrier</a></li>
		<li><a href="#tabs-3">Shipment</a></li>
		
		
	</ul>
		<div id="tabs-1">
		<?
			$sqlstrt = "SELECT  d.srcl_inv_id,
								d.carrier_id,
								c.carrier_name,
								sum(d.gross_amount) as total,
								count(d.srcl_inv_id) as shipments,
								i.srcl_inv_date
						FROM dayton d
						JOIN
							 (
								SELECT carrier_id, 
									   carrier_name
								FROM carriers 
							 )
						AS c ON d.carrier_id = c.carrier_id
						JOIN
							 (
								SELECT srcl_inv_num,
									   srcl_inv_date
								FROM srcl_invoice_table
							 ) 
						AS i ON d.srcl_inv_id = i.srcl_inv_num";
							
			
			if(isset($_REQUEST['srcl_invoice_num']) && $_REQUEST['srcl_invvoice_num'] != "NULL"){
				$inv_id = $_REQUEST['srcl_invoice_num'];
				switch($_REQUEST['carrier']){
					case "NULL":
						$sqlmid1 = "WHERE d.srcl_inv_id = '" .$inv_id. "'";
					break;
					default:
						$carrier = $_REQUEST['carrier'];
						$sqlmid1 = "WHERE d.srcl_inv_id = '" .$inv_id. "'
									AND d.carrier_id = '" .$carrier. "'";
					break;
				}
			}
			if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
				switch($_REQUEST['srcl_invoice_num']){
					case "NULL":
						$sqlmid1 = "WHERE d.carrier_id = '" .$carrier. "'";
					break;
					default:
						$inv_id = $_REQUEST['srcl_invoice_num'];
						$sqlmid1 = "WHERE d.srcl_inv_id = '" .$inv_id. "'
								    AND d.carrier_id = '" .$carrier. "'";
					break;							   
				}
			}
			if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--"
			&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--"){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				switch($sqlmid1){
					case "":
						$sqlmid1 = "WHERE i.srcl_inv_date BETWEEN  '" .$begin_date. "' AND '" .$end_date. "'";
					break;
					default:
						$sqlmid1 = "AND i.srcl_inv_date BETWEEN  '" .$begin_date. "' AND '" .$end_date. "'";
					break;							   
				}
			}
			if($sqlmid1 != ""){
				
				$sqlfin1  = $sqlstrt ." ". $sqlmid1 . " GROUP BY d.srcl_inv_id";
			}else{
				$sqlfin1 = $sqlstrt ." WHERE d.srcl_inv_id != ' ' GROUP BY d.srcl_inv_id"; 
			}
			//echo $sqlfin1;
			srcl_1st_tab($sqlfin1);
			?>
		</div>
		<div id="tabs-2">
			<?
			if(isset($_REQUEST['srcl_invoice_num']) && $_REQUEST['srcl_invvoice_num'] != "NULL"){
				$inv_id = $_REQUEST['srcl_invoice_num'];
				switch($_REQUEST['carrier']){
					case "NULL":
						$sqlmid2 = "WHERE d.srcl_inv_id = '" .$inv_id. "'";
					break;
					default:
						$carrier = $_REQUEST['carrier'];
						$sqlmid2 = "WHERE d.srcl_inv_id = '" .$inv_id. "'
								    AND d.carrier_id = '" .$carrier. "'";
					break;
				}
			}
			if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
				switch($_REQUEST['srcl_invoice_num']){
					case "NULL":
						$sqlmid2 = "WHERE d.carrier_id = '" .$carrier. "'";
					break;
					default:
						$inv_id = $_REQUEST['srcl_invoice_num'];
						$sqlmid2 = "WHERE d.srcl_inv_id = '" .$inv_id. "'
								    AND d.carrier_id = '" .$carrier. "'";
					break;							   
				}
			}
			if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--"
			&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--"){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				switch($sqlmid2){
					case "":
						$sqlmid2 = "WHERE i.srcl_inv_date BETWEEN  '" .$begin_date. "' AND '" .$end_date. "'";
					break;
					default:
						$sqlmid2 = "AND i.srcl_inv_date BETWEEN  '" .$begin_date. "' AND '" .$end_date. "'";
					break;							   
				}
			}
			if($sqlmid2 != ""){
				
				$sqlfin2  = $sqlstrt ." ".$sqlmid2. " GROUP BY d.srcl_inv_id";
			}else{
				$sqlfin2 = $sqlstrt ." WHERE d.srcl_inv_id != ' ' GROUP BY d.srcl_inv_id"; 
			}
			//echo $sqlfin2;
			srcl_2nd_tab($sqlfin2);
		
		?>
		</div>
		<div id="tabs-3">
		<?//Approved Shipments
			$sqlstrt3 = "SELECT * FROM srcl_invoice_table AS i
						 LEFT JOIN (
									 SELECT DISTINCT line_item_id,
													  srcl_inv_id,
													  pro_number,
													  carrier_id,
													  status,
													  shipper_name, 
													  shipper_state, 
													  consignee_name, 
													  consignee_state,
													  pallets,
													  weight, 
													  gross_amount,
													  BOL
									 FROM dayton
								   ) 
						 AS d ON i.srcl_inv_num = d.srcl_inv_id
						 LEFT JOIN
								  (
									SELECT carrier_id, 
										   carrier_name 
									FROM carriers
								  ) 
						 AS c ON d.carrier_id = c.carrier_id";
							
			if(isset($_REQUEST['srcl_invoice_num']) && $_REQUEST['srcl_invvoice_num'] != "NULL"){
					$inv_id = $_REQUEST['srcl_invoice_num'];
					switch($_REQUEST['carrier']){
						case "NULL":
							$sqlmid3 = "WHERE d.srcl_inv_id = '" .$inv_id. "'";
						break;
						default:
							$carrier = $_REQUEST['carrier'];
							$sqlmid3 = "WHERE d.srcl_inv_id = '" .$inv_id. "'
										AND d.carrier_id = '" .$carrier. "'";
						break;
					}
			}
			if(isset($_REQUEST['carrier']) && $_REQUEST['carrier'] != "NULL"){
				$carrier = $_REQUEST['carrier'];
				switch($_REQUEST['srcl_invoice_num']){
					case "NULL":
						$sqlmid3 = "WHERE d.carrier_id = '" .$carrier. "'";
					break;
					default:
						$inv_id = $_REQUEST['srcl_invoice_num'];
						$sqlmid3 = "WHERE d.srcl_inv_id = '" .$inv_id. "'
									AND d.carrier_id = '" .$carrier. "'";
					break;							   
				}
			}
			if(isset($_REQUEST['from']) && $_REQUEST['from'] != "--Begin Date--"
			&& isset($_REQUEST['to']) && $_REQUEST['to'] != "--End Date--"){
				$begin_date = $_REQUEST['from'];
				$end_date = $_REQUEST['to'];
				switch($sqlmid3){
					case "":
						$sqlmid3 = "WHERE i.srcl_inv_date BETWEEN  '" .$begin_date. "' AND '" .$end_date. "'";
					break;
					default:
						$sqlmid3 = "AND i.srcl_inv_date BETWEEN  '" .$begin_date. "' AND '" .$end_date. "'";
					break;							   
				}
			}

			if($sqlmid3 != ""){
					$sqlfin3  = $sqlstrt3 ." ".$sqlmid3. " AND status = 3 ORDER BY d.srcl_inv_id";
			}else{
					$sqlfin3 = $sqlstrt3 ." WHERE status = 3 ORDER BY d.srcl_inv_id"; 
			}
			
			//echo $sqlfin3;
			srcl_3rd_tab($sqlfin3);
	?>
	</div>
</div>
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
