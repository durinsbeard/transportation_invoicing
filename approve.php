
<?include("includes/connect.php");
$approve_items= $_GET["approve_items"];


$sql = "SELECT * FROM dayton WHERE line_item_id IN (".$approve_items.")";

$query = mysql_query($sql,$con);


?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<script src="JS/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="JS/jquery.tablesorter.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$( "#submit" ).click(function() {
		window.opener.location.reload();
		$("#approve").submit();
		//window.opener.document.location.reload(); 
		window.close(); 
		//return false;
	});
	
	$( "#cancel" ).click(function() {
		window.close();
	});
});
</script>

<body onBlur="self.focus();">
<form  id="approve" action="submits/approve_submit.php" method="get">
<table id="invoice_table">
	<thead>
		<tr>
			<th style="font-size:10px;">
				Invoice #
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
				<?echo strtolower($row['weight'])?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
				<?echo $row['gross_amount'];?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
				<?echo $row['BOL']?>
			</td>
			
			
		</tr>
	<?
	}
?>
	<tbody>
</table>
<center>
			<fieldset id="button_field_set" class="button_field_set">
						<input style="float:left" id="submit" name="approve" type="submit" value="APRROVE" class="wide" style="margin-top:10px;"/>
						<input style="float:right"id="cancel" name="cancel" id="cancel" type="submit" value="CANCEL" class="wide" style="margin-top:10px;"/>
						<input type="hidden" id="approve_line_items" name="approve_line_items" value="<?echo base64_encode(serialize($approve_items))?>">
			</fieldset>
</center>
</form>

