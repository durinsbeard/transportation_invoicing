<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="css/dataTables.jqueryui.css" rel="stylesheet">
<link href="css/dataTables.foundation.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">
<link href="css/jquery.dataTables.css" rel="stylesheet">
<link href="css/buttons.dataTables.min.css" rel="stylesheet">

<script src="js/jquery-ui.js" type="text/javascript"></script>
<script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/dataTables.buttons.min.js " type="text/javascript"></script>
<script src="js/jszip.min.js" type="text/javascript"></script>
<script src="js/pdfmake.min.js" type="text/javascript"></script>
<script src="js/vfs_fonts.js " type="text/javascript"></script>
<script src="js/buttons.html5.min.js" type="text/javascript"></script>
<script src="js/buttons.jqueryui.js" type="text/javascript"></script>
<script src="js/buttons.jqueryui.min.js" type="text/javascript"></script>
<script src="js/buttons.print.js" type="text/javascript"></script>
<script src="js/buttons.print.min.js" type="text/javascript"></script>
<script>
/*function format ( d ) {
	// `d` is the original data object for the row
	return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
		'<tr>'+
			'<td>Full name:</td>+
			'<td>'+d.name+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td>Extension number:</td>'+
			'<td>'+d.extn+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td>Extra info:</td>'+
			'<td>And any further details here (images etc)...</td>'+
		'</tr>'+

    '</table>';
}*/

$(document).ready(function(){ 
	$("table.display").dataTable({
		"scrollCollapse": true,
		"paging": false,
		"jQueryUI": true,
		dom: "Bfrtip",
		buttons:[
			'excelHtml5',
			'pdfHtml5',
			'print',
		],
		
	});
}); 
	
</script>
<?
include("includes/connect.php");
$sql="SELECT * FROM history_table as hist
	  LEFT JOIN 
				(
				  SELECT * FROM dayton
				) 
	  AS data
	  ON hist.inv_id = data.inv_id";
$query=mysql_query($sql,$con);
?>
<div>
	<center>
		<table width="100%" class="display" id="example" cellspacing="0">
			<thead>
				<tr>
					<th style="font-size:10px;">
						Invoice #
					</th>
					<th style="font-size:10px;">
						User
					</th>
					<th style="font-size:10px;">
						Original Weight 
					</th>
					<th style="font-size:10px;">
						Current Weight
					</th>
					<th style="font-size:10px;">
						Original Amount
					</th>
					<th style="font-size:10px;">
						Current Amount
					</th>
					<th style="font-size:10px;">
						Notes
					</th>
				</tr>
			</thead>
			</tbody>
				<?
				while($row=mysql_fetch_array($query)){	
				?>
				<tr>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
						<?echo $row['inv_id']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:150px;font-size:8px;">
						<?echo $row['u_id']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;font-size:8px;">
						<?echo $row['orig_weight']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:300px;font-size:8px;">
						<?echo $row['new_weight']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:150px;font-size:8px;">
						<?echo $row['orig_amount']?>
					</td >
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:350px;font-size:8px;">
						<?echo $row['new_amount']?>
					</td>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:8px;">
						<?echo $row['notes']?>
					</td>
				</tr>
				<?
				}
				?>
			<tbody>
		</table>
	</center>
</div>
