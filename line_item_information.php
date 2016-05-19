<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<script src="JS/jquery-1.11.1.min.js" type="text/javascript"></script>
<link href="JS/jquery-ui.css" rel="stylesheet">
<link href="JS/dataTables.jqueryui.css" rel="stylesheet">
<script src="JS/jquery-ui.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$('#edit').click(function(){
		$( "input" ).each(function() {
			$( this ).removeAttr('readonly');
		});
		$(':input:enabled:visible:first').focus();
	});
	$('#submit').click(function(){
		
	});
});
</script>

<?
include('includes/connect.php');

$report=$_GET['report'];
$user=$_GET['user'];
$customer=$_GET['customer'];
$carrier=$_GET['carrier'];
$tab=$_GET['tab'];

if(isset($_GET['line_item']))
{
	$line_item = mysql_real_escape_string($_GET['line_item']);
	$sql_line_item = "SELECT * FROM dayton WHERE line_item_id = '" .$line_item. "'";
	$result_line_item = mysql_query($sql_line_item,$con);
	$row_line_item = mysql_fetch_array($result_line_item);
	
?>
<body onBlur="self.focus();">

<center>
<form id="line_items" action="edit_invoice.php">
<table id="">
	<col align="right" style="background-color:#E6E6E6;">
	<tr>
		<td class="a"  style="border-radius:5px;">			
			Invoice Number:
		</td>
		<td style="padding-right: 2cm;border-radius:5px;">			
			<?
				echo $row_line_item['inv_id'];
				echo "<input type='hidden' name='inv_id' value=".$row_line_item['inv_id'].">";
				echo "<input type='hidden' name='line_item_id' value=".$line_item.">";
				echo "<input type='hidden' name='user' value=".$user.">";
				
			?>
		</td>
	</tr>
	<!--<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Shipment Date:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='invoice_date' readonly value='".$row_line_item['invoice_date']."'>";
				echo "<input type='hidden' name='old_invoice_date' value=".$row_line_item['invoice_date']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Pro Number:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='pro_number'readonly value='".$row_line_item['pro_number']."'>";
				echo "<input type='hidden' name='old_pro_number' value='".$row_line_item['pro_number']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			BOL #:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='bol' readonly value='".$row_line_item['BOL']."'>";
				echo "<input type='hidden' name='old_bol' value='".$row_line_item['BOL']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Shipper Name:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='shipper_name' readonly value='".$row_line_item['shipper_name']."'>";
				echo "<input type='hidden' name='shipper_name' value='".$row_line_item['shipper_name']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Shipper City:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='shipper_city' readonly value='".$row_line_item['shipper_city']."'>";
				echo "<input type='hidden' name='old_shipper_city' value='".$row_line_item['shipper_city']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Shipper State:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='shipper_state' readonly value='".$row_line_item['shipper_state']."'>";
				echo "<input type='hidden' name='old_shipper_state'value='".$row_line_item['shipper_state']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Shipper Zip Code:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='ship_zip' readonly value='".$row_line_item['shipper_zip_code']."'>";
				echo "<input type='hidden' name='old_ship_zip' value='".$row_line_item['shipper_zip_code']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Cogsignee Name:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='con_name' readonly value='".$row_line_item['consignee_name']."'>";
				echo "<input type='hidden' name='old_con_name' value='".$row_line_item['consignee_name']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Cogsignee Sate:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='con_state'readonly value='".$row_line_item['consignee_state']."'>";
				echo "<input type='hidden' name='old_con_state' value='".$row_line_item['consignee_state']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Cogsignee Zip Code:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='con_zip' readonly value='".$row_line_item['consignee_zip_code']."'>";
				echo "<input type='hidden' name='old_con_zip' value='".$row_line_item['consignee_zip_code']."'>";
			?>
		</td>
	</tr>-->
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Pallets:
		</td>
		<td width="100%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='pallets' readonly value='".$row_line_item['pallets']."'>";
				echo "<input type='hidden' name='old_pallets' value='".$row_line_item['pallets']."'>";
			?>
		</td>
	</tr>
	<!--<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Class:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='class' readonly value='".$row_line_item['class']."'>";
				echo "<input type='hidden' name='old_class' value='".$row_line_item['class']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Cogsignee City:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='con_city' readonly value='".$row_line_item['consignee_city']."'>";
				echo "<input type='hidden' name='old_con_city' value='".$row_line_item['consignee_city']."'>";
			?>
		</td>
	</tr>-->
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Weight:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name = 'new_weight' readonly value='".$row_line_item['weight']."'>";
				echo "<input type='hidden' name='orig_weight' value='".$row_line_item['weight']."'>";
				
			?>
		</td>
	</tr>
	<!--<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			P/O:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='po' value='".$row_line_item['purchase_order']."'>";
				echo "<input type='hidden' name='po' value='".$row_line_item['purchase_order']."'>";
			?>
		</td>
	</tr>
	<tr>-->
		<td width="50%" class="a" style="border-radius:5px;">			
			Gross Amount:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">		
			<?
				echo "<input type='text' name = 'new_amount' readonly value='".$row_line_item['gross_amount']."'>";
				echo "<input type='hidden' name = 'orig_amount' value='".$row_line_item['gross_amount']."'>";
			?>
		</td>
	</tr>
	<!--<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Fuel Surcharge:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='fuel_surcharge' readonly value='".$row_line_item['fuel_surcharge']."'>";
				echo "<input type='hidden'  name='old_fuel_surcharge' value='".$row_line_item['fuel_surcharge']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Discount Amount:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='dis_amount' readonly value='".$row_line_item['discount_amount']."'>";
				echo "<input type='hidden' name='old_dis_amount' value='".$row_line_item['discount_amount']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Net Amount:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='net_amount' readonly value='".$row_line_item['net_amount']."'>";
				echo "<input type='hidden' name='old_net_amount' value='".$row_line_item['net_amount']."'>";
			?>
		</td>
	</tr>
	<tr>
		<td width="50%" class="a" style="border-radius:5px;">			
			Paid to Date:
		</td>
		<td width="50%" style="padding-right: 2cm; border-radius:5px;">			
			<?
				echo "<input type='text' name='ptd' readonly value='".$row_line_item['paid_to_date']."'>";
				echo "<input type='hidden' name='old_ptd' value='".$row_line_item['paid_to_date']."'>";
			?>
		</td>
	</tr>-->
	
</table>
			</center>
			<center>
			<table>
			<thead>
				<th>
					NOTES
				<th>
			<thead>
			<tbody>
				 <tr>
					<td colspan="2">
						<textarea name="notes" rows="4" cols="50"  style="width:300px; height:50px;"></textarea> 
					</td>
				</tr>
			<tbody>
			</table>
			<table>
				<tr>
					<td>
						<input type="button" class="wide" id="edit" value="edit">
					</td>
					<td>
						<input type="submit" class="wide" id="update" value="update" name="update" >
					</td>
				</tr>
			</table>
			<center>







 </form>
</body>

<?
}
?>
