<!--
reportGenerator view, called from reportGenerator controller
Generates reports from MDX
Currently supports Easy Forex custom report
-->
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
		form
		{
		width:500px;
		margin:0 auto;
		font-family: verdana;
		font-size: 12px;
		color: #616161;
		padding: 10px;
		}
		input[type=submit]
		{
			margin:10px 0 0 70px ; 
		}
		#addrefund{
		overflow:hidden;
		color:#9BBD53;
		text-align: justify;
		margin:0px auto;  
		font-family: Verdana;
		color: #616161;
		} 
		form{
		width:500px;
		margin:0 auto;
		font-family: verdana;
		font-size: 12px;
		color: #616161;
		padding: 10px;
			}
		input[type=submit]{
			margin:10px 0 0 70px ; 
			}
		#topfield{
		width: 50%;
		float: left;
			}
		#bottomfield{
		margin-top:5px;
		width: 80%;
		float: left;
			}

		label{
		display: block;
		float:left;
		width: 53px;
		margin-right: 10px;
		}

		select,input{
		display: block;
		width:150px;
		float: left;
		margin-left: 5px;
		}
		select{
		width: 154px;
		}
		.clear{
		clear:both;
		}

	</style>
	<script>	
		$(function() {
			$("#datepickerFrom").datepicker({dateFormat: 'dd-mm-yy'});
			$("#datepickerTo").datepicker({dateFormat: 'dd-mm-yy'});
		});
		$( "#datepickerFrom" ).datepicker();	
		$("#datepickerFrom").datepicker("setDate",new Date());
		$( "#datepickerTo" ).datepicker();	
		$("#datepickerTo").datepicker("setDate",new Date());
	</script>
    <body>
	<div id="addrefund">
		<form action="#" method="post">  
			<div id="topfield">
				<label for="startDate">From</label>
				<input name="startDate" type="text" id="datepickerTo"  value="< ?php echo date('Y-m-d');?>" size="12" />
			</div>
			 <div id="bottomfield">
				<label for="refund">To</label>
				<input name="refund" type="text" id="datepickerFrom"value="< ?php echo date('Y-m-d');?>" size="12" /></br>
			 </div>
		<div class="clear"></div>
		<input type="submit" value="Generate" id="submit"/> 
		</form>
	</div>
    </body>
</html>
