<script id="validationtmpl" type="text/x-jquery-tmpl">

<tr class="content">
<td data-account="${Account_ID}">${Account_ID}</td>
<td  data-accountName="${Account_Name}">${Account_Name}</td>
{{if Status == 1}}
<td data-status="Succeeded and reported">Succeeded</td>
{{else Status == 10}}
<td data-status="Succeeded and reported">Succeeded</td>
{{else Status == 9}}
<td data-status="Failed">Failed</td>
{{else Status==0}}
<td data-status="Failed">Failed</td>
{{else Status==""}}
<td data-status="">&nbsp; </td>
{{else Status==null}}
<td data-status="Pending">Pending </td>

{{/if}}

{{if Service==1}}
<td data-service="Google" >Google</td>
{{else Service==6}}

<td data-service="Facebook" >Facebook</td>
{{else Service== 0}}

<td data-service="BackOffice">BackOffice</td>
{{else Service== -1}}
<td data-service="Google display network">Google display network</td> 

{{/if}}<td data-DayCode="${DayCode}">${DayCode}</td><td data-LastUpdated="${computed}">${computed}
</td><td data-app="${Application}">${Application}</td></tr>


</script>



<div id="validationWrapper">
<div id="validateContent">

<p class="from">
<label>From</label>
<input id="calfrom" type="text">
</p>
<p class="to">

<label>To</label>
<input id="calto" type="text">

</p>
<p>

<label>Service</label>

<select id="serviceSelect">
<option value="-200">Select All</option>
<?php if(isset($unique)) : foreach($unique as $row) : ?>


<?php switch ($row->Service) {
	case 1:
	$row->Service = "Google";
	;
	break;
	
	case 6:
	$row->Service = "Facebook";	
		;
	break;
	case -1:
			$row->Service = "Google display network";	
		;
		break;
		case 0:
			$row->Service = "BackOffice";	
		;
		break;
		
}?>

<option><?php echo $row->Service; ?></option>
<?php endforeach;?>

<?php endif;?>

</select>
<p>


<label>Status</label>

<select id="StatusSelect">
<option value="-200">Select All</option>

<?php if(isset($status)) : foreach($status as $row) : ?>

<?php switch ($row->computed) {
			case 10:
			$row->computed = "Succeeded";	
		;
		break;	
	case 9||0:
			$row->computed = "Failed";	
		;
		break;
		case null:
			$row->computed = "Pending";	
		;
		break;
	
		
}?>
<option><?php echo $row->computed;?> </option>
<?php endforeach;?>

<?php endif;?>
</select>

</p>


<a id="search">Retrieve</a>
<div class="clear"></div>
<p>
<label>Filter By</label>
<select id="filterSelect">
<option value="0">Show All</option>
<option value="1">Account ID</option>
<option value="2">Application</option>
<option value="3">Day Code</option>
<option value="4">Account Name</option>
</select>

</p>
<p class="filterp">
<label>Show All</label>
<input id="searchtxt" type="textbox"></input>
<p>

<a id="filterbtn" type="textbox">Filter</a>

</p>
</p>
<div class="clear"></div>
<div class="header"></div>
<table id="validationTable" rules="all">
<tr>
<th>AccountID</th>
<th>Account Name</th>
<th>Status</th>
<th>Service</th>
<th>Day Code</th>
<th>Retrieved Date</th>
<th>Application</th>


</tr>
	
	</tr>
<?php if(isset($result)) : foreach($result as $row) : ?>

<?php switch ($row->Status) {
	
	
	
	case 9||0:
			$row->Status = "Failed";	
		;
		break;
		case null:
			$row->Status = "Pending";	
		;
		break;
		case 10||1:
			$row->Status = "Succeeded";	
		;
		break;
		
}?>
<?php switch ($row->Service) {
	case 1:
	$row->Service = "Google";
	;
	break;
	
	case 6:
	$row->Service = "Facebook";	
		;
	break;
	case -1:
			$row->Service = "Google display network";	
		;
		break;
		case 0:
			$row->Service = "BackOffice";	
		;
		break;

}?>
<tr class="content"><td data-account="<?php echo $row->Account_ID;?>"><?php echo $row->Account_ID;?></td><td data-accountName="<?php echo $row->Account_Name;?>"><?php echo $row->Account_Name;?></td><td data-status="<?php echo $row->Status;?>"><?php echo $row->Status;?></td><td data-service="<?php echo $row->Service;?>" > <?php echo $row->Service;?></td><td data-DayCode="<?php  echo $row->DayCode;?>"><?php  echo $row->DayCode;?></td><td data-LastUpdated="<?php echo $row->LastUpdated;?>"><?php echo $row->LastUpdated;?></td><td data-app="<?php echo $row->Application;?>"><?php echo $row->Application;?></td></tr>
<?php endforeach;?>

<?php endif;?>



</table>

</div>

</div>
	
	
</div>


<script>

var myDate = new Date();
var months = (myDate.getMonth()+1);



if(months < 10){

	months = "0"+months;
}


         	
//var arr = ["OOVOO", "MeyEden", "888.com Sport - UK", "Yola", "Digital Fuel", "ForexAffiliate", "OptionRally", "Easy Forex", "Leascar", "Poker PCP - AT", "Poker PCP - UK", "PC Speed", "Conduit", "Conduit Publishers", "harmon.ie", "Lembex", "Radvision", "Pauza", "Kampyle", "Clicksoftware", "Bbinary", "888ladies - UK+IE", "Easytrade", "888Sport - UK", "Babylon", "DriversDoctor", "Scheffer", "BezeqInt", "Live Casino - AT", "888games - UK", "DietSolution", null, "Ask.com", "Poker 888.com - AT", "Proportzia", "Live Casino - UK", "Poker - 888Poker - UK", "Reefclubcasino - UK", "Eye Buy Direct", "Poker 888.com - UK+IE", "Seperia.com", "ReefClub Casino - AT", "InterTrader", "Casino - AT", "MoJob", "Daka90", "888Bingo - UK", "White Smoke", "TotalStay", "Top Scratch", "888Casino - UK", "Homeless", "888Sport Comp"];
var accountsarr= [];
var idsarray = [];
var applicationarr=[];
var daycodearr=[];
var daycode = <?php echo $daycode;?>;
var appplication =  <?php echo $application ;?>;
var accounts = <?php echo $accounts ;?>;
var ids = <?php echo $accountsids;?>;

$.each(ids,function(index,value){
	if(value.Account_ID != null){
		var q  = ""+value.Account_ID+"";
		idsarray.push(q);
	}
		
	});
$.each(daycode,function(index,value){
	if(value.DayCode != null){
		var q  = ""+value.DayCode+"";
		daycodearr.push(q);
	}
		
	});
$.each(accounts,function(index,value){
if(value.Account_Name != null){
	accountsarr.push(value.Account_Name);
}
	
});
$.each(appplication,function(index,value){
	if(value.Application != null){
		applicationarr.push(value.Application);
	}
		
	});
var service = $("select#serviceSelect").val();
var status=$("select#StatusSelect").val();
var text = $("#searchtxt").val();
$(function(){
	


	var fromDate = myDate.getFullYear()+'-'+months+'-'+ (myDate.getDate());
	var toDate = myDate.getFullYear()+'-'+months+'-'+ (myDate.getDate()+1);
	$("#calto,#calfrom").datepicker();
	$("#filterbtn,#search").button();
	$( "#calto,#calfrom" ).datepicker( "option", "dateFormat", 'yy-mm-dd' );

	$( "#calfrom").datepicker( "option", "defaultDate",fromDate );
	$( "#calto").datepicker( "option", "defaultDate",toDate);
	$( "#calfrom").val(fromDate);
	$( "#calto").val(toDate);
	 $("select#StatusSelect").val("Failed");
	search();
	
	 

	 $("#filterSelect").change(function(){
			var $this = $(this);
			if($this.val() == 0){
				$(".filterp label").text("Show All");

				$("td").parent().show();
				
				}
			if($this.val() == 1){
				$(".filterp label").text("Account ID");
				$("#searchtxt").show();
				$("#searchtxt").autocomplete({
					
					
					 source: 	idsarray,
					    minLength: 0

					 } );
				}
			if($this.val() == 2){
				$(".filterp label").text("Application");
			
				$("#searchtxt").autocomplete({
					
					
					 source: 	applicationarr,
					    minLength: 0

					 } );
				
				}
			if($this.val() == 3){
				$(".filterp label").text("Day Code");
				
				 $("#searchtxt").autocomplete({
						
						
					 source: daycodearr,
					    minLength: 0

					 } );
				
				}
			if($this.val() == 4){
				$(".filterp label").text("Account Name");
			
				 $("#searchtxt").autocomplete({
						
						
					 source: accountsarr,
					    minLength: 1

					 } );

				}
		 });

	
	 $("#filterbtn").click(function(){
		 var accountval = $("#searchtxt").val();
		
			 if($("#filterSelect").val() == 1){
			$("td[data-account!='"+accountval+"']").parent().hide();
			$("td[data-account='"+accountval+"']").parent().show();
			 }
			 else if($("#filterSelect").val() == 2){

				 $("td[data-app!='"+accountval+"']").parent().hide();
					$("td[data-app='"+accountval+"']").parent().show();
				 }
			 else if($("#filterSelect").val() == 3){

				 $("td[data-daycode!='"+accountval+"']").parent().hide();
					$("td[data-daycode='"+accountval+"']").parent().show();
				 }
			 else if($("#filterSelect").val() == 4){
				 $("td[data-accountname!='"+accountval+"']").parent().hide();
					$("td[data-accountname='"+accountval+"']").parent().show();
				 }
			 else
			 {
					$("td").parent().show();
				 }
				 
		
		

		 return false;
		
	 });
		$("#search").click(function(){
			var From = $("#calfrom").val();
			 var To = $("#calto").val();
			 var rawstartdate = From.split("-")[0]+From.split("-")[1]+From.split("-")[2];
			 var rawenddate = To.split("-")[0]+To.split("-")[1]+To.split("-")[2];
	
			
			search();
		
	
			 return false;
			});
});
function filterByservice(serviceval){

	
	$("td[data-service!='"+serviceval+"']").parent().hide();
	
  		$("td[data-service='"+serviceval+"']").parent().show();
	if(serviceval=="-200"){
		$("td[data-service]").parent().show();

		}


}
function filterByStatus(statusval){
	
	$("td[data-status!='"+statusval+"']").parent().hide();
	$("td[data-status='"+statusval+"']").parent().show();

	}


function search(filter){
	
		var localstatus = $("select#StatusSelect").val();
		var localservice = $("select#serviceSelect").val();
		 var From = $("#calfrom").val();
		 var To = $("#calto").val();
	
		
		
		//	From = 	 From.split("-")[0]+From.split("-")[1]+From.split("-")[2];
		//	To= To.split("-")[0]+To.split("-")[1]+To.split("-")[2];

			
		  if(localstatus=="Pending")
		{
			status = null;
		}
		else  if(localstatus=="Succeeded")
		{
			status = "10";
		}
		else  if(localstatus=="Failed")
		{
			status = "9";
		}
		else if(localstatus=="200"){
			status = "200";
		}
		else 
		{
			status = "200";
			}
	
		if(localservice == "Google"){
		
			service ="1";
		}
			
		else if(localservice == "Facebook"){
		
			service ="6";
		}
		else if(localservice == "Google display network"){
		
			service ="-1";
		}	
		else if(localservice == "BackOffice"){
		
			service ="0";
		}		
		else if(localservice=="-200"){
			service = "200";
		}
		
		
		$.ajax({
		     type: "GET",
		     url:"AccountValidation/search/"+status+"/"+service+"/"+From+"/"+To+"",
		    success: function(data) {
		           var result = jQuery.parseJSON(data);
		          
		           $("#validationTable tr.content").remove();
		           $("#validationtmpl").tmpl(result).appendTo("#validationTable");

			
		    },
		    error:function(data){
		    	 window.handleError(data);
		    },
		    complete:function(data){
			  var result = jQuery.parseJSON(data);
			
			    $("td[data-status='Failed']").css("color","red").siblings().css("color","red");
			
			    
		    }
		  });

	
	
}



</script>

<style>
#validateContent{
width:100%;

}
table{

 margin:0 auto 0 20px ;
border:1px solid  #C2C3C5;
width:90%;

}
table td,table th{
color:#666;
text-align:center;
border:1px solid  #C2C3C5;
}

.header{
    background-color:#8D8D8D;
        height:20px;
        -moz-border-radius:5px 5px 0px 0px;
        width:90%;
        margin:30px auto 0 20px ;
        float:left;
      	border: 1px solid #8D8D8D;

    }
    .ui-datepicker-header{
    border:0;
   
    
    }
     .ui-datepicker-calendar{
     background-color:white;
     
     }
     #validateContent p{
     float:left;
    width:15%;
    margin-left:30px;
 
     }
       #validateContent p.from{
       
       width:15%;
      
       }
     #filterbtn{
     float:left;
       margin-left: -30px;
    margin-top: 10px;
     }
    #search{
      margin-left: 20px;
     margin-top:20px;
    width:100px;
   
    
    
  
    }
     .from,.to{
    
     float:left;
     
     }
      #calto,#calfrom{
     float:left;
     margin-left:5x;
       margin-right:5x;
     }
     .from label,.to label{
     float:left;
    /* margin-top:5px;*/
      margin-right:10x;
     
     }
     p label{
     float:left;
     width:100px;
     }
     .from input,.to input{
    /* float:left;
   margin-right:10x;
    margin-left:30px;
   */ 
   
     }
     
     .filterp{
     margin-top:12px;
     float:left;
     margin-bottom:0px;
     }
     .ui-autocomplete-input {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
		-moz-border-radius:0px;
	}
	 .ui-autocomplete-input:hover{
	 
	 	-moz-border-radius:0px;
	 }
	
</style>	