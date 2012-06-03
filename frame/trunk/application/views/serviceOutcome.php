<?php
/**
 *Services outcome view, called from serviceStats controller
 * Shows outcome of services per channel
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
	<style type="text/css">
		div.ui-datepicker
		{ 
		font-size:10px;
		background: #fff;
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
		#submit
		{
		 width: 80px;
		 height:25px ;
		}
		table {
		border-collapse: separate;
		border-spacing: 0;
		margin: 30px;
		}
		.bordered
		{
		margin-top: 40px;
		font-family:verdana;
		color: #504849;
		font-size: 12px;
		width:32%;
		border:1px solid #96BA4B;
		-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
		border-radius: 6px;
		border-width: 1px;
		}
		#tableID td, #tableID th 
		{
		font-size:12px;
		border:1px solid #96BA4B;
		padding:3px 7px 2px 7px;
		}
		#tableID th 
		{
		font-size:14px;
		text-align:left;
		padding-top:2px;
		padding-bottom:2px;
		background-color:#96BA4B;
		color:#fff;
		}
		form
		{
		margin-left: 30px;
		margin-top:15px; 
		font-size: 14px;	
		}
		#channelIcon{ 
		width:24px; 
		height:24px;
		vertical-align:middle;
		border:10 px;
		margin:10 px;
		}
	</style>
	<script>

		$(function() {
			$( "#datepicker" ).datepicker();
		});
		$("#datepicker").datepicker("setDate",new Date());
		
		$("#submit").click(function(){
			$("#tableID tr:gt(0)").remove();
			var form_data = {
				"accountID": getHashSegments().accountID,
				"date": $('#datepicker').val()
			};
			try
			{
				$.ajax({
					dataType:"json",
					type: "POST",
					data:form_data,
					url:"serviceStats/getServices",
					success: function(data) {						
						 for (var i = 0; i < data.length; i++)
						 {
							 switch(data[i].channel)
							{
								case ('Google.AdWords'):{img = 'google.jpg'; break;}
								case('Facebook.AdsApi'):{img = 'facebook.jpg'; break;}
								default: break;
							}
							 $("#tableID").last().append('<tr><td><img src="<?php base_url();?>assets/img/'+img+'" id="channelIcon" />   '+data[i].channel+'</td><td>'+data[i].status.OutCome+'</td></tr>');
						}
					},
					error:function(data){
						alert(data);   			
					}
	 			 });
 			 }
			catch(ex) {
				alert(ex);
			}
			return false;	
		});
	</script>
    <body>
	<form action="#" method="post">
		Choose date: <input type="text" id="datepicker" name ="date" value="< ?php echo date('Y-m-d');?>">
		<input type="submit" value="Go" id="submit"/>
	</form>
	<div id="result">
		<table id="tableID" class="bordered">
			<tr>
				<th>Channel</th>
				<th >Outcome</th>				
			</tr>		
		</table>	
	</div>	
    </body>
</html>
