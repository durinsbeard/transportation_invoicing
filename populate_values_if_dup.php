<?
include('includes/connect.php');

if(isset($_POST['customer']) && !isset($_POST['carrier']))
{
	$customer = mysql_real_escape_string($_POST['customer']);
	$result = mysql_query("SELECT min_weight, max_weight, min_price, max_price from min_max where customer_id = '".$customer."' AND carrier_id = 0");
	$array = mysql_fetch_array($result);
	echo json_encode($array);
}else if(isset($_POST['carrier']))
{
	$carrier = mysql_real_escape_string($_POST['carrier']);
	//$result = mysql_query("SELECT min_weight, max_weight, min_price, max_price from min_max where carrier_id = '".$carrier."' AND customer_id IS NULL");
	$result = mysql_query("SELECT  min_weight, 
								   max_weight,
								   min_price,
								   max_price,
								   cs.carrier_id,
								   cs.state_id
                            FROM min_max as mm
							LEFT JOIN (select carrier_id, state_id from carriers_states) 
							AS cs ON cs.carrier_id = mm.carrier_id
							WHERE mm.carrier_id = '".$carrier."' AND mm.customer_id = 0");
							//AND cs.state_id != 0
	$array = mysql_fetch_array($result);
	echo json_encode($array);
}


?>