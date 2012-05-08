<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Import Data</title>
	<style type="text/css">
		.formField
		{
			margin-bottom: 8px;
		}
		.formField .label
		{
			width: 120px;
			float: left;
			font-size:80%
		}
			
		.formField .control
		{
		}
			
		.fileUpload
		{
			font-size: 12px;
			font-family: Verdana;
			float: left;
		}
		
		.linkButton
		{
			margin: 0px 5px 0px 5px;
			text-decoration: none;
			font-size:80%;
			color: #669933;
			background:none;
			border:none; 
			padding:0;
			cursor:pointer
		}	
		.submitButton
		{
			font-weight:bold;
			 width: 80px;
			 height:25px ;
		}
		.filesList
		{
			margin-top: 3px;
			height: 120px;
			width: 100%;
			clear: both;
		}		
	</style>
	<script type="text/javascript">
		function addField()
		{
			var optn = document.createElement("OPTION");
			var selectbox = document.getElementById('_listboxFiles');
			optn.text = document.getElementById('_fileUpload').value;
			optn.value = document.getElementById('_fileUpload').value;
			if(optn.text != "")
			{
				selectbox.options.add(optn);
				document.getElementById('_submit').disabled = false;
			}	
		}
		
		function removeField()
		{
			var i;
			var selectbox = document.getElementById('_listboxFiles');
			for(i=selectbox.options.length-1;i>=0;i--)
			{
				if(selectbox.options[i].selected)
				selectbox.remove(i);
			}
			if(selectbox.options.length == 0)
				document.getElementById('_submit').disabled = true;
		}
		
		$("#_submit").click(
		function()
		{
			alert("upload button clicked!");
		/*var form_data = {
				"files":$("#_fileUpload").val()
			};

			try
			{
				$.ajax({
						dataType:"json",
						type: "POST",
						data:form_data,
						url:"refund/proccess",
						success: function(data) {
						$("#v").show();
						$("#success").append("Refund data added successfully").show();			
						},
						error:function(data){
							$("#error").show();
							$("#success").append("Failed to add refund data").show();
						}
					 });
 			 }
			catch(ex) {
				alert(ex);
			}
			return false;*/
		}
		);
	</script>
    </head>
    <body>
	<form  method="post">
		<div class="formField">
			<div class="label">Source:</div>
			<div class="control">
				<select name="mydropdownlist">
				<?php $options =  array(
				"BackOffice"=>"Pre-formatted Back Office",
				"Yahoo"=>"Pre-formatted Yahoo",
				"Creative"=>"Pre-formatted Creative"
				);

				foreach($options as $value => $caption)
				{
					echo "<option value=\"$value\">$caption</option>";
				}
				?>
			</select>
			</div>
		</div>

		<div class="formField">
			<div class="label">Report file: </div>
				<input type="file" id="_fileUpload" name="fileUpload" />
			<div class="control" style="width: 400px">
				<div style="float:right">
					<button type="button" ID="_addFile" class="linkButton" onclick="addField()">add</button>
					<button type="button" ID="_removeFile" class="linkButton" onclick="removeField()">remove</buttton>
				</div>
				<select name="listbox" ID="_listboxFiles" class ="filesList "  multiple="multiple"/>
			</div>
		</div>

		<div class="formField">
			<div class="label"></div>
			<div class="control">
				<input type="submit" ID="_submit" name="submitBtn"  class =" submitButton"value="Go" disabled="disabled">
			</div>
		</div>
	</form>
    </body>
</html>
