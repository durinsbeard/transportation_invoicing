<?
include('includes/connect.php');
$user = $_REQUEST['user'];
$inv_id = $_REQUEST['inv_id'];
$orig_weight = $_REQUEST['orig_weight'];
$new_weight = $_REQUEST['new_weight'];
$orig_amount = $_REQUEST['orig_amount'];
$new_amount = $_REQUEST['new_amount'];
$line_item_id = $_REQUEST['line_item_id'];
$notes = $_REQUEST['notes'];

$customer = $_REQUEST['customer'];
$carrier = $_REQUEST['carrier'];
$invoice = $_REQUEST['invoice'];
$begin_date = $_REQUEST['begin_date'];
$end_date = $_REQUEST['$end_date'];

$update_sql="UPDATE dayton SET weight = '".$new_weight."', gross_amount = '".$new_amount."' 
			 WHERE line_item_id = '".$line_item_id."'";

if(mysql_query($update_sql,$con)){
	$insert_history_table="INSERT INTO history_table(inv_id,u_id,orig_weight,new_weight,orig_amount,new_amount,notes) 
						   VALUES ('".$inv_id."','".$user."','".$orig_weight."','".$new_weight."','".$orig_amount."','".$new_amount."','".$notes."')";
	//echo $insert_history_table;
	if(mysql_query($insert_history_table,$con)){
		header('Location: index.php?form=reporting&customer='.$customer.'&carrier='.$carrier.'&invoice='.$invoice.'&from='.$begin_date.'&to='.$end_date.'');
	}
}
?>