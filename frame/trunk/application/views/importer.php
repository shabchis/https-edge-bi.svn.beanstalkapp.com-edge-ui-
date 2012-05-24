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
			width:700px;
			margin:0 auto;
			font-family: verdana;
			font-size: 12px;
			color: #616161;
			padding: 10px;
		}
		.formField .label
		{
			width: 120px;
			float: left;
			font-size:80%
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
		var counter = 2;
		
		function addName(obj)
		{
			var row=(obj.parentNode).parentNode.rowIndex;
			var Id =( (obj.id).match(/\d+/)).join("");
			var nameId = "name"+Id;
			document.getElementById(nameId).innerHTML = document.getElementById(obj.id).value;
			document.getElementById('submit').disabled = false;	
			if (row==document.getElementById("tableID").rows.length-1)
				addRow();
		}
		
		function addRow() {
			var table = document.getElementById("tableID");

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell1 = row.insertCell(0);
			var element1 = document.createElement("select");
			element1.name = "select"+counter;
			var option1 = document.createElement("option");
			var option2 = document.createElement("option");
			var option3 = document.createElement("option");
			option1.text = "Pre-formatted Back Office";
			option1.value ="BackOffice";
			option2.text = "Pre-formatted Yahoo";
			option2.value ="Yahoo"
			option3.text = "Pre-formatted Creative";
			option3.value ="Creative"
			try {
				element1.add(option1, null); //Standard
				element1.add(option2, null);
				element1.add(option3, null);
			}catch(error) {
				element1.add(option1); // IE only
				element1.add(option2);
				element1.add(option3);
			}
			cell1.appendChild(element1);

			var cell2 = row.insertCell(1);
			var element2 = document.createElement("input");
			element2.type = "file";
			element2.id = "file"+counter;
			element2.name = "files[]"
			element2.setAttribute("onChange","addName(this)");
			cell2.appendChild(element2);

			var cell3 = row.insertCell(2);
			cell3.id = "name"+counter ;
			
			var cell4 = row.insertCell(3);
			var element4 = document.createElement("button");
			element4.type = "button";
			element4.id = "remove"+counter;
			element4.name = "removeBtn"
			element4.setAttribute("onClick","removeRow(this)");
			element4.innerHTML = "(remove)"
			cell4.appendChild(element4);
			
			counter++;
		 }	
		 
		 function removeRow(obj) {
			 var row=(obj.parentNode).parentNode.rowIndex;
			 var table = document.getElementById("tableID");
			 table.deleteRow(row);
		 }
	</script>
    </head>
    <body>
	<div id="importer">
		<form id="importForm" name="importForm" action =" importer/upload" method="post" enctype="multipart/form-data" target="status" >
			<table id="tableID">
				<tr>
					<td><div class="label">Source:</div></td>
					<td><div class="label">Report files:</div></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>
						<select name="select1">
							<option value="BackOffice">Pre-formatted Back Office</option>
							<option value="Yahoo">Pre-formatted Yahoo</option>
							<option value="Creative">Pre-formatted Creative</option>
						</select>
					</td>				
					<td>
						<input type="file" id="file1" name="files[]"  onChange="addName(this)"/>
					</td>				
					<td> <div id="name1"></div></td>
					<td></td>
				</tr>
			</table>						
			<input type="submit" ID="submit" name="submitBtn"  class =" submitButton"value="Go" disabled="disabled">
		</form>
	</div>
	<iframe id="status" name="status" ></iframe> 
	
    </body>
</html>
