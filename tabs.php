<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>jQuery UI Tabs Example 1</title>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.js'></script>

<script>
$(function(){
$("#tabs").tabs();
	$("#button").click(function(){
        var current_index = $("#tabs").tabs("option","selected");
		//alert("The index of the current tab is " + current_index);
		
    });
});
</script>
</head>
<body>
<button id="button">Click me</button>
	<div id="tabs">
		<ul>
			<li><a href="#tab_1">First Tab</a></li>
			<li><a href="#tab_2">Second Tab</a></li>
			<li><a href="#tab_3">Third Tab</a></li>
		</ul>
		<div id="tab_1">
			first
			<input type="checkbox">
			<input type="checkbox">
			<input type="checkbox">
			<input type="checkbox">
		</div>
		<div id="tab_2">
			second
			<input type="checkbox">
			<input type="checkbox">
			<input type="checkbox">
			<input type="checkbox">
		</div> 
		<div id="tab_3">
			third
			<input type="checkbox">
			<input type="checkbox">
			<input type="checkbox">
			<input type="checkbox">
		</div> 
	</div>
</body>
</html>
 