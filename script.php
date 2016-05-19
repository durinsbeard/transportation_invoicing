<?
include('includes/connect.php');
$line_item_id = json_decode(stripslashes($_POST['data']));

  // here i would like use foreach:

  
  
  //echo $sql;

 foreach($line_item_id as $d){
      $sql="UPDATE dayton SET status = 3 WHERE line_item_id = '".$d."'"; 
	  $update_status = mysql_query($sql,$con);
	  echo $sql;//echo $d;
  }
  
?>