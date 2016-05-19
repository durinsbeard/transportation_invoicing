<?
include("includes/connect.php");

$sql_num_rows = "select line_item_id,statement_number,customer_id,carrier_id from dayton";
		$query_num_rows = mysql_query($sql_num_rows,$con);
		//$num_rows = mysql_num_rows($query_num_rows);
		//echo $num_rows;
		
		
		$customer_id = array("0","1","2","3","4","5","6","7","8","9","0","0","0","0","0","0","0","0","0","0","0","0","1","2","3","4","5","6","7","8","9");
		$carrier_id = array("0","0","0","0","0","0","0","0","0","0","0","8","7","6","5","4","3","2","1","8","7","6","5","4","3","2","1");
		
		$j=0;
		//$cust=0;
		//$car=0;
		while($row = mysql_fetch_array($query_num_rows)){
			
			/*for($k=0; $k<count($customer_id); $k++){
				$cust++;
				$sql_cust_id = "UPDATE dayton SET customer_id = '" .$customer_id[$k]. "'
								WHERE line_item_id = '". $cust."'";
				$update_cust = mysql_query($sql_cust_id.$con);
			}
			
			for($j=0; $j<count($carrier_id); $j++){
				$car++;
				$sql_car_id = "update dayton set carrier_id = '" .$carrier_id[$j]. "'
								where line_item_id = '". $car."'";
				$update_car = mysql_query($sql_car_id,$con);
			}*/
	
					$sql="UPDATE dayton 
						  JOIN min_max ON
						  dayton.customer_id = min_max.customer_id
						  AND dayton.carrier_id = min_max.carrier_id
						  SET status = 1 WHERE weight NOT BETWEEN (SELECT min_weight from min_max)
						  AND (SELECT max_weight FROM min_max)
			}
			
			$sql="UPDATE dayton 
				  SET INVOICE_NUMBER = CONCAT(STATEMENT_NUMBER,'-','" .$J++. "'),
				  SET STATUS =
								CASE	
									WHEN WEIGHT NOT BETWEEN (SELECT MIN_WEIGHT FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']."' OR CARRIER_ID = '".$ROW['CARRIER_ID']."') 
										 AND (SELECT MAX_WEIGHT FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']."' 
											  OR CARRIER_ID = '".$ROW['CARRIER_ID'].")
										 OR GROSS_AMOUNT NOT BETWEEN (SELECT MIN_PRICE FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']." 
																	  OR CARRIER_ID = '".$ROW['CARRIER_ID']."') 
										 AND (SELECT MAX_PRICE FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']."' 
											  OR CARRIER_ID = '".$ROW['CARRIER_ID'].") THEN 1
									WHEN WEIGHT  BETWEEN (SELECT MIN_WEIGHT FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']." 
														  OR CARRIER_ID = '".$ROW['CARRIER_ID']."')
										 AND (SELECT MAX_WEIGHT FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']." 
											  OR CARRIER_ID = '".$ROW['CARRIER_ID']."') 
										 AND GROSS_AMOUNT  BETWEEN (SELECT MIN_PRICE FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']." 
																	OR CARRIER_ID = '".$ROW['CARRIER_ID']."') 
										 AND (SELECT MAX_PRICE FROM MIN_MAX WHERE CUSTOMER_ID = '".$ROW['CUSTOMER_ID']."' 
											  OR CARRIER_ID = '".$ROW['CARRIER_ID'].") THEN 2
									ELSE STATUS
								END
					WHERE LINE_ITEM_ID = '".$ROW['LINE_ITEM_ID']."'";
			$UPDATE = MYSQL_QUERY($SQL,$CON);
			
			
		
		}
?>