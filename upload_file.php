<?php  
include("includes/connect.php");

if ($_FILES[csv][size] > 0){ 
    //get the csv file 
    $file = $_FILES[csv][tmp_name]; 
    $handle = fopen($file,"r"); 
    //loop through the csv file and insert into database 
    do{ 	
		if ($data[0]){ 
			
           mysql_query(
						"INSERT INTO dayton 
		                                  (
										    customer_id,
										    carrier_id, 
											statement_number, 
											shipment_date, 
											pro_number,
											reference,
											BOL,
											shipper_name,
						                    shipper_city,
											shipper_state,
											shipper_zip_code,
											consignee_name,
											consignee_city,
											consignee_state,
						                    consignee_zip_code,
											pallets,
											class,
											weight,
											purchase_order,
											gross_amount,
											fuel_surcharge,
											discount_amount,
											net_amount,
						                    paid_to_date,
											store_number,
											invoice_date
										  ) 
						VALUES 
                              ( 
                                '".trim(addslashes($data[0]))."', 
                                '".trim(addslashes($data[1]))."', 
                                '".trim(addslashes($data[2]))."',
					            '".trim(addslashes($data[3]))."', 
                                '".trim(addslashes($data[4]))."', 
                                '".trim(addslashes($data[5]))."',
					            '".trim(addslashes($data[6]))."', 
                                '".trim(addslashes($data[7]))."', 
                                '".trim(addslashes($data[8]))."',
					            '".trim(addslashes($data[9]))."', 
                                '".trim(addslashes($data[10]))."', 
                                '".trim(addslashes($data[11]))."',
					            '".trim(addslashes($data[12]))."', 
                                '".trim(addslashes($data[13]))."', 
                                '".trim(addslashes($data[14]))."',
					            '".trim(addslashes($data[15]))."',
					            '".trim(addslashes($data[16]))."', 
                                '".trim(addslashes($data[17]))."', 
					            '".trim(addslashes($data[18]))."',
					            '".trim(addslashes($data[19]))."', 
                                '".trim(addslashes($data[20]))."',
					            '".trim(addslashes($data[21]))."',
					            '".trim(addslashes($data[22]))."',
					            '".trim(addslashes($data[23]))."',
					            '".trim(addslashes($data[24]))."',
					            '".trim(addslashes($data[25]))."'
			                 )"
					 ); 
			
        }else{
			 //echo mysql_error($con); 
			 header('Location: index.php?form=upload_file&message=2');
		}
    }while ($data = fgetcsv($handle,1000,",","'")); 
     
	$sql_num_rows = "SELECT line_item_id,
	                        statement_number,
							customer_id,
							carrier_id,
							weight,
							gross_amount 
					 FROM dayton";
	$query_num_rows = mysql_query($sql_num_rows,$con);
	//$num_rows = mysql_num_rows($query_num_rows);
	//echo $num_rows;
    $inv=0;
	while($row = mysql_fetch_array($query_num_rows)){
		//echo $row['line_item_id'];
		$sql_inv_num="UPDATE dayton SET inv_id = 
							CASE	
								WHEN statement_number = 0 THEN 'missing_data'
								WHEN statement_number != 0 THEN concat(statement_number,'-','" .$inv++. "')
								ELSE inv_id
							END
					  WHERE line_item_id = '".$row['line_item_id']."'";
		$update_inv_num = mysql_query($sql_inv_num,$con); 
		
		
		$sql_update_dspt_status="UPDATE dayton
								 JOIN min_max ON dayton.customer_id = min_max.customer_id
								 AND dayton.carrier_id = min_max.carrier_id
								 SET status = 1
								 WHERE dayton.weight NOT BETWEEN min_max.min_weight AND min_max.max_weight
								 OR dayton.gross_amount NOT BETWEEN min_max.min_price AND min_max.max_price
								 AND dayton.customer_id = '".$row['customer_id']."'
								 AND dayton.carrier_id = '".$row['carrier_id']."'";
		$update_dspt_status= mysql_query($sql_update_dspt_status,$con);
		
		$sql_update_aprv_status="UPDATE dayton
								 JOIN min_max ON dayton.customer_id = min_max.customer_id
								 AND dayton.carrier_id = min_max.carrier_id
								 SET status = 2
								 WHERE dayton.weight BETWEEN min_max.min_weight AND min_max.max_weight
								 AND dayton.gross_amount BETWEEN min_max.min_price AND min_max.max_price
								 AND dayton.customer_id = '".$row['customer_id']."'
								 AND dayton.carrier_id = '".$row['carrier_id']."'";
		$update_aprv_status= mysql_query($sql_update_aprv_status,$con);
	}  
 
    header('Location: index.php?form=upload_file&message=1'); die; 
} 
?> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
</head> 
<body> 
<?php 
	if ($_GET[message]==1){ 
		echo "<div id='message'  style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:
			  20px;font-family:arial;color:white;margin-left:21%;'><span style='margin-left:30%'>Your file has been imported.</span></div>";
			 
	}else if ($_GET[message]==2){
		echo "<center><div id='message' style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;
			  height:25px;font-size:20px;font-family:arial;'>
			  <center>There was an error uploading file. Please contact support.</center></div></center>";
	}
?> 
	<form action="" method="post" enctype="multipart/form-data" name="upload" id="upload"> 
		<div style="margin-left:35%;margin-top:15px;">
			<span style="margin-left:10%;margin-bottom:5px;">Upload CSV file:</span></br>
			<input style="width:300px" name="csv" type="file" id="csv" /> 
			<input style="margin-left:7.3%;margin-top:5px;" type="submit" name="Submit" value="UPLOAD" class="wide"/> 
		</div>
	</form> 
</body> 
</html> 