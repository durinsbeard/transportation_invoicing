<style>
td.details-control {
	background: url('images/details_open.png') no-repeat center center;
	cursor: pointer;
}

tr.shown td.details-control {
	background: url('images/details_close.png') no-repeat center center;
}
</style>
<link href="css/dataTables.jqueryui.css" rel="stylesheet">
<link href="css/dataTables.foundation.css" rel="stylesheet">
<link href="css/jquery-ui.css" rel="stylesheet">

<script src="//code.jquery.com/jquery-1.11.3.min.js " type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
/* Formatting function for row details - modify as you need */
	function format(d){
		// `d` is the original data object for the row
		return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
				'<tr>'+
				'<td>Full name:</td>'+
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
	}
$(document).ready(function(){
	var table = $('#example').DataTable( {
		"ajax": "objects.txt",
        "columns":[
			{
				"className": 'details-control',
				"orderable": false,
				"data": null,
                "defaultContent": ''
			},
            {"data":"name"},
            {"data":"position"},
            {"data":"office"},
            {"data":"salary"}
        ],
			"order": [[1, 'asc']]
	});

    // Add event listener for opening and closing details
    $('#example tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = table.row( tr );

		if(row.child.isShown()){
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}else{
			// Open this row
			row.child( format(row.data()) ).show();
			tr.addClass('shown');
		}
	});
});
</script>
<table width="100%" class="display" id="example" cellspacing="0">
	<thead>
		<tr>
			<th></th>
			<th>Name</th>
			<th>Position</th>
			<th>Office</th>
			<th>Salary</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th></th>
            <th>Name</th>
            <th>Position</th>
            <th>Office</th>
            <th>Salary</th>
        </tr>
    </tfoot>
</table>