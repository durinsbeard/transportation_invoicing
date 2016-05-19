<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>jQuery UI Example Page</title>
	<link href="jquery-ui.css" rel="stylesheet">
	<style>
	body{
		font: 62.5% "Trebuchet MS", sans-serif;
		margin: 50px;
	}
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	select {
		width: 200px;
	}
	</style>
</head>
<table class="ui-widget">
	<tr>
		<td width="50%">			
			Asset Type:
		</td>
		<td width="50%">			
			
		</td>
	</tr>
	<tr>
		<td width="50%">			
			Asset Tag:
		</td>
		<td width="50%">			
			<input type="text" name="tag" size="27"/>
		</td>
	</tr>
	<tr>
		<td width="50%">			
			Company:
		</td>
		<td width="50%">			
			
		</td>
	</tr>
	<tr>
		<td width="50%">			
			Wired Mac Address:
		</td>
		<td width="50%">			
			<input type="text" name="wiredMacAddress" id="wiredMacAddress" size="27" />
		</td>
	</tr>
	<tr>
		<td width="50%">			
			Wireless Mac Address:
		</td>
		<td width="50%">			
			<input type="text" name="wirelessMacAddress" id="wirelessMacAddress" size="27" />
		<td width="50%">			
	</tr>
	<tr>
		<td width="50%">			
			IP Address:
		</td>
		<td width="50%">			
			
		</td>
