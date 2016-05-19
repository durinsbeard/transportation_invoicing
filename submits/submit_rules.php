<?
include('../includes/connect.php');
if (isset($_POST['apply_rules']) && $_POST['customer_only'] != "NULL" )
{
	$customer=mysql_real_escape_string($_POST['customer_only']);
	$min_price=mysql_real_escape_string($_POST['min_price']);
	$max_price=mysql_real_escape_string($_POST['max_price']);
	$min_weight=mysql_real_escape_string($_POST['min_weight']);
	$max_weight=mysql_real_escape_string($_POST['max_weight']);
	
	$sql_check_dups = "select customer_id from min_max where customer_id = '".$customer."' AND carrier_id = 0";
	$check_dups = mysql_query($sql_check_dups,$con);
	
	if(mysql_num_rows($check_dups) == 0)
	{
		
		
		$sql_min_max = "INSERT  INTO min_max(min_weight,max_weight,min_price,max_price,customer_id)
						VALUES ('" .$min_weight. "','" .$max_weight. "','" .$min_price. "','" .$max_price. "','" .$customer. "')";
		
		if(mysql_query($sql_min_max,$con))
		{
			$sql_update_status="UPDATE dayton SET status = 
								CASE	
									WHEN weight NOT BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									OR gross_amount NOT BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 1
									WHEN weight  BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									AND gross_amount  BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 2
									ELSE status
								END
								WHERE customer_id = '" .$customer. "' and carrier_id = 0";
			
			if(mysql_query($sql_update_status,$con))
			{
				header('Location: ../index.php?form=create_rules&message=1&select_rules=1');
				
			}else
			{
				header('Location: ../index.php?form=create_rules&message=2&select_rules=1');
			}
		}
			
			
	}else if(mysql_num_rows($check_dups) > 0)
	{ 
			$sql = "UPDATE min_max SET min_weight = '" .$min_weight. "' , max_weight = '" .$max_weight. "', min_price = '" .$min_price. "',
					max_price = '" .$max_price. "' WHERE customer_id = '" .$customer. "' AND carrier_id = 0";
		
			if(mysql_query($sql,$con))
			{
				$sql_update_status="UPDATE dayton SET status = 
									CASE	
										WHEN weight NOT BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
										OR gross_amount NOT BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 0
										WHEN weight  BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
										AND gross_amount  BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 2
										ELSE status
									END
									WHERE customer_id = '" .$customer. "' and carrier_id = 0";
				if(mysql_query($sql_update_status,$con))
				{
					header('Location: ../index.php?form=create_rules&message=1&select_rules=1');
					
				}else
				{
					header('Location: ../index.php?form=create_rules&message=2&select_rules=1');
				}
			}
	}	
	
}else if (isset($_POST['apply_rules']) && $_POST['carrier_only'] != "NULL")
{
	$carrier=mysql_real_escape_string($_POST['carrier_only']);
	$min_price=mysql_real_escape_string($_POST['min_price']);
	$max_price=mysql_real_escape_string($_POST['max_price']);
	$min_weight=mysql_real_escape_string($_POST['min_weight']);
	$max_weight=mysql_real_escape_string($_POST['max_weight']);
	$states=mysql_real_escape_string($_POST['states[]']);
	
	$sql_check_dups = "select * from min_max where carrier_id = '".$carrier."' AND customer_id = 0";
	$check_dups = mysql_query($sql_check_dups,$con);
	if(mysql_num_rows($check_dups) == 0)
	{
		$sql = "INSERT  INTO min_max(min_weight,max_weight,min_price,max_price,carrier_id)
				VALUES ('" .$min_weight. "','" .$max_weight. "','" .$min_price. "','" .$max_price. "','" .$carrier. "')";
		
		if(mysql_query($sql,$con))
		{
			$sql_update_status="UPDATE dayton SET status = 
								CASE	
									WHEN weight NOT BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									OR gross_amount NOT BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 0
									WHEN weight  BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									AND gross_amount  BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 2
									ELSE status
								END
								WHERE carrier_id = '" .$carrier. "' and customer_id = 0";
			if(mysql_query($sql_update_status,$con))
			{
				header('Location: ../index.php?form=create_rules&message=1&select_rules=2');
				
			}else
			{
				header('Location: ../index.php?form=create_rules&message=2&select_rules=2');
			}
		}
	}else if(mysql_num_rows($check_dups) != 0)
	{
		$sql = "UPDATE min_max SET min_weight = '" .$min_weight. "' ,max_weight = '" .$max_weight. "',min_price = '" .$min_price. "'
				,max_price = '" .$max_price. "' WHERE carrier_id = '" .$carrier. "' AND customer_id = 0";
				
		if(mysql_query($sql,$con))
		{
			$sql_update_status="UPDATE dayton SET status = 
								CASE	
									WHEN weight NOT BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									OR gross_amount NOT BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 0
									WHEN weight  BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									AND gross_amount  BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 2
									ELSE status
								END
								WHERE carrier_id = '" .$carrier. "' and customer_id = 0";
			if(mysql_query($sql_update_status,$con))
			{
				header('Location: ../index.php?form=create_rules&message=3&select_rules=2');
				
			}else
			{
				header('Location: ../index.php?form=create_rules&message=2&select_rules=2');
			}
		}
		
	}
}else if (isset($_POST['apply_rules']) && $_POST['customer'] != "NULL" &&  $_POST['carrier'] != "NULL")
{
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
			
			
	echo $sql;
	if(mysql_query($sql,$con))
	{
		$sql = "INSERT  INTO min_max(min_weight,max_weight,min_price,max_price,carrier_id,customer_id)
				VALUES ('" .$min_weight. "','" .$max_weight. "','" .$min_price. "','" .$max_price. "','" .$carrier. "','".$customer."')";
		
		if(mysql_query($sql,$con))
		{
			$sql_update_status="UPDATE dayton SET status = 
								CASE	
									WHEN weight NOT BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									OR gross_amount NOT BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 0
									WHEN weight  BETWEEN '" .$min_weight. "' AND '" .$max_weight. "' 
									AND gross_amount  BETWEEN '" .$min_price. "' AND '" .$max_price. "' THEN 2
									ELSE status
								END
								WHERE customer_id = '" .$customer. "' and carrier_id = '".$carrier."'";
			if(mysql_query($sql_update_status,$con))
			{
				for($f=0;$f<=$num_states; $f++)
				{
					$sql_states = "INSERT  INTO carriers_states(carrier_id,state_id)
							       VALUES ('" .$carrier. "','" .$states[$f]."')";
					if(mysql_query($sql,$con))
					{
						header('Location: ../index.php?form=create_rules&message=1&select_rules=3');
					}else
					{
						header('Location: ../index.php?form=create_rules&message=2&select_rules=1');
					}
				}
				
			}else
			{
				header('Location: ../index.php?form=create_rules&message=2&select_rules=1');
			}
		}
	}else
	{
		header('Location: ../index.php?form=create_rules&message=1&select_rules=3');
	}
}
?>