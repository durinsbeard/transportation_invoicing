<?include("includes/connect.php");
	$invoice_items= $_GET["invoice_items"];
	//$invoice_items = explode(",",$invoice_items);

	/*foreach($invoice_items as $invoice){
		echo $invoice."</br>";
	}*/
	$sql = "SELECT * FROM dayton where line_item_id IN (".$invoice_items.")";
	$query = mysql_query($sql,$con);
	
	
	$item_sql = "SELECT * FROM dayton WHERE line_item_id IN (".$invoice_items.")";
	$item_qry = mysql_query($item_sql,$con);
	$total_line_items = mysql_num_rows($item_qry);
	
	$totals_sql = "SELECT SUM( gross_amount ) AS total, SUM( weight ) AS weight FROM dayton WHERE line_item_id IN  (".$invoice_items.")";
	$totals_qry = mysql_query($totals_sql,$con);
	$totals = mysql_fetch_assoc($totals_qry);
	
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<script src="JS/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="JS/jquery.tablesorter.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$( "#submit" ).click(function() {
		//window.opener.location.reload();
		$("#invoice").submit();
		window.opener.document.location.reload(); 
		window.close(); 
		//return false;
	});
	
	$( "#cancel" ).click(function() {
		window.close();
	});
});
</script>
<body onBlur="self.focus();">
	<img width="150" src="images/src_logo_clear.gif" style="margin-left:10px;">
	<h1 style="float:right;">
		INVOICE
	</h1>
<form  id="invoice" action="submits/invoice_submit.php" method="get">
<div>
	
	</center>
	
	<div>
		<table id="invoice_table">
				<thead>
					<th>
					  Shipper
					</th>
					<th>
					  Gross Amount
					</th>
					<th>
					  Weight 
					</th>
				</thead>
				<tfoot style="background-color:#D8D8D8;">
					<tr >
						<td>
							<b>total line items<br><?echo $total_line_items;?></b>
						</td>
						<td>
							<b>total amount<br><?echo "$".$totals["total"];?></b>
						</td>
						<td>
							<b>total weight<br><?echo $totals["weight"]." LBS";?></b>
						</td>
					<tr>
				</tfoot>
				<tbody>
				
					
					<?
					while($row=mysql_fetch_array($query)){
					?>
					<tr>
						<td>
							<?echo $row["shipper_name"];?>
						</td>
						<td>
							<?echo "$".$row["gross_amount"];?>
						</td>
						<td>
							<?echo $row["weight"]." LBS";?>
						</td>
					<tr>
					<?
					}
					?>
					
				</tbody>
		</table>
		
		<div></div>
	</div>	
</div>
<center>
		<fieldset id="button_field_set" class="button_field_set">
			<input style="float:left" id="submit" name="clear_values" type="submit" value="SUBMIT" class="wide" style="margin-top:10px;"/>
					
			<input style="float:right"id="cancel" name="cancel" id="cancel" type="submit" value="CANCEL" class="wide" style="margin-top:10px;"/>
			<input type="hidden" id="invoice_line_items" name="invoice_line_items" value="<?echo base64_encode(serialize($invoice_items))?>">
		</fieldset>
</center>
</form>
</body>
