<?
include('../includes/connect.php');
if (isset($_POST['apply_rules']) && $_POST['customer_only'] != "NULL" ){
	$customer=mysql_real_escape_string($_POST['customer_only']);
	$min_price=mysql_real_escape_string($_POST['min_price']);
	$max_price=mysql_real_escape_string($_POST['max_price']);
	$min_weight=mysql_real_escape_string($_POST['min_weight']);
	$max_weight=mysql_real_escape_string($_POST['max_weight']);
	$user=mysql_real_escape_string($_POST['user']);
	
	$sql_check_dups = "select customer_id from min_max where customer_id = '".$customer."' AND carrier_id IS NULL";
	$check_dups = mysql_query($sql_check_dups,$con);
	
	if(mysql_num_rows($check_dups) == 0){
		$sql = "INSERT  INTO min_max(min_weight,max_weight,min_price,max_price,customer_id)
				VALUES ('" .$min_weight. "','" .$max_weight. "','" .$min_price. "','" .$max_price. "','" .$customer. "')";
		if(mysql_query($sql,$con)){
				if(mysql_query($sql,$con)){
				$chk_thresh="select line_item_id,gross_amount,weight from dayton where customer_id = '".$customer."'";
				$values=mysql_query($chk_thresh,$con);
				while($val=mysql_fetch_array($values)){
					if($val["gross_amount"]<$min_price||$val["gross_amount"]>$max_price||$val["weight"]<$min_weight||$val["weight"]>$max_weight){
						$sql="UPDATE dayton SET status = 1 WHERE  line_item_id = '".$val["line_item_id"]."'";
						
						echo $sql_rej."<br>";
					}else{
						$sql="UPDATE dayton SET status = 2 WHERE  line_item_id = '".$val["line_item_id"]."'";
						
						
					}
					
					echo $sql."<br>";
					mysql_query($sql,$con);
				}
		}else{
			header('Location: http://SL222/transportation_invoicing/index.php?form=create_rules&message=2&select_rules=1&user='.$user.'');
		}
	}else if(mysql_num_rows($check_dups) != 0){
		$sql = "UPDATE min_max SET min_weight = '" .$min_weight. "' , max_weight = '" .$max_weight. "', min_price = '" .$min_price. "',
			    max_price = '" .$max_price. "' WHERE customer_id = '" .$customer. "' AND carrier_id IS NULL";
				
		if(mysql_query($sql,$con)){
				$chk_thresh="select line_item_id,gross_amount,weight from dayton where customer_id = '".$customer."'";
				$values=mysql_query($chk_thresh,$con);
				while($val=mysql_fetch_array($values)){
					if($val["gross_amount"]<$min_price||$val["gross_amount"]>$max_price||$val["weight"]<$min_weight||$val["weight"]>$max_weight){
						$sql="UPDATE dayton SET status = 1 WHERE  line_item_id = '".$val["line_item_id"]."'";
						
						echo $sql_rej."<br>";
					}else{
						$sql="UPDATE dayton SET status = 2 WHERE  line_item_id = '".$val["line_item_id"]."'";
						
						
					}
					
					echo $sql."<br>";
					mysql_query($sql,$con);
				}
				
		}else{
			header('Location: http://SL222/transportation_invoicing/index.php?form=create_rules&message=2&select_rules=2&user='.$user.'');	
		}
		
	}
}else if (isset($_POST['apply_rules']) && $_POST['carrier_only'] != "NULL"){
	$carrier=mysql_real_escape_string($_POST['carrier_only']);
	$min_price=mysql_real_escape_string($_POST['min_price']);
	$max_price=mysql_real_escape_string($_POST['max_price']);
	$min_weight=mysql_real_escape_string($_POST['min_weight']);
	$max_weight=mysql_real_escape_string($_POST['max_weight']);
	$states=mysql_real_escape_string($_POST['states[]']);
	
	$sql_check_dups = "select * from min_max where carrier_id = '".$carrier."' AND customer_id IS NULL";
	$check_dups = mysql_query($sql_check_dups,$con);
	if(mysql_num_rows($check_dups) == 0){
		$sql = "INSERT  INTO min_max(min_weight,max_weight,min_price,max_price,carrier_id)
				VALUES ('" .$min_weight. "','" .$max_weight. "','" .$min_price. "','" .$max_price. "','" .$carrier. "')";
		if(mysql_query($sql,$con)){
			header('Location: http://localhost/transportation_invoicing/index.php?form=create_rules&message=1&select_rules=2&user='.$user.'');
		}else{
			header('Location: http://localhost/transportation_invoicing/index.php?form=create_rules&message=2&select_rules=2&user='.$user.'');
		}
	}else if(mysql_num_rows($check_dups) != 0){
			$sql = "UPDATE min_max SET min_weight = '" .$min_weight. "' ,max_weight = '" .$max_weight. "',min_price = '" .$min_price. "'
					,max_price = '" .$max_price. "' WHERE carrier_id = '" .$carrier. "' AND customer_id IS NULL";
				
		if(mysql_query($sql,$con)){
			header('Location: http://localhost/transportation_invoicing/index.php?form=create_rules&message=3&select_rules=2&user='.$user.'');
		}else{
			header('Location: http://localhost/transportation_invoicing/index.php?form=create_rules&message=2&select_rules=2&user='.$user.'');
		}
		
	}
}else if (isset($_POST['apply_rules']) && $_POST['customer'] != "NULL" &&  $_POST['carrier'] != "NULL"){
	$customer=mysql_real_escape_string($_POST['customer']);
	$carrier=mysql_real_escape_string($_POST['carrier']);
	$min_price=mysql_real_escape_string($_POST['min_price']);
	$max_price=mysql_real_escape_string($_POST['max_price']);
	$min_weight=mysql_real_escape_string($_POST['min_weight']);
	$max_weight=mysql_real_escape_string($_POST['max_weight']);
	$states[]=mysql_real_escape_string($_POST['states[]']);
	$num_states=mysql_real_escape_string($_POST['num_states']);
	
	$sql = "INSERT INTO carriers_customers(carrier_id,customer_id)
			VALUES ('" .$customer. "','" .$carrier. "')";
			
			

	if(mysql_query($sql,$con)){
		$sql = "INSERT  INTO min_max(min_weight,max_weight,min_price,max_price,carrier_id,customer_id)
				VALUES ('" .$min_weight. "','" .$max_weight. "','" .$min_price. "','" .$max_price. "','" .$carrier. "','".$customer."')";
		if(mysql_query($sql,$con)){
			for($f=0;$f<=$num_states; $f++){
				$sql = "INSERT  INTO carriers_states(carrier_id,state_id)
						VALUES ('" .$carrier. "','" .$states[$f]."')";
				if(mysql_query($sql,$con)){
					header('Location: http://localhost/transportation_invoicing/index.php?form=create_rules&message=1&select_rules=3&user='.$user.'');
				}else{
					die('Could not insert data inside. ' . mysql_error());
				}
			}
		}
	}else{
		header('Location: http://localhost/transportation_invoicing/index.php?form=create_rules&message=1&select_rules=3&user='.$user.'');
	}
}
?>