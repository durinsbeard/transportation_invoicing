<?
        $carrier=$_POST["carrier"];
		
		$sqlGetCarrierName = "SELECT carrier_name FROM carriers
							  WHERE carrier_id = '".$carrier."'";
	    $findCarrierName = mysql_query($sqlGetCarrierName,$con);
		$foundCarrierName = mysql_fetch_array($findCarrierName);
		
    	$sql="SELECT line_item_id,
					 statement_number,
					 shipper_name, 
					 shipper_state, 
					 consignee_name, 
					 consignee_state, 
					 weight, 
					 gross_amount, 
					 BOL,
					 thedata.customer_id, 
					 thedata.carrier_id
			 FROM dayton as thedata 
			 JOIN (SELECT min_weight, max_weight, min_price, max_price, customer_id,carrier_id FROM min_max) 
			 as mm on thedata.carrier_id = mm.carrier_id 
			 AND thedata.weight BETWEEN mm.min_weight AND mm.max_weight
			 AND thedata.gross_amount BETWEEN mm.min_price AND mm.max_price
			 WHERE thedata.carrier_id= '".$carrier."'
			 AND mm.carrier_id = '".$carrier."'
			 AND mm.customer_id IS NULL";
		 $query = mysql_query($sql,$con);
		?>
		<center><h5>Approved Shipments: <?echo $foundCarrierName['carrier_name'];?></h5></center>
		<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
				<tr>
					<th style="font-size:10px;">
						Invoice #
					</th>
					<th>
						Shipper Name
					</th>
					<th>
						S State
					</th>
					<th>
						Consignee Name
					</th>
					<th>
						C State
					</th>
					</th>
					<th>
						Weight
					</th>
					<th>
						Gross Amount
					</th>
					<th>
						BOL #
					</th>
					<th>
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
					<a style="display:block;" href="?form=line_item_information&report='carrier_report'&line_item=<?echo$row['line_item_id']?>&carrier=<?echo$row['carrier']?>" title="view">
						<font style="color:green"><?echo $row['statement_number']?></font>
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
					<?echo $row['weight']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo "$".$row['gross_amount']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:200px;font-size:10px;">
					<?echo $row['BOL']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
					<font style="color:green"><b>Approved</b></font>
				</td >
			</tr>
			<?
			}
		
		
		?>	
		<tbody>
	</table>
	