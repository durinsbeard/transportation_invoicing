<?session_start();?>
<html>
	<head>
		<title>
			Invoice Audit
		</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link type="text/css" rel="stylesheet" href="css/style.css" />
		<link href="css/js/jquery-ui.css" rel="stylesheet">
		
		<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
		<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
		<script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
	    <script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<style>
			@media only screen 

				and (min-device-width : 320px) 

				and (max-device-width : 480px) {

				.form-label-top {

				width: 250px !important;

				font-size: 12px !important;

				}

				.form-header {

				width: 250px !important;

				font-size: 14px !important;

				}

				}

		</style>
		<script>
			$(document).ready(function() { 
				$("#tabs").tabs({
					"activate": function(event, ui){
					$( $.fn.dataTable.tables( true )).DataTable().columns.adjust();
					}	
				});
				$("#example").tablesorter();
			}); 
			function changeHeader(header){
				document.getElementById("Header").innerHTML = "" + header;
			}
		</script> 
	</head>
	<div id="Header"></div>
	<body>
		<img width="10%" style="margin-left:15%;margin-top:5px" src="images/src_logo_clear.gif">
			<div id="Container">
				<div id="LeftNav">
				<?
					if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] != ""){
						include("navigation.php");
					}
				?>
				</div>
				<div class="Content">
					
				<?
					if(!isset($_GET['form'])){
						$form = "";
						echo '<form action="login_check.php" method="post">';
						
					}else{
						$form = $_GET['form'];
						echo '<form method="post" enctype="multipart/form-data">';
					}
					SWITCH ($form){
						CASE "upload_file":
							include('upload_file.php');
							?><script>changeHeader("<h1><b>Upload File</b></h1>")</script><?
							break;
						CASE "manage_users":
							include("manage_users.php");
							?><script>changeHeader("<h1><b>Manage Users</b></h1>")</script><?
							break;
						CASE "manage_customers_carriers":
							include('manage_customers_carriers.php');
							?><script>changeHeader("<h1><b>Manage Customers</b></h1>")</script><?
							break;
						CASE "create_rules":
							include('create_rules.php');
							?><script>changeHeader("<h1><b>Create Rules</b></h1>")</script><?
							break;
						CASE "reporting":
							include('reporting_new.php');
							?><script>changeHeader("<h1><b>Line Item Report</b></h1>")</script><?
							break;
						CASE "invoice_report":
							include('invoice_report.php');
							?><script>changeHeader("<h1><b>Invoice Report</b></h1>")</script><?
							break;
						CASE "carrier_reporting":
							include('client_reporting.php');
							?><script>changeHeader("<h1><b>Carrier Reporting</b></h1>")</script><?
							break;
						CASE "change_log":
							include('changelog_report.php');
							?><script>changeHeader("<h1><b>Change Log Report</b></h1>")</script><?
							break;
						CASE "change_password":
							include('change_password.php');
							?><script>changeHeader("<h1><b>Change Password</b></h1>")</script><?
							break;
						CASE "log_out":
							include('log_out.php');
							?><script>changeHeader("<h1><b>Log Out</b></h1>")</script><?
							break;
						DEFAULT:
							include('login.php');
					}			
			    ?>	
					</form>
				</div>
			</div>
	</body>
</html>
	