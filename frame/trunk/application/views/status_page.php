<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Import Status</title>
	<style type="text/css">	
		#msg
		{		
			margin-bottom: 10px;
			font-family: Verdana;
			color: #616161;
		}
		#progressBar
		{		
			width:300px;
			height: 20px
		}
		#importProgress
		{		
			font-family: Verdana;
		}
		#label
		{
			font-size: 12px;
		}
		#error
		{
			float:left;
			vertical-align: bottom;
			margin:0px 0px 0px 5px;
		}
		#success
		{
			float:left;
			vertical-align: bottom;
			margin:0px 0px 0px 5px;
		}
		#result
		{
			text-align: center;
			display:none;
			width:400px;
			color:#9BBD53;
			-moz-border-radius: 5px 5px 5px 5px;
			-moz-box-shadow: 0 0 10px #DBD8DB;
			background-color: #FFFFFF;
			background-image: -moz-linear-gradient(center bottom , #F5F2F5 0%, #FAFAFA 17%, #FFFFFF 79%);
			border: 1px solid #E5E5E5;
			font-family: Verdana;
			color: #616161;
			padding: 10px;
		 }
	</style>
    </head>
	<script src="http://localhost/frame/assets/js/jquery-1.4.4.js"></script> 
	<link rel="stylesheet" href="http://localhost/frame/assets/css/jquery-ui-1.8.8.custom.css" media="screen"/>  	
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/start/jquery-ui.css" rel="stylesheet" />
           <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
           <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
	<script type="text/javascript">
		var _guidArray = new Array();
		<?php
			foreach ($_guids as $id) {
			print "_guidArray.push($id);";
			}
		?>
		
		$(document).ready(function() {

			  $("#progressBar").show().progressbar();
			  $("#progressBar").css({ 'background': '#cbdda6' , 'border':'0px' });
			  $("#progressBar > div").css({ 'background': '#96BA4B','border':'0px' });
			  $("#msg").append("Your import has been received and is now uploading. <br /> This may take a few minutes..").show();
			  var intervalId =setInterval("checkStatus();", 500);
			});				
		
		function checkStatus()
		{			
			for (var i = 0; i < _guidArray.length; i++)
			{
			var id = _guidArray[i];
			$.ajax({
					type: 'GET',
					url:'getStatus/'+id,
					async: false,
					success: function(data) {
						var status =jQuery.parseJSON(data);
						if (status.OutCome=="Unspecified"){
							 $("#status").text(status.Progress*100+'%').show();
							 $("#progressBar").progressbar({ value: status.Progress*100});
						}
						else{
							if(status.OutCome=="Success"){
								$("#status").hide();
								$("#label").hide();
								$("#msg").hide();
								$("#progressBar").hide();
								$("#error").hide();
								$("#result").append("Your import has uploaded successfully!").show();							
							}
							else{
								$("#status").hide();
								$("#label").hide();
								$("#msg").hide();
								$("#progressBar").hide();
								$("#success").hide();
								$("#result").append("There was an error importing your files,please contact us for assitance :Support@Edge.BI").show();
							}
							clearInterval(intervalId);
							}
						},
					 error:function(jqXHR, textStatus, errorThrown){
						$("#status").hide();
						$("#label").hide();
						$("#msg").hide();
						$("#progressBar").hide();
						$("#success").hide();
						$("#result").append("There was an error importing your files, please contact us for assitance Support@Edge.BI").show();
						clearInterval(intervalId);
					   }
				});
			}
		}
		
	</script>
    <body>
	<div id="importProgress">
		<div id ="msg"></div>		
		<div id="result">
			<div id="error">
				<img src="http://localhost/frame/assets/img/alert-icon.png" />
			</div>
			<div id="success">
				<img src="http://localhost/frame/assets/img/success-icon.png" />
			</div>	
		</div>		
		<table id="tableID">
			<tr>
				<td ><div id="label">Progress:</div></td>
				<td><div id="label"></div></td>		
			</tr>
			<tr>
				<td><div id="progressBar"</div></td>
				<td><div id ="status"> </div></td>			
			</tr>			
		</table>	
	</div>
    </body>
</html>
