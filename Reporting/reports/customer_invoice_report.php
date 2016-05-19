<?
	
	
	$customer = mysql_real_escape_string($_POST['customer']);
	
	$invoice = mysql_real_escape_string($_POST['invoice']);
	
	$sqlGetMinMax = "SELECT * FROM min_max
					 WHERE customer_id = '".$customer."'";
	$findMinMax = mysql_query($sqlGetMinMax,$con);
	$foundMinMax = mysql_fetch_array($findMinMax);
		
		
	$sqlGetCustomerName = "SELECT customer_name FROM customers
						   WHERE customer_id = '".$customer."'";
	$findCustomerName = mysql_query($sqlGetCustomerName,$con);
	$foundCustomerName = mysql_fetch_array($findCustomerName);
	
	$sql = "SELECT * FROM dayton
			WHERE customer_id= '".$customer."'
			AND statement_number = '".$invoice."'";
		 $query = mysql_query($sql,$con);
		?>
		<center><h5>All Shipping: <?echo $foundCustomerName['customer_name'].", ".$invoice;?></h5></center>
		<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
				<tr>
					<th style="font-size:10px;">
						Invoice Number
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
				
				if ($row["gross_amount"] < $foundMinMax["min_price"] || $row["gross_amount"] > $foundMinMax["max_price"]){
					$status = "<font style='color:red;'><b>Rejected</b><font>";
					$gross_amount = "<font style='color:red;'><b>$".$row['gross_amount']."</b></font>";
					
				}else if($row["weight"] < $foundMinMax["min_weight"] || $row["weight"] > $foundMinMax["max_weight"]){
					$status = "<font style='color:red;'><b>Rejected</b><font>";
					$weight = "<font style='color:red;'><b>".$row['weight']."lbs</b></font>";
				}else{
						$status = "<font style='color:green;'><b>Approved</b><font>";
						$gross_amount = "$".$row['gross_amount'];
						$weight = $row['weight']."lbs";
				}
			?>
			<tr>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
					<a style="display:block;" href="?form=line_item_information&line_item=<?echo$row['line_item_id']?>" title="view">
						<?echo $row['statement_number']?>
					</a>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
					<?echo "<font style='font-size:8px'>".$foundCarrierName['carrier_name']."</font>";?>
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
					<?echo $weight?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $gross_amount;?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $row['BOL'];?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $status;?>
				</td>
			</tr>
			<?
			}
		
		
		?>	
		<tbody>
	</table>