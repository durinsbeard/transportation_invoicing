<?
include("includes/connect.php");

$sql_num_rows = "select line_item_id,customer_id,carrier_id from dayton
				 where customer_id = 0 and carrier_id = 0";
$query_num_rows = mysql_query($sql_num_rows,$con);
//$num_rows = mysql_num_rows($query_num_rows);
//echo $num_rows;
$customer_id = array("0","1","2","3","4","5","6","7","8","9");
$carrier_id = array("8","7","6","5","4","3","3","1","0");
$cust=0;
$car=0;
while($row = mysql_fetch_array($query_num_rows)){
	
	echo $row['line_item_id'];
	
	for($k=0; $k<count($customer_id); $k++){
		$cust++;
		$sql_cust_id = "update dayton set customer_id = '" .$customer_id[$k]. "'
						where line_item_id = '". $cust."'";
		$update_cust = mysql_query($sql_cust_id);
		
		
	}
	
	for($j=0; $j<count($carrier_id); $j++){
		$car++;
		$sql_car_id = "update dayton set carrier_id = '" .$carrier_id[$j]. "'
						where line_item_id = '". $car."'";
		$update_car = mysql_query($sql_car_id);
		
		
	}
	
	
		
	
}
	
	
	
?>