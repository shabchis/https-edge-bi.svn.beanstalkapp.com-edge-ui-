<?php
/**
 *Importer status  view, called from importer controller
 *after uploading files in the importer view
 */
?>
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
		.progressBar
		{		
			width:300px;
			height: 10px;
			background-color: #cbdda6;
			border: 0px;		
		}
		#importProgress
		{		
			font-family: Verdana;
			width: 80%;
			font-size: 12px;
		}
		#label
		{
			color: #616161;
			font-weight:bold;
			text-align: center;
		}
	</style>
    </head>
	<script src="http://localhost/frame/assets/js/jquery-1.4.4.js"></script> 
	<link rel="stylesheet" href="http://localhost/frame/assets/css/jquery-ui-1.8.8.custom.css" media="screen"/>  	
	<script src="http://localhost/frame/assets/css/jquery-ui.css" />
	<script src="http://localhost/frame/assets/js/jquery-ui.min.js"></script>	
           <script src="http://localhost/frame/assets/js/jquery.min.js"></script>
           <script src="http://localhost/frame/assets/js/jquery-ui-1.8.5.js"></script>
	<script type="text/javascript">
		var _guidArray = new Array();
		var intervalIds=new Array();
		var _filesArray = new Array();
		<?php
			//Get guids from controller
			foreach ($_guids as $id) {
				print "_guidArray.push($id);";
			}
			//Get file names from controller
			foreach ($_files as $id) {
				print "_filesArray.push('$id');";
			}
		?>
		
		$(document).ready(function() {
			  $("#msg").append("Your import has been received and is now uploading. <br /> This may take a few minutes..").show();
			  for (var i = 0; i < _guidArray.length; i++)
			   {
				var fileName = "file"+i;
				var progressBarName = "progressBar"+i;
				var statusName ="status"+i;
				var resultName ="result"+i;
				 $("#tableID").last().append('<tr><td><div id="'+fileName+'"></div></td><td><div id="'+progressBarName+'"></div></td><td><div id ="'+statusName+'"> </div></td><td><div id ="'+resultName+'"> </div></td></tr>');
				 $('#'+progressBarName).css({ 'background': '#cbdda6' , 'border':'0px' ,'height':'20px','width':'300px'});
				 $('#'+progressBarName).show().progressbar();
				 $('#'+progressBarName+'> div').css({ 'background': '#96BA4B','border':'0px' });
				 $('#'+fileName).append(_filesArray[i]);
				 var id = _guidArray[i];
				 intervalId =setInterval("checkStatus('"+id+"','"+i+"');", 500);
				 intervalIds.push(intervalId);			 
			    }
			});				
		
		function checkStatus(id,i)
		{	
			var progressBarName = "progressBar"+i;
			var statusName ="status"+i;
			var resultName ="result"+i;
			$.ajax({
					type: 'POST',
					url:'getStatus/'+id,
					async: false,
					success: function(data) {
						var status =jQuery.parseJSON(data);
						if (status.OutCome=="Unspecified"){
							 $('#'+statusName).text(status.Progress*100+'%').show();
							 $('#'+progressBarName).progressbar({ value: status.Progress*100});
						}
						else{
							if(status.OutCome=="Success"){
								$("#msg").hide();
								$('#'+progressBarName).progressbar({ value: 100});
								$('#'+statusName).text('100%').show();
								$('#'+resultName).append("<img src='http://localhost/frame/assets/img/pass.gif'/>");						
							}
							else{
								$("#msg").hide();
								$('#'+resultName).append("<img src='http://localhost/frame/assets/img/fail.gif'/>");	
							}
							clearInterval(intervalIds[i]);
							}
						},
					 error:function(jqXHR, textStatus, errorThrown){
						$("#msg").hide();
						$('#'+resultName).append("<img src='http://localhost/frame/assets/img/fail.gif'/>");
						clearInterval(intervalIds[i]);
					   }
				});
		}	
	</script>
    <body>
	<div id="importProgress">
		<div id ="msg"></div>		
		<table id="tableID">
			<tr>
				<td colspan="4" ><div id="label">Import Status</div></td>					
			</tr>		
		</table>	
	</div>
    </body>
</html>
