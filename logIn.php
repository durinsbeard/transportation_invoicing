<script>
	$(document).ready(function() {
		$("#username").focus();
		//$('#myTable').tablesorter();
	});
</script>
<?php
	$value = "";
	if(isset($_GET['error']))
	{
		$value = "<div style='color:black; font-size:20px; margin:0 auto; width:350px; height:30px;'>Error Logging in; please check user name and password and try again.</div>";
	}
	echo $value;
?>
<br/><br/>

	<table id="logIn" >
		<tr>
			<td>
				User Name:
			</td>
			<td>
				<input autofocus id="uname" name="uname" type="text" id="uname" size="20" />
			</td>
		</tr>
		<tr>
			<td>
				Password:
			</td>
			<td>
				<input id="password" name="password" type="password" id="password" size="20" />
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<center><input type="submit" value="LOGIN" class="wide"/></center>
			</td>
	</table>

