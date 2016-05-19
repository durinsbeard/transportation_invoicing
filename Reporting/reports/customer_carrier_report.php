	<?	

		if($_POST["customer"] != "" && $_POST["carrier"]){
			$customer = mysql_real_escape_string($_POST['customer']);
			$carrier = mysql_real_escape_string($_POST['carrier']);
		}else if ($_GET["customer"] != "" && $_GET["carrier"] != ""){
			$customer = mysql_real_escape_string($_GET['customer']);
			$carrier = mysql_real_escape_string($_GET['carrier']);	
		}
	
	
	
	$sqlGetMinMax = "SELECT * FROM min_max
					 WHERE customer_id = '".$customer."'
					 AND carrier_id = '".$carrier."'";
	$findMinMax = mysql_query($sqlGetMinMax,$con);
	$foundMinMax = mysql_fetch_array($findMinMax);
	
	
	
	
	$sqlGetCustomerName = "SELECT customer_name FROM customers
						   WHERE customer_id = '".$customer."'";
	$findCustomerName = mysql_query($sqlGetCustomerName,$con);
	$foundCustomerName = mysql_fetch_array($findCustomerName);
	
	$sqlGetCarrierName = "SELECT carrier_name FROM carriers
						  WHERE carrier_id = '".$carrier."'";
	$findCarrierName = mysql_query($sqlGetCarrierName,$con);
	$foundCarrierName = mysql_fetch_array($findCarrierName);
	
	$sql="SELECT line_item_id,
				 statement_number,
				 shipper_name,
				 invoice_date,
				 shipper_state, 
				 consignee_name, 
				 consignee_state, 
				 weight, 
				 gross_amount, 
				 BOL,
				 thedata.carrier_id,
			     thedata.customer_id,
				 cc.carrier_name,
				 cust.customer_name
		  FROM dayton as thedata 
		  LEFT JOIN (SELECT carrier_name, carrier_id FROM carriers) 
		  AS cc ON thedata.carrier_id = cc.carrier_id
		  LEFT JOIN (SELECT customer_id, customer_name FROM customers)
		  AS cust ON thedata.customer_id = cust.customer_id
		  WHERE thedata.customer_id = '".$customer."'
		  AND thedata.carrier_id = '".$carrier."'";
    $query = mysql_query($sql,$con);
	if (mysql_num_rows($query) <> 0)
	{
	?>
	<center><h5>All Shipments: <?echo $foundCustomerName['customer_name'].", ".$foundCarrierName['carrier_name'];?></h5></center>
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
				<?echo $status;?>
			</td>
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