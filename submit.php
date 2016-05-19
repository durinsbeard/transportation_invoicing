<?			
			$customer = mysql_real_escape_string($_POST['customer']);
			$carrier = mysql_real_escape_string($_POST['carrier']);
			$invoice = mysql_real_escape_string($_POST['invoice']);
			$status = mysql_real_escape_string($_POST['status']);
			$from = mysql_real_escape_string($_POST['from']);
			$to = mysql_real_escape_string($_POST['to']);
			
			
			$sqlStart="UPDATE assets SET ";
			$sql="";
			if(!empty($wired)){$sql .= " wired_mac_address='" .$wired. "',";}
			if(!empty($wireless)){$sql .= " wireless_mac_address='" .$wireless. "',";}
			if(!empty($subnet)){$sql .= " ip_prefix_id='" .$subnet. "',";}
			if(!empty($sql))
			{
				 $sql = substr($sql, 0, -1);
				 $sql .= " WHERE asset_tag = '" .$tag. "'";
				 $sqlCommand = $sqlStart.$sql;  
			
				if(mysql_query($sqlCommand,$con))
				{
				$sql = "UPDATE  ip_suffixes SET active = 0 where suffix = '" .$lastOctet. "'";
				mysql_query($sql,$con);
				header('Location: index.php?form=editasset');
				}
				else
				{
					die('Could not insert data. ' . mysql_error());;
					
				}
			}
			
		}
?>		