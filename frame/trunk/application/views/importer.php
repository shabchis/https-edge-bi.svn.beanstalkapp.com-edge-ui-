<?php
/**
 *Importer view, called from importer controller
 */
?>
<!DOCTYPE html>
<html>
    <head>
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Import Data</title>
	<style type="text/css">
		#status
		{
			margin-top: 20px;
		}
		#importer
		{ 
			width:80%;
			margin:0 auto;
			font-family: verdana;
			font-size: 12px;
			color: #616161;
		}
		#label
		{
			width: 120px;
			float: left;
			font-size:14px;
			font-weight:bold;
		}
		button[Onclick="removeRow(this)"]
		{
			margin: 0px 5px 0px 5px;
			text-decoration: none;
			color: #669933;
			background:none;
			border:none; 
			padding:0;
			cursor:pointer
		}
		.fileUpload
		{
			font-size: 12px;
			font-family: Verdana;
		}	
		input[type=submit]:hover 
		{
			background: #fefefd; /* Old browsers */
			background: -moz-linear-gradient(top,  #fefefd 0%, #dce3c4 42%, #aebf76 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefefd), color-stop(42%,#dce3c4), color-stop(100%,#aebf76)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* IE10+ */
			background: linear-gradient(top,  #fefefd 0%,#dce3c4 42%,#aebf76 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefefd', endColorstr='#aebf76',GradientType=0 ); /* IE6-9 */
		}
		.submitButton
		{
			 width: 80px;
			 height:25px ;
		}
	</style>
	<script type="text/javascript">
		function addName(obj)
		{			
			var Id =( (obj.id).match(/\d+/)).join("");
			var nameId = "name"+Id;
			document.getElementById(nameId).innerHTML = document.getElementById(obj.id).value;
			document.getElementById('submit').disabled = false;	
		}		 
	</script>
    </head>
    <body>
	<div id="importer">
		<form id="importForm" name="importForm" action =" importer/upload" method="post" enctype="multipart/form-data" target="status" >
			<table id="tableID">
				<tr>
					<td><div id="label">Source:</div></td>
					<td><div id="label">Report files:</div></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name ="importType">
							<option value="ImporterTester" >Channel Data</option>
							<option value="ImporterTester" >Backoffice Data</option>
						</select>
					</td>				
					<td>
						<input type="file" id="file1" name="files[]"  onChange="addName(this)"/>
					</td>				
					<td> <div id="name1"></div></td>
				</tr>
			</table>						
			<input type="submit" ID="submit" name="submitBtn"  class =" submitButton"value="Go" disabled="disabled">
		</form>	
		<iframe id="status" name="status" ></iframe>
	</div>
    </body>
</html>
