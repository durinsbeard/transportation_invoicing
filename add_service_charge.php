<script src="JS/jquery.min.js" type="text/javascript"></script>
<script src="JS/jquery.inputmask.bundle.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
     $("#service_charge").inputmask("decimal",{
         radixPoint:".", 
         groupSeparator: ",", 
         digits: 2,
         autoGroup: true,
         prefix: '$'
     });
	 
	$('#add_service_charge').click(function(){
		///var val = $('#service_charge').val();
		//if(val == ""){
			//alert("You must enter a service charge");
			//return false;
		//}else{
			window.open("create_invoice_pdf.php?invoice_items="+ line_items+"",'Ratting','width=1024,height=500, top=100,left=100,toolbar=yes,menubar=yes,scrollbars=yes,resizable=yes,location=no,status=no,modal=yes');
				
		//}
	});
	 
});		
</script>
<?
include("includes/connect.php");
require('invoice.php');

$invoice_items= $_GET["invoice_items"];

$sql = "SELECT line_item_id,
			   data.customer_id,
               shipper_name,
               gross_amount,
               weight,
               customer_name,
			   cust_street,
			   cust_city,
			   cust_state,
			   cust_zip
        FROM dayton as data
        LEFT JOIN (SELECT customer_id,
						  customer_name,
						  cust_street,
				          cust_city,
				          cust_state,
				          cust_zip
				          FROM customers)as cust
        ON data.customer_id = cust.customer_id
        WHERE line_item_id IN (".$invoice_items.")";

$query = mysql_query($sql,$con);
$count = mysql_num_rows($query);
//$address = mysql_fetch_array($query);
//echo $count;

$item_sql = "SELECT * FROM dayton WHERE line_item_id IN (".$invoice_items.")";
$item_qry = mysql_query($item_sql,$con);
$total_line_items = mysql_num_rows($item_qry);

$totals_sql = "SELECT SUM( gross_amount ) AS total, SUM( weight ) AS weight,statement_number FROM dayton WHERE line_item_id IN  (".$invoice_items.")";
$totals_qry = mysql_query($totals_sql,$con);
$totals = mysql_fetch_assoc($totals_qry);



?>
<center>
<table cellpadding=1 cellspacing=.5 border=0 >
	<thead>
	<tr>
		<th>
			SHIPPER
		</th>
		<th>
			GROSS AMOUNT
		</th>
		<th>
			WEIGHT
		</th>
	</tr>
	</thead>
	
<?
while($row=mysql_fetch_array($query)){
?>
	<tbody>
	<tr>
		<td style='border:1px solid; border-color:#CCCCCC; border-radius:3px; text-align:center;'>
			<?echo $row['shipper_name'];?>
		</td>
		<td style='border:1px solid; border-color:#CCCCCC; border-radius:3px; text-align:center;'>
			<?echo "$".$row['gross_amount']?>
		</td>
		<td style='border:1px solid; border-color:#CCCCCC; border-radius:3px; text-align:center;'>
			<?echo $row['weight']?>
		</td>
	</tr>
	</tbody>


<?
	
}
?>
	

	
</table>
</center>

<center><h3>Add service charge?</h3>
<input type="text" name="service_charge" id="service_charge" size="20">
<input type="button" name="add_service_charge" id="add_service_charge" value="ADD" >
</center>