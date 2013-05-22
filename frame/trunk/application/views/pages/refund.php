<style>
	#refund {
		color: #616161;
		margin-left: 30px;
	}
	
	.ui-datepicker {
		background-color: white;
	}
	.ui-datepicker-calendar {
		display: none;
		font-size: 10px;
	}
	.ui-datepicker-title {
		font-family: verdana;
		font-size: 12px;
	}
	
	form {
		display: block;
	}
	
	.field {
		margin-bottom: 15px;
	}
	.field label {
		display: block;
		float: left;
		width: 60px;
		margin-right: 15px;
	}
	
	.field select, .field input {
		display: block;
		width: 150px;
	}
	
	input[type=submit] {
		margin:0 0 0 75px;
	}
	
	#success {
		display:none;
		width:300px;
		color:#9BBD53;
		text-align: center;
		margin:80px 0px 0px 100px;
		-moz-border-radius: 5px 5px 5px 5px;
		-moz-box-shadow: 0 0 10px #DBD8DB;
		background-color: #FFFFFF;
		background-image: -moz-linear-gradient(center bottom, #F5F2F5 0%, #FAFAFA 17%, #FFFFFF 79%);
		border: 1px solid #E5E5E5;
		
		padding: 10px;
	}
	
	#confirm {
		display: none;
		line-height: 18px;
	}
	#error {
		display:block;
		float:left;
		vertical-align: bottom;
		margin:0px 0px 0px 5px;
	}
	#error img {
		vertical-align: bottom;
	}
	#v {
		display:none;
		float:left;
		vertical-align: bottom;
		margin:0px 0px 0px 5px;
	}
	#refundAction
	{
		margin-bottom: 30px;
	}
		#refundAction div {
			display: inline-block;
			margin-right: 10px;
		}
	
	.clear {
		clear:both;
	}
	
</style>

<div id="refund">
	<div id="refundAction">
		<div><input type="radio" name="refund_action" id="refund_add" value="refund_add" checked="checked"/><label for="refund_add">Add Refund</label></div>
		<div><input type="radio" name="refund_action" id="refund_delete" value="refund_delete"/><label for="refund_delete">Delete Refund</label></div>
	</div>
	
	<form action="#" method="post">
		<div class="field">
			<label for="channel">Channel</label>
			<select name="channel">
				<option value="1">Google</option>
			</select>
		</div>
		<div class="field" id="field_refundAmount">
			<label for="refund">Amount</label>
			<input name="refund" id="refund" autocomplete="off" />
		</div>
		<div class="field">
			<label for="startDate">Date</label>
			<input name="startDate" id="startDate" class="date-picker" autocomplete="off" />
		</div>
		<div class="clear"></div>
		<input type="submit" value="Submit" id="submit" />
		<div class="clear"></div>
	</form>
	<div id="success">
		<div id="error">
			<img src="assets/img/alert-icon.png" />
		</div>
		<div id="v">
			<img src="assets/img/success-icon.png" />
		</div>
	</div>
	<div id="confirm">
		<p>Are you sure you want to delete?</p>
		<p>The operation may take a few minutes.</p>
	</div>
</div>



<script type="text/javascript">
	$(function ()
	{
		$("#main").ajaxStart(function ()
		{
			$("#success").html('The operation may take a few minutes').fadeIn(500);
		});
		$("#main").ajaxComplete(function ()
		{
			$("#success").fadeOut(500);
		});
		$('.date-picker').datepicker(
		{
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'mm/dd/yy',
			onClose: function (dateText, inst)
			{
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).datepicker('setDate', new Date(year, month, 1));
			}
		});
		
		$("input[name='refund_action']").change(function(){
			 if ($(this).val() === 'refund_delete')
				 $('#field_refundAmount').hide();
			 else
				  $('#field_refundAmount').show();
		});
		
		$("#submit").button();
		$("#submit").click(function ()
		{
			if ($("input[name='refund_action']").val() != 'refund_delete')
			{
				var form_data = {
					"accountID": getHashSegments().accountID,
					"refund": $("#refund").val(),
					"date": $('#startDate').val(),
					"channel": $('select option:selected').val()
				};
				try
				{
					$.ajax(
					{
						dataType: "json",
						type: "POST",
						data: form_data,
						url: "refund/add",
						success: function (data)
						{
							$("#v").show();
							$("#success").append("Refund data added successfully").show();
						},
						error: window.handleError
					});
				}
				catch (ex)
				{
					alert(ex);
				}
			}
			else
			{
				$("#confirm").dialog(
				{
					resizable: false,
					height: 200,
					modal: true,
					buttons:
					{
						"Delete ": function ()
						{
							var form_data = {
								"accountID": getHashSegments().accountID,
								"date": $('#startDate').val(),
								"channel": $('select option:selected').val()
							};
							try
							{
								$.ajax(
								{
									dataType: "json",
									type: "POST",
									data: form_data,
									url: "refund/delete",
									success: function (data)
									{
										$("v").show();
										$("#success").append("Refund data deleted successfully").show();
									},
									error: window.handleError
								});
							}
							catch (ex)
							{
								alert(ex);
							}
							$(this).dialog("close");
						},
						Cancel: function ()
						{
							$(this).dialog("close");
						}
					}
				});
			}
			return false;
		});
	});
</script>