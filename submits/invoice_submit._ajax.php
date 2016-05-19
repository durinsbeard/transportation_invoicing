<?
include('../includes/connect.php');
if (isset($_POST['stuff']))
{
	$stuff = $_POST['stuff'];
	//$line_items=unserialize(base64_decode($_REQUEST['invoice_line_items']));
	$stuff=json_decode("$stuff",true);
	echo $stuff;
	/*$sql="UPDATE dayton set status = 3 WHERE line_item_id IN (".$line_items.")"; 
	if(mysql_query($sql,$con))
	{
		echo $line_items;
	}else{
		echo "update failed";
	}*/
}
?>