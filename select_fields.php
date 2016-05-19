	<?
			include('includes/connect.php');
			$table = ($_GET['table']);	
				$sqlFields = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'transportation' AND TABLE_NAME = '".$table."'";
				$queryFields = mysql_query($sqlFields,$con);
			while($rowFields=mysql_fetch_array($queryFields))
			{
				if($firstInitial!=substr(strtoupper($rowFields['COLUMN_NAME']),0,1))
				{
					
					echo '<label><b><font size="5" >'. substr(strtoupper($rowFields['COLUMN_NAME']),0,1).'</font></b></label>';
				}      
				?>
				  <label><input type="checkbox" name="option[]" id="states" value="<? echo$rowFields['COLUMN_NAME']?>" /><? echo$rowFields['COLUMN_NAME']?></label>
				 
				<?
				
				
					$firstInitial=strtoupper(substr($rowFields['COLUMN_NAME'],0,1));
			}
			?>