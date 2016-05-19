<?
function display_table($sql_statement,$customer,$carrier,$invoice,$to,$from,$tab){
	include('includes/connect.php');
	$sql=$sql_statement;
	//echo $sqlGetMinMax;
	//echo $sql;
	$query = mysql_query($sql,$con);
	if(mysql_num_rows($query) == 0){
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:500px;margin-top:50px;'><center>No results.</center></div></center>";
	}else{
	?>
	<!--</center>-->
	<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
			<tr>
				<th>
					Invoice # 
				</th>
				<th>
					Pro Number
				</th>
				<th>
					Customer
				</th>
				<th>
					Carrier
				</th>
				<th>
					Date
				</th>
				<th>
					Shipper Name
				</th>
				<th>
					Shipper State
				</th>
				<th>
					Consignee Name
				</th>
				<th>
					Consignee State
				</th>
				<th>
					Pallets
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
				<th>
					<?
						SWITCH($tab){
							case 1:
								$process="";
								$status = "No Rules Set";
								
								break;
							case 2:
								$process="<input type='checkbox' id='approve_all_checkbox'>";
								$status = "Disputed";
							break;
							case 3:
								$process="<input type='checkbox' id='invoice_all_checkbox'>";
								$status = "Approve";
								
								break;
							case 4:
								$process="Complete";
								$status = "Approved";
								
								break;
						}
						echo $process;
					?>
				</th>
			</tr>
		</thead>
		<tbody>
	<?
	while($row=mysql_fetch_array($query)){	
	?>
		<tr>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
				<a href="javascript:void(0);" onClick=window.open("line_item_information.php?line_item=<?echo $row['line_item_id']?>&user=<?echo $_GET['user']?>","Ratting","width=500,height=700,0,status=0,");>
					<?echo $row['inv_id']?>
				</a>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
				<?echo $row['pro_number']?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:300px;font-size:10px;">
				<?echo $row['customer_name']?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:300px;font-size:10px;">
				<?echo $row['carrier_name']?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
				<?echo $row['invoice_date']?>
			</td >
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:350px;font-size:10px;">
				<?echo $row['shipper_name']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
				<?echo $row['shipper_state']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:300px;font-size:10px;">
				<?echo $row['consignee_name']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
				<?echo $row['consignee_state']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:50px;font-size:10px;">
				<?echo $row['pallets']?>
			</td>	
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
				<?
					$weight = $row['weight'];
					$min_weight = $row['min_weight'];
					$max_weight = $row['max_weight'];
					
					if($tab == 2){
						if($weight < $min_weight || $weight > $max_weight){
							echo "<font style='color:red'>".number_format($weight)." lbs</font>";
						}else{
							echo number_format($weight)." lbs";
						}
					}else{
							echo number_format($weight)." lbs";
					}
				?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:200px;font-size:10px;">
				<?
					$price = $row['gross_amount'];
					$min_price = $row['min_price'];
					$max_price = $row['max_price'];
					
					if($tab == 2){
							if($price < $min_price || $price > $max_price){
								echo "<font style='color:red'>$" .$price. "</font>";
							}else{
								echo "$". $price;
							}
					}else{
							echo "$". $price;
					}
				?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:200px;font-size:10px;">
				<?echo $row['BOL']?>
			</td>
			<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
				<?echo $status?>
			</td >
			<td class="multiselect" style="border:1px solid; border-color:#A4A4A4;text-align:center;width:50px;font-size:10px;">
				<?
					switch($row['status']){
						case 1:
							$process_button="<input type='checkbox' name='approve_items[]' id='approve_items' 
											 value='apv_".$row['line_item_id']."' />";
						break;
						case 2:
							$process_button="<input type='checkbox' name='invoice_items[]' id='invoice_items' 
											 value='inv_".$row['line_item_id']."'/>";
						break;
						default:
							$process_button = "";
					}
					echo $process_button;
				?>
			</td>
		</tr>
	<?
	}
	?>
		</tbody>
		<tfoot>
	<?
		$totals_query = mysql_query($sql_statement,$con);
		while($row_total = mysql_fetch_array($totals_query)){
			$total_pallets[] = $row_total['pallets'];
			$total_weight[] = $row_total['weight'];
			$total_amount[] = $row_total['gross_amount'];
		}
	?>
		<tr>
			<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			<td style="text-align:center;width:100px;font-size:10px;font-weight:bold;">
					TOTALS:
			</td>
			<td style="text-align:center;width:50px;font-size:10px;font-weight:bold;">
				<?echo  number_format(array_sum($total_pallets));?>
			</td>
			<td style="text-align:center;width:100px;font-size:10px;font-weight:bold;">
				<?echo  number_format(array_sum($total_weight))." lbs";?>
			</td>
			<td style="text-align:center;width:200px;font-size:10px;font-weight:bold;">
				<?echo "$". number_format(array_sum($total_amount),2,'.',',');?>
			</td>
			<td></td><td></td><td></td>
		</tr>
		</tfoot>
	</table>
	<?
	}
}

function srcl_1st_tab($sql){
	include('includes/connect.php');
	//echo $sql;
	$query = mysql_query($sql,$con);
	if(mysql_num_rows($query) != 0){
	?>
	
	<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
			<tr>
				<th style="font-size:10px;font-weight:bold;">
					SRCL invoice #
				</th>
				<th style="font-size:10px;font-weight:bold;">
					SRCL Invoice Total
				</th>
				<th style="font-size:10px;font-weight:bold;">
					Date
				</th>
				<th style="font-size:10px;font-weight:bold;width:20px;">
					<?//echo "<input type='button' class='check' value='check all'/>";?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?
			while($row = mysql_fetch_array($query)){
			?>
				<tr>
					<td style="border:1px solid; border-color:#A4A4A4;text-align:center;font-size:10px;">
						<?echo $row['srcl_inv_id'];?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
						<?echo "$".$row['total'];?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
						<?echo $row['srcl_inv_date'];?>
					</td>
					<td class="multiselect" style="border:1px solid; border-color:#A4A4A4;text-align:center;width:20px;font-size:10px;">
						<?echo "<input type='checkbox' name='invoice_items[]' id='invoice_items' value='".$row['srcl_inv_id']."'/>";?>	
					</td>
				</tr>
			<?
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td></td><td></td><td></td><td></td>
			</tr>
		</tfoot>
	</table>
	<?
	}else{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:500px;margin-top:50px;'><center>No results.</center></div></center>";	
	}
}


function srcl_2nd_tab($sql){
	include('includes/connect.php');
	$query = mysql_query($sql,$con);
	if(mysql_num_rows($query) != 0){
	?>
	<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
			<tr>
				<th style="font-size:10px;font-weight:bold;">
					SRCL invoice #
				</th>
				<th style="font-size:10px;font-weight:bold;">
					Carrier
				</th>
				<th style="font-size:10px;font-weight:bold;">
					 Total Amount
				</th>
				<th style="font-size:10px;font-weight:bold;">
					 Number of Shipments
				</th>
				<th style="font-size:10px;font-weight:bold;">
					Date
				</th>
			</tr>
		</thead>
		<tbody>
		<?
		while($row = mysql_fetch_array($query)){
		?>
			<tr>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
					<?echo $row['srcl_inv_id']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
					<?echo $row['carrier_name']?>
				</td >
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
					<?echo "$".$row['total']?>
				</td >
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
					<?echo $row['shipments']?>
				</td >
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
					<?echo $row['srcl_inv_date']?>
				</td >
			</tr>
		<?
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<td></td><td></td><td></td><td></td><td></td>
			</tr>
		</tfoot>
	</table>
	<?
	}else{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:500px;margin-top:50px;'><center>No results.</center></div></center>";	
	}
}

function srcl_3rd_tab($sql){
	include('includes/connect.php');
	$query = mysql_query($sql,$con);
	if(mysql_num_rows($query) != 0){
	?>
	<table width="100%" class="display" id="example" cellspacing="0">
		<thead>
			<tr>
				<th style="font-size:10px;">
					SRC Invoice #
				</th>
				<th style="font-size:10px;">
					Pro Number
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
					Pallets
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
		while($row=mysql_fetch_array($query)){	
		?>
			<tr>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
					<?echo $row['srcl_inv_num']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
					<?echo $row['pro_number']?>
				</td >
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:300px;font-size:10px;">
					<?echo $row['carrier_name']?>
				</td >
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:150px;font-size:10px;">
					<?echo $row['srcl_inv_date']?>
				</td >
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:350px;font-size:10px;">
					<?echo $row['shipper_name']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
					<?echo $row['shipper_state']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:300px;font-size:10px;">
					<?echo $row['consignee_name']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
					<?echo $row['consignee_state']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:50px;font-size:10px;">
					<?echo $row['pallets']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:100px;font-size:10px;">
					<?echo $row['weight']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:200px;font-size:10px;">
					<?echo $row['gross_amount']?>
				</td>
				<td style="border:1px solid; border-color:#A4A4A4;text-align:center;width:200px;font-size:10px;">
					<?echo $row['BOL']?>
				</td>
			</tr>
		<?
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
			</tr>
		</tfoot>
	</table>
	<?
	}else{
			echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:500px;margin-top:50px;'><center>No results.</center></div></center>";	
	}
}

?>