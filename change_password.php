<script>

</script>
<?
	if(isset($_GET['message'])){
		
		if($_GET['message']==1){
			echo "<center>
					<div id='message'  style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:
						 20px;font-family:arial;color:white;'>
						 <center>
							Successfully updated password.
						</center>
					</div>
				 </center>";	
		}else if($_GET['message']==2){
			echo "<center>
					<div id='message' style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;
						 height:25px;font-size:20px;font-family:arial;'>
						 <center>
							The old password does not match the one on file.
						 </center>
					</div>
				  </center>";	
			
		}else if($_GET['message']==3){
			echo "<center>
					<div id='message' style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;
							 height:25px;font-size:20px;font-family:arial;'>
						<center>
							There was an error(3) changeing password. Please contact support.
						</center>
					</div>
				  </center>";
		}
	}
?>
<form id="password" action="submits/password_change.php" method="post">
	<table id="logIn">
		<tr>
			<td>
				Old Password:
			</td>
			<td>
				<input type="password" name="old"  id="old" size="30"/>
			</td>
		</tr>
		<tr>
			<td>
				New Password:
			</td>
			<td>
				<input type="password" name="new"  id="new" size="30"/>
			</td>
		</tr>
		<tr>
			<td>
				Confirm Password:
			</td>
			<td>
				<input type="password" name="confirm_new"  id="confirm_new" size="30"/>
			</td>
		</tr>
	</table>
	<center>
		<input  id="submit" name="submit" type="submit" value="SUBMIT" class="wide" style="margin-top:10px;margin-left:-7%"/>
		<input type="hidden" name="user" value="<?echo $_GET["user"]?>">
	</center>
</form>

