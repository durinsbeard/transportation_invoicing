<?
	if($_POST["carrier"] != ""){
		$customer=$_POST["carroer"];
	}else if ($_GET["carrier"] != ""){
		$customer=$_GET["carrier"];	
	}

	$sqlGetMinMax = "SELECT * FROM min_max
					 WHERE carrier_id = '".$carrier."'
					 AND customer_id IS NULL";
	$findMinMax = mysql_query($sqlGetMinMax,$con);
	$foundMinMax = mysql_fetch_array($findMinMax);
		
		
	
	
	$sqlGetCarrierName = "SELECT carrier_name FROM carriers
						   WHERE carrier_id = '".$carrier."'";
	$findCarrierName = mysql_query($sqlGetCarrierName,$con);
	$foundCarrierName = mysql_fetch_array($findCarrierName);
	
	
	$sql = "SELECT * FROM dayton
			WHERE carrier_id= '".$carrier."'";
    $query = mysql_query($sql,$con);
	if (mysql_num_rows($query) <> 0)
	{
	?>
		<center><h5>All Shipments: <?echo $foundCarrierName['carrier_name'];?></h5></center>
		<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
			<tr>
				<th style="font-size:10px;">
					Invoice #
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
				<a style="display:block;" href="?form=line_item_information&report=carrier_report&line_item=<?echo$row['line_item_id']?>&carrier=<?echo $carrier?>" title="view">
					<?echo $row['statement_number']?>
				</a>
			</td>
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
			<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
				<?echo $status?>
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