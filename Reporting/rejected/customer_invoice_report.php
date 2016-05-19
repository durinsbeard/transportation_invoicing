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
		AND  thedata.weight NOT BETWEEN mm.min_weight AND mm.max_weight 
		OR thedata.gross_amount NOT BETWEEN mm.min_price AND mm.max_price
		WHERE thedata.customer_id= '".$customer."'
		AND mm.customer_id= '".$customer."'
		AND mm.carrier_id IS NULL
		AND thedata.statement_number = '".$invoice."'";
		 $query = mysql_query($sql,$con);
		?>
		<center><h5><font style="color:red;">Rejected</font> Shipments: <?echo $foundCustomerName['customer_name'].", ".$invoice;?></h5></center>
		<table width="100%" class="display" id="example" cellspacing="0">
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
						Status
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
					<a style="display:block;" href="?form=line_item_information&report=customer_report&line_item=<?echo$row['line_item_id']?>&tab=rejected&customer=<?echo $customer?>" title="view">
						<font style="color:green"><?echo $row['statement_number']?></font>
					</a>
				</td>
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
					<?echo $weight?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $gross_amount?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $row['BOL']?>
				</td>
				
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $status?>
				</td>
			</tr>
			<?
			}
		
		
		?>	
		<tbody>
	</table>
	