<div id="addrefund">
<form action="#" method="post">
   
    <div id="topfield">
    <label for="channel">Channel </label>
    <select>
        <option value="1">Google</option>
    </select>
    
    </div>
    <div id="bottomfield">
	<div>
		<label for="refund">Refund </label>
		<input name="refund" id="refund"  autocomplete="off" /></br>
	 </div>
	<div>
		<label for="startDate">Date </label>
		<input name="startDate" id="startDate" class="date-picker" autocomplete="off" />
	 </div>
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
<style>

#error{
display:block;
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
.ui-datepicker {
background-color: white;
}
 .ui-datepicker-calendar{
 display: none;
 font-size: 10px;
 }
   
.ui-datepicker-title{

	font-family: verdana;
	font-size: 12px;

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
    label[for=startDate],#startDate{
    margin-top: 5px;
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
    .clear{
    clear:both;
    }
    </style>
    
<script type="text/javascript">
    $(function() {

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
		
			var form_data = {
				"accountID": getHashSegments().accountID,
				"refund":$("#refund").val(),
				"date": $('#startDate').val(),
				"channel": $('select option:selected').val()
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
			
			return false;
	
		});
	
    });
    </script>