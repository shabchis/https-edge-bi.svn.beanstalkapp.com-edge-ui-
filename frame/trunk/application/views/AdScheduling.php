<script id="facebooktmpl"  type="text/x-jquery-tmpl">
		
		{{if Campaign_Name}}
		<h2 class="facebooktrigger" data-Schedule ="${ScheduleEnabled}" data-campaign="${Campaign_GK}" ><span><a href="#" title="ID:${Campaign_GK}"> ${Campaign_Name}</a></span></h2>
        
       {{/if}}      

       


</script>
<script id="schedulertmpl"  type="text/x-jquery-tmpl">

	{{if Day=="1"}}
	<tr class="scheduleday" data-day="1" data-campaign="${Campaign_GK}">

		<td>Monday</td>
		<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td ><div data-hour="Hour00" data-state="${Hour00}"{{if Hour00}} class="${Hour00} day"{{else}} class="1 day" {{/if}}></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day" ></div></td>
		<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day" ></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day" ></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day" ></div></td>

	</tr>


       {{/if}}
        {{if Day=="2"}}
	<tr class="scheduleday" data-day="2" data-campaign="${Campaign_GK}">
        <td>Tuesday</td>
	<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td ><div data-hour="Hour00" data-state="${Hour00}" class="${Hour00} day" ></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day" ></div></td>
			<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day" ></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day" ></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day" ></div></td>
	</tr>
	      {{/if}}
       {{if Day=="3"}}
	<tr class="scheduleday" data-day="3" data-campaign="${Campaign_GK}">

		<td>Wednsday</td>
		<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td ><div data-hour="Hour00" data-state="${Hour00}" class="${Hour00} day" ></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day" ></div></td>
		<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day" ></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day" ></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day" ></div></td>
	</tr>
	      {{/if}}
                {{if Day=="4"}}
	<tr class="scheduleday" data-day="4" data-campaign="${Campaign_GK}">

		<td>Thursday</td>
		<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td ><div data-hour="Hour00" data-state="${Hour00}" class="${Hour00} day" ></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day" ></div></td>
		<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day" ></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day" ></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day" ></div></td>

	</tr>
       {{/if}}
     {{if Day=="5"}}
	<tr class="scheduleday" data-day="5" data-campaign="${Campaign_GK}">

		<td>Friday</td>
			<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td ><div data-hour="Hour00" data-state="${Hour00}" class="${Hour00} day" ></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day" ></div></td>
			<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day" ></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day" ></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day" ></div></td>
	</tr>
       	{{/if}}
    	{{if Day=="6"}}
	<tr class="scheduleday" data-day="6" data-campaign="${Campaign_GK}">

		<td>Saturday</td>
			<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td ><div data-hour="Hour00" data-state="${Hour00}" class="${Hour00} day" ></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day" ></div></td>
		<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day" ></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day" ></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day" ></div></td>
		</tr>
      {{/if}}
  {{if Day=="7"}}
	<tr class="scheduleday" data-day="7" data-campaign="${Campaign_GK}">
         <td>Sunday</td>
	<td><a class="all" href="#">All</a></td><td><a href="#" class="none"> None</a></td>
		<td><div data-hour="Hour00" data-state="${Hour00}" class="${Hour00} day" ></div></td>
		<td ><div data-hour="Hour01" data-state="${Hour01}" class="${Hour01} day" ></div></td>
		<td><div data-hour="Hour02" data-state="${Hour02}" class="${Hour02} day" ></div></td>
		<td><div data-hour="Hour03"  data-state="${Hour03}" class="${Hour03} day" ></div></td>
		<td><div data-hour="Hour04" data-state="${Hour04}"  class="${Hour04} day" ></div></td>
		<td><div  data-hour="Hour05" data-state="${Hour05}" class="${Hour05} day" ></div></td>
		<td><div data-hour="Hour06" data-state="${Hour06}" class="${Hour06} day" ></div></td>
		<td><div data-hour="Hour07" data-state="${Hour07}" class="${Hour07} day" ></div></td>
		<td> <div data-hour="Hour08" data-state="${Hour08}"  class="${Hour08} day" ></div></td>
		<td> <div data-hour="Hour09" data-state="${Hour09}" class="${Hour09} day" ></div></td>
		<td> <div data-hour="Hour10" data-state="${Hour10}" class="${Hour10} day" ></div></td>
		<td> <div data-hour="Hour11" data-state="${Hour11}" class="${Hour11} day" ></div></td>
		<td> <div data-hour="Hour12" data-state="${Hour12}" class="${Hour12} day" ></div></td>
		<td> <div data-hour="Hour13" data-state="${Hour13}" class="${Hour13} day" ></div></td>
		<td> <div data-hour="Hour14" data-state="${Hour14}" class="${Hour14} day" ></div></td>
		<td> <div data-hour="Hour15" data-state="${Hour15}" class="${Hour15} day" ></div></td>
		<td> <div data-hour="Hour16" data-state="${Hour16}" class="${Hour16} day"></div></td>
			<td> <div data-hour="Hour17" data-state="${Hour17}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour18" data-state="${Hour18}" class="${Hour17} day"></div></td>
		<td> <div data-hour="Hour19" data-state="${Hour19}" class="${Hour19} day"></div></td>
		<td> <div data-hour="Hour20" data-state="${Hour20}" class="${Hour20} day" ></div></td>
		<td> <div data-hour="Hour21" data-state="${Hour21}" class="${Hour21} day" ></div></td>
		<td> <div data-hour="Hour22" data-state="${Hour22}" class="${Hour22} day" ></div></td>
		<td> <div data-hour="Hour23" data-state="${Hour23}"  class="${Hour23} day"></div></td>
        </tr>
	   {{/if}}

</script>
<div id="messages">
<div id="enablemsg">

 
<h1>  <a id="en" href="#">Click here to enable ad scheduling</a></h1>
 


</div>
    <div id="disablemsg">

    <h1>You are about to disable ad scheduling, are you sure ?</h1>

    <a id="dis" href="#">Disable</a>
   <a class ="cancel" href="#">Cancel</a>

</div>
</div>
<div id="facebookmoadal">
  <h1></h1>
  <a href="#" id="state"></a>
    <div class="clear"></div>
<table id="fbtable" class="fbtable" rules="none">
	<th>
		<td></td>
		<td></td>
		<td class="hour"><span class="rotate">00:00</span></td>
		<td  class="hour"><span class="rotate">01:00</span></td>
		<td  class="hour"><span class="rotate">02:00</span> </td>
		<td  class="hour"><span class="rotate">03:00</span></td>
		<td  class="hour"><span class="rotate">04:00</span></td>
		<td  class="hour"><span class="rotate">05:00</span></td>
		<td  class="hour"><span class="rotate">06:00</span></td>
		<td class="hour"><span class="rotate">07:00</span></td>
		<td  class="hour"><span class="rotate">08:00</span></td>
		<td  class="hour"><span class="rotate">09:00</span></td>
		<td  class="hour"><span class="rotate">10:00</span></td>
		<td  class="hour"><span class="rotate">11:00</span></td>
		<td  class="hour"><span class="rotate">12:00</span></td>
		<td  class="hour"><span class="rotate">13:00</span></td>
		<td  class="hour"><span class="rotate">14:00</span></td>
		<td  class="hour"><span class="rotate">15:00</span></td>
		<td  class="hour"><span class="rotate">16:00</span></td>
		<td  class="hour"><span class="rotate">17:00</span></td>
		<td class="hour"><span class="rotate">18:00</span></td>
		<td class="hour"><span class="rotate">19:00</span></td>
		<td class="hour"><span class="rotate">20:00</span></td>
		<td class="hour"><span class="rotate">21:00</span></td>
		<td class="hour"><span class="rotate">22:00</span></td>
		<td class="hour"><span class="rotate">23:00</span></td>
	
	</th>
	</table>
	<span class="bottom">Ad scheduling lets you specify certain hours or days of the week when you want your ads to appear. </span><div class="clear"></div>
	<span class="bottom">Click the rectangles to change from <span class="greentext">active</span> to <span class = "redtext">paused</span> and vice versa.</span>
	
     <span class="link">All times<a target="_blank" href="http://www.thetimezoneconverter.com/">  Pacific Standard Time (PST) </a></span> 

</div>
<div id="facebookwrapper">
<div class="header">

		</div>
<div id="facebookcontent">

		
</div>



<script>
var boolEnabled="";
var campaignID = "";
var globalfacebook = "";
var gloabalJson = "" ;
var docwidth = $(window).width()*0.9;
var docheight = 500;
var globaltitle="";
$(function(){


var facebook = jQuery.parseJSON('<?php echo $facebook; ?>');
  globalfacebook =   facebook;
$("#facebooktmpl").tmpl(facebook).appendTo("#facebookcontent");

    if(facebook == ""){
      
    	$("#facebookwrapper").hide();
    }
  /*
  $("h2.facebooktrigger").each(function(){


     if( $(this).attr("data-schedule")== "false"){
                 $(this).css('background-color','red');


     }
    else
     {
        $(this).css('background-color','blue');
     }

  */


  });
 $("a#state").live("click",function(){

      if($(this).hasClass('false'))  {
          $(this).text("Enable");

        enable();


      }
     else
      {
             $(this).text("Disable");
           $("#facebookmoadal").css("overflow","hidden").scrollLeft(0);
         disable();
      }
     return false;

 });
$("#facebookcontent").delegate("h2.facebooktrigger","click",function(){
 //$("#fbtable").empty();

   $("#fbtable .scheduleday").remove();
 var enabler  = $(this).attr("data-schedule");
var campaign = $(this).attr("data-campaign");
  var title = $(this).text();
  globaltitle = title;
  // $("#facebookmoadal h1").text($(this).text());
campaignID =campaign ;


$.ajax({

  url: 'AdScheduling/getscheduler/'+getHashSegments().accountID+'/'+campaignID,
  success: function(data){

var json = jQuery.parseJSON(data);
       if(json.length > 0){

   $("#schedulertmpl").tmpl(json).appendTo("#fbtable");
      gloabalJson =   json;
    //  $("table td.hour").wrapInner("<span>").addClass('rotate')       ;

          }

      else
       {

       build();
           }


  },
    error:function(data,result){
	  _generalErrorHandler;
    },
    complete:function(data){
          $('#fbtable div.2').each(function(){

   $(this).addClass('red');

   });

    $('#fbtable div.0').each(function(){

   $(this).addClass('gray');

   });

     $('#fbtable div.1').each(function(){

   $(this).addClass('green');

   });

   $("a.all").live('click',function(){

   	$(this).parent().siblings().find('div').removeClass().addClass('1 green day').attr('data-state','1');


   	return false;
   });
$("a.none").live('click',function(){

   	$(this).parent().siblings().find('div').removeClass().addClass('2 red day').attr('data-state','2');

   	return false;
   });

   $('#fbtable tr').delegate('div','click',function(){
            /*
  		if($(this).attr('data-state')== 1 ){

  			$(this).removeClass('1 green').addClass('0 gray').attr('data-state','0');
  		}

  		*/
		 if($(this).attr('data-state')== 1 ){

  			$(this).removeClass('1 green').addClass('2 red day').attr('data-state','2');

  		}
       else if($(this).attr('data-state')== 2 ){

  			$(this).removeClass('2 red').addClass('1 green day').attr('data-state','1');
  		}

   });
    }
});
$("#facebookmoadal").dialog({
    autoOpen:false,
    resizable: true,
    title:"Ad Scheduling for"+ title,
	modal: true,
	 height:'400',
	buttons: { "Ok": function() {

                 update();

                  $(this).dialog("close");
                       $(".modal").remove();

                     return false;
                },
				"Cancel": function() {
					$( this ).dialog( "close" );
                    $(".modal").remove();

                    return false;
				}







    }

});



       if($(this).attr("data-schedule") == "false")
          {
                $(".modal").remove();
           $("a#state").removeClass().addClass("false").text("Enable");
               $('.ui-dialog-buttonpane button').eq(0).button().hide();
                $("#facebookmoadal").css("overflow-x","auto").scrollLeft(0);
            enable();
         }
       else
        {
              $(".modal").remove();
             
        $("a#state").removeClass().addClass("true").text("Disable ad scheduling for "+globaltitle);
             $("#facebookmoadal").css("overflow-x","auto").scrollLeft(0);
            boolEnabled = true;
        }
           $("#facebookmoadal").dialog({title:"Ad Scheduling for"+title});
          
           $( "#facebookmoadal" ).dialog( "option", "width", docwidth );
           $( "#facebookmoadal" ).dialog( "option", "height",docheight);
           $("#facebookmoadal").dialog("open");
    return false;
});

  $("a#en").live("click",function(){

    $(".modal").remove();
    $("#facebookmoadal").css("overflow-x","auto");
    $("a#state").attr("class","true").text("Disable ad scheduling for "+globaltitle);
    boolEnabled = true;
      $('.ui-dialog-buttonpane button').eq(0).button().show();
    return false;

    });
$("a#dis").live("click",function(){
    $(".modal").remove();
    $("a#state").attr("class","false").text("Enable");
    boolEnabled = false;
    update();
    $("#facebookmoadal").dialog("close");

    return false;

});
$("a.cancel").live("click",function(){
    $(".modal").remove();
         $("#facebookmoadal").css("overflow-x","auto");
         $('.ui-dialog-buttonpane button').eq(0).button().show();
    return false;
});

function update(){

    var jsonarr =[];
    var allDays = [];
      //   var campaignGK = $(this).attr('data-campaign');
    $('#fbtable tr.scheduleday').each(function(i, row)
    {
        var $this = $(this);
        var dayValues = [];

        $this.find('td div.day').each(function(i,cell)
        {
            var value = $(this).attr('data-state');
            dayValues.push(value == "" ? '1' : value);
        });
         allDays.push(dayValues);


        var jsonobj = {
        "AccountID":getHashSegments().accountID,
        "Campaign_GK":$(this).attr('data-campaign'),
        "Day":$(this).attr('data-day'),
        "Channel_ID":6,
        "ScheduleEnabled":boolEnabled,
        "Hour00":dayValues[0],
        "Hour01":dayValues[1],
        "Hour02":dayValues[2],
        "Hour03":dayValues[3],
        "Hour04":dayValues[4],
        "Hour05":dayValues[5],
        "Hour06":dayValues[6],
        "Hour07":dayValues[7],
        "Hour08":dayValues[8],
        "Hour09":dayValues[9],
        "Hour10":dayValues[10],
        "Hour11":dayValues[11],
        "Hour12":dayValues[12],
        "Hour13":dayValues[13],
        "Hour14":dayValues[14],
        "Hour15":dayValues[15],
        "Hour16":dayValues[16],
        "Hour17":dayValues[17],
        "Hour18":dayValues[18],
        "Hour19":dayValues[19],
        "Hour20":dayValues[20],
        "Hour21":dayValues[21],
        "Hour22":dayValues[22],
        "Hour23":dayValues[23]



        }
            jsonarr.push(jsonobj);

     });

            var jsonText = JSON.stringify(jsonarr);

    $.ajax({
    dataType:"json",
    type: "POST",
    data:jsonText,
    url:"AdScheduling/updateScheduler/"+getHashSegments().accountID+'/'+campaignID,
    success: function(data) {
               $('h2[data-campaign='+campaignID+']').attr('data-schedule',boolEnabled);
//         $('h2[data-campaign='+campaignID+']').css('background-color','red');



    },
    error:function(data){
    	 _generalErrorHandler;
        $("#error").show();


    },
    complete:function(){
             jsonarr.length = 0;


    }
  });




    return false;



}


function disable(){


     $(".modal").remove();
        $("#facebookmoadal").css("overflow","hidden");
 $("<div class='modal'></div>").html($("#disablemsg").html()).appendTo("#facebookmoadal");
      $('.ui-dialog-buttonpane button').eq(0).button().hide();
}


function enable(){
      $(".modal").remove();
    $("#facebookmoadal").css("overflow","hidden");
     $("<div class='modal'></div>").html($("#enablemsg").html()).appendTo("#facebookmoadal");



}
function build()
{
	boolEnabled= false;
    var week = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
     var tableMarkup = "";
    for (x = 1; x < 8; x++) {
        tableMarkup += "<tr class='scheduleday'  data-day='"+x+"' data-campaign='"+campaignID+"'>";

	}

    $("#fbtable").append(tableMarkup)    ;

    $("tr.scheduleday").each(function(i){

           var tds ="<td>"+week[i]+"</td><td><a class='all' href='#'>All</a></td><td><a href='#' class='none'> None</a></td>";

           for (x = 0; x < 24; x++)
           {
            if(x<10)
                x = "0"+x

                tds+="<td><div data-hour='HOUR"+x+"' data-state='1' class='1 day'></div></td>";

	       }

          $(this).html(tds);
      });

}


</script>	

<style>

	.header{
    background-color:#8D8D8D;
        height:20px;
        -moz-border-radius:5px 5px 0px 0px;
        width:90%;
        margin:0 auto 0 20px ;
        float:left;
      	border: 1px solid #8D8D8D;

    }
	#facebookwrapper{
	width: 100%;
	overflow:hidden;
}

#facebookcontent{
    width:90%;
    overflow:hidden;
    border-left: 1px solid #C2C3C5 ;
    border-right: 1px solid #C2C3C5 ;
     border-bottom: 1px solid #C2C3C5 ;
	float:left;
	

    margin: 0 auto 10px 20px;
 

}
h2.facebooktrigger {
 background: url("assets/img/grid_small.gif") no-repeat scroll 22px 50% #F5F5F5;
	
    border-top:1px solid #C2C3C5;
    float:left;
    font-family:"verdana";
    font-size:12px;
    font-weight:normal;
    height:23px;
    line-height:23px;
    margin:0;
    outline:medium none;
    padding:0 0 0 50px;
    width:100%;
        position:relative;
		width:95%\9;
 color: #616161;
}
h2.facebooktrigger a {
	
	text-decoration: none;
	display: block;
	color: #7CA81D;
    width:60%;

}

h2.facebooktrigger:hover{

   background: url("assets/img/grid_small.gif") no-repeat scroll 22px 50% #E3EDCB;
   
}
h2.facebooktrigger a:hover {
    color:#7CA81D;
    text-decoration:underline;
   
}

#facebookmoadal{

display: none;
    overflow-y:hidden;
 position:relative;
}	

#fbtable td{

font-size: 10px;
    color:#666;

}
 table td.hour     {
        font-weight:bold;
        font-size: 10px;

 }
#fbtable{
margin: 0 30px 30px 30px;
width: 90%;
height:100%:



}

table div {
margin:auto;
width: 100%;
height: 15px;
background-color: transparent;
text-align: center;
}
table td div.2{
background-color: green !important;
}
   table td:first-child{
       font-weight:bold;

   }
#fbtable th{


font-weight: bold;
     text-align: left;
font-size: 16px;
}

.red{
background-color: #DF4545;
}
.gray{
background-color: gray;
}
.green{
background-color: #77BF53;
}
.greentext{
color: #77BF53;
}
.redtext{
color: #DF4545;
}

    .rotate {
     -moz-transform: rotate(-45deg);  /* FF3.5+ */
       -o-transform: rotate(-90deg);  /* Opera 10.5 */
  -webkit-transform: rotate(-90deg);  /* Saf3.1+, Chrome */
      -ms-transform: rotate(-90deg);  /* IE9 */
          transform: rotate(-90deg);
             filter: progid:DXImageTransform.Microsoft.Matrix(/* IE6–IE9 */
                     M11=6.123233995736766e-17, M12=-1, M21=1, M22=6.123233995736766e-17, sizingMethod='auto expand');
               zoom: 1;
}
 #fbtable td span{

     margin-bottom:20px;
     display:block;
 }
   a#state{
      float:right;
       display:block;
       font-size:12px;
       text-decoration:underline;
       font-weight:normal;
       margin-bottom:10px;
       outline:none;
       margin-right:100px;


   }

    #default{

    }
    #facebookmoadal h1{
        font-size:14px;

    }
    .modal{
        margin:auto;
        height:100%;
        width:100%;
        position:absolute;
        z-index:100000 ;
        background-color:white;
        opacity:0.9;
        bottom:-5px;
        left:0px;
     overflow:hidden;
        text-align: center;


    }
     #facebookmoadal a{
          color:#90B63D;
      }
    #disablemsg, #enablemsg {
    background-color: white;
    height: 89%;
    left: 25%;
    margin: 0;
    opacity: 1 !important;
    position: relative;
    top: -9px;
    width: 50%;
    z-index: 1000000;
        display:none;
}
  .modal h1, .modal h1{
       font-size:12px;
       opacity:1;
      margin-top:5%;

   }
    .modal a, .modal a{
        opacity:1;
        margin:10px ;
        float:none;
        font-size:12px;
    }
    .clear{
        clear:both;

    }
    span.link{
    display:block;
     margin: 0 17px 30px 0px;
    width: 300px;
    float:right;
    
    
    }
     span.bottom{
      display:block;
     margin:0 10px 0px 30px;
	width:50%;
    float:left;
    
     
     }
     .tooltip{
     display:block;
     width:30px;
     background-color:red;
     }
</style>
