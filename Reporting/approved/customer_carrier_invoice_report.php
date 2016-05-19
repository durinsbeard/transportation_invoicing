<?
		$customer = mysql_real_escape_string($_POST['customer']);
		$carrier = mysql_real_escape_string($_POST['carrier']);
		$invoice = mysql_real_escape_string($_POST['invoice']);
		$sqlGetCustomerName = "SELECT customer_name FROM customers
						   WHERE customer_id = '".$customer."'";
	$findCustomerName = mysql_query($sqlGetCustomerName,$con);
	$foundCustomerName = mysql_fetch_array($findCustomerName);
	
	$sqlGetCarrierName = "SELECT carrier_name FROM carriers
						  WHERE carrier_id = '".$carrier."'";
	$findCarrierName = mysql_query($sqlGetCarrierName,$con);
	$foundCarrierName = mysql_fetch_array($findCarrierName);

	
	$sql = "SELECT DISTINCT
				   line_item_id,
				   statement_number,
				   invoice_date,
				   shipper_name, 
				   shipper_state, 
				   consignee_name, 
				   consignee_state, 
				   weight, 
				   gross_amount, 
				   BOL,
                   thedata.carrier_id,
                   thedata.customer_id
			FROM dayton as thedata
            INNER JOIN min_max as mm
            ON thedata.customer_id = mm.customer_id
            AND thedata.carrier_id = mm.carrier_id
            AND  thedata.weight BETWEEN mm.min_weight AND mm.max_weight 
		    AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
		    WHERE thedata.customer_id= '".$customer."'
		    AND thedata.carrier_id= '".$carrier."'
			AND thedata.statement_number = '".$invoice."'";
		 $query = mysql_query($sql,$con);
	if (mysql_num_rows($query) <> 0)
	{
	?>
	<center><h5><font style="color:green;">Approved</font>  Shipments:<?echo $foundCustomerName['customer_name'].", ".$foundCarrierName['carrier_name'];?></h5></center>
	<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
			<tr>
				<th style="font-size:10px;">
					Statment Number
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
					Status
				</th>
			</tr>
		</thead>
		<tbody>
	<?
		while($row=mysql_fetch_array($query))
		{
		?>
		<tr>
			
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
				<a style="display:block;" href="?form=line_item_information&line_item=<?echo$row['line_item_id']?>" title="view">
					<font style="color:green;"><?echo $row['statement_number']?></font>
				</a>
			</td><td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
				<?echo $foundCustomerName['customer_name'];?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
				<?echo $foundCarrierName['carrier_name'];?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
				<?echo $row['invoice_date']?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
				<?echo $row['shipper_name']?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
				<?echo $row['shipper_state']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;font-size:10px;">
				<?echo $row['consignee_name']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
				<?echo $row['consignee_state']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
				<?echo $row['weight']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
				<?echo "$".$row['gross_amount']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
				<?echo $row['BOL']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
				<font style="color:green;"><b>Approved</b></font>
			</td >
		</tr>
		<?
		}
	?>
		<tbody>
	</table>
	
	<?
	}else
	{
			echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:500px;margin-top:50px;'><center>There are currently no rules set up for this request.</center></div></center>";	
	}
?>