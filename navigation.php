<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/navigation.css"/>
<nav style="margin-top:-20px;">
<nav>
	<div class="menu-item alpha">
	  <!--<h4><a href="#" style="font-size:12px;">Home</a></h4>-->
	</div>
	<div class="menu-item upload_file" >
	  <h4><a href="?form=upload_file&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">Upload File</a></h4>
	</div>
	<div class="menu-item mangage_users" >
	  <h4><a href="?form=manage_users&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">User Mgt.</a></h4>
	</div>
	<div class="menu-item add_item" >
	  <h4><a href="?form=manage_customers_carriers&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">Customer/Carrier Mgt.</a></h4>
	</div>
	<div class="menu-item create_rules">
		  <h4><a href="?form=create_rules&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">Create Reporting Rules</a></h4>
		  <ul>
			<!--<li><a href="?form=customer_to_carrier_rules" style="font-size:10px;">Create Reporting Rules</a></li>
			<!--<li><a href="#">Create User</a></li>
			<li><a href="#">Create Customer</a></li>
			<li><a href="#">Create Carrier</a></li>
			<li><a href="#">Assign carrier to customer</a></li>-->
		  </ul>
	</div>
	<div class="menu-item reporting">
	  <h4><a href="#" style="font-size:12px;">Reporting</a></h4>
		<ul>
			<li><a style="font-size:10px;" href="?form=reporting&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">Line Item Report</a></li>
			<li><a style="font-size:10px;" href="?form=carrier_reporting&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">A/P Report</a></li>
			<li><a style="font-size:10px;" href="?form=change_log&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" >Change Log Report</a></li>
			<!--<li><a href="#">Create Customer</a></li>
			<li><a href="#">Create Carrier</a></li>
			<li><a href="#">Assign carrier to customer</a></li>-->
		  </ul>
	</div>
	<!--<div class="menu-item reports" >
	  <h4><a href="#" >Reports</a></h4>
	  <ul>
		<li><a href="?form=alphabeticalTabs&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>">Assigned Assets</a></li>
		<li><a href="?form=asset_summary&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>">Asset Summary</a></li>
		<li><a href="?form=list_assets&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>">All Assets</a></li>
		<li><a href="?form=list_users&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>">List of Users</a></li>
	  </ul>
	</div>-->
	<div class="menu-item change_password" >
	  <h4><a href="?form=change_password&user=<?echo preg_replace('/[^A-Za-z0-9\-]/', '', $user)?>" style="font-size:12px;">Change Password</a></h4>
	</div>
	<div class="menu-item logout" >
	  <h4><a href="?form=log_out" style="font-size:12px;">Log Out</a></h4>
	</div>
	
</nav>
</nav>	
	
