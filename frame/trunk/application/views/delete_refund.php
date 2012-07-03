<div id="delete">
	     
<form action="#" method="post">
   
    <div id="topfield">
    <label for="channel">Channel </label>
    <select>
        <option value="1">Google</option>
    </select>
    
    </div>
    <div id="bottomfield">
   
    <label for="startDate">Date </label>
    <input name="startDate" id="startDate" class="date-picker" autocomplete="off" />
    </div>
    <div class="clear"></div>
	<input type="submit" value="Submit" id="submit"/>

</form>
 <div id="success">
 	<div id="error">
 		<img src="assets/img/alert-icon.png" />
 		
 	</div>
 	<div id="v">
 		<img src="assets/img/success-icon.png" />
 
 	</div>
 	
 </div>
	</div>

<div id="confirm">
	<p>
	Are you sure you want to delete?
	</p>
	<p>
	The operation may take a few minutes
	</p>
</div>
<style>
.ui-datepicker {
background-color: white;
}
 .ui-datepicker-calendar{
 display: none;
 }
   
.ui-datepicker-title{

	font-family: verdana;
	font-size: 12px;

}

#error{
display:none;
float:left;
vertical-align: bottom;
margin:0px 0px 0px 5px;
}
#error img{
vertical-align: bottom;}
#v{
display:none;
float:left;
vertical-align: bottom;
margin:0px 0px 0px 5px;
}
#confirm{

 color: #616161;
    display: none;
    font-family: verdana;
    font-size: 12px;
    line-height: 18px;
}
.clear{
clear:both;
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

   width: 51%;
   float: left;

        }
	label[for=startDate],#startDate{
		margin-top: 5px;
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
   #delete{
   overflow:hidden;
    color:#9BBD53;
    text-align: left;
    margin:0px auto;
     font-family: Verdana;
    color: #616161; 
    }
    #success{
    display:none;
    width:300px;
    color:#9BBD53;
    text-align: center;
    margin:80px 0px 0px 100px;
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
    
<script type="text/javascript">
    $(function() {

$("#main").ajaxStart(function(){
		$("#seccess").html('The operation may take a few minutes').fadeIn(500);	
	});
	$("#main").ajaxComplete(function(){
		$("#seccess").fadeOut(500);
	});
        $('.date-picker').datepicker( {
            changeMonth: true,
            changeYear: true,
               showButtonPanel: true,
			dateFormat: 'mm/dd/yy',
			  onClose: function(dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
        }
                
        });
        
      $("#submit").button();

		$("#submit").click(function(){
		$("#confirm").dialog({
		resizable: false,
			height:200,
			modal: true,
			buttons: {
				"Delete ": function() {
						var form_data = {
				"accountID": getHashSegments().accountID,
				"date": $('#startDate').val(),
				"channel": $('select option:selected').val()
			};

			try
			{
				$.ajax({
					dataType:"json",
					type: "POST",
					data:form_data,
					url:"refund/deleteprocess",
					success: function(data) {
	    				$("v").show();
	    				$("#success").append("Refund data deleted successfully").show();
	    				
	    				
	    			},
	    			error:function(data){
	    				
	    				$("#error").show();
	    				$("#success").append(" Refund data failed to deleted").show();
	    				
	    			}
	 			 });
 			 }
			catch(ex) {
				alert(ex);
			}
			$( this ).dialog( "close" );
				},
				Cancel: function() {
				
				$("#error").show();
				$("#success").append("Refund data was not deleted").show();
				
					$( this ).dialog( "close" );
				}
			}
		});


	
		
			
			return false;
	
		});
	
    });
    </script>