<?
	$invoice = mysql_real_escape_string($_POST['invoice']);
	$sql = "SELECT * FROM dayton 
			WHERE statement_number = '".$invoice."'";
			$query = mysql_query($sql,$con);
?>
		<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
				<tr>
					<th>
						Invoice Number
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
						Status
					</th>
					<th>
						BOL #
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
					<?echo $row['statement_number']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;">
					<a style="display:block;" href="?form=line_item_information&line_item=<?echo$row['line_item_id']?>" title="view">
						<?echo $row['shipper_name']?>
					</a>	
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
					<?echo "Rejected"?>
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