<script type="text/javascript">
		// Demo functions
		// **************
		$(function(){

			// External Link with callback function
			
		});
	</script>

	<script type="text/javascript">
		// Set up Sliders
		// **************
		$(function(){

			$('#slider1').anythingSlider({
				height              : 800,
				resizeContents      : true,
				startStopped    : false, // If autoPlay is on, this can force it to start stopped
				width           : 800,   // Override the default CSS width
				easing: 'easeInOutBack',
				theme:'metallic',
				 autoPlay            : false, 
				 forwardText         : "Next", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
				  backText            : "Back",
//				autoPlayLocked  : true,  // If true, user changing slides will not stop the slideshow
//				resumeDelay     : 10000, // Resume slideshow after user interaction, only if autoplayLocked is true (in milliseconds).
				onSlideComplete : function(slider){
					// alert('Welcome to Slide #' + slider.currentPage);
				}
			});

		

		});
	</script>
<style type="text/css" media="print">

</style>
</head>


	
	<div id="page-wrap">
	

			<br><br>

<!--[if lte IE 7]> <style type="text/css"> .thumbNav a { display: inline !important; } </style> <![endif]--> 


			<!-- AnythingSlider #1 -->
			<ul id="slider1">

		

				

		

			</ul>  <!-- END AnythingSlider #1 -->

		
	</div>


<div class="tmpl">
	
	<li id="step1">
					<div id="content">
            <h1>account wizard</h1>
            <div id="wrapper">
                <div id="steps">
           <form id="formElem" name="formElem" action="" method="post">
           <fieldset class="step">
		<form action="">
       
       <p>
       
       
       <label for="#appselect">Application</label>
       <select id="#appselect"></select>
       
       </p>
	        
	   </fieldset>
	     <input id="accounthirarchyinput" type="checkbox" ></input>
       <label>Create Account hirarchy</label>
	   <div class="clear"></div>
       <div id="bi">
        <fieldset class="step">
        <legend>BI</legend>
        <p>
       <label>BI Scope Name</label>
       <input type="text"></input>
         <input type="text"></input>
       </p>
       <p>
        <label>Bi Scope ID</label>
       <input type="text"></input>
         <input type="text"></input>
      
       </p>
 
        </fieldset>
       
       </div>
<div id="accounthirarchy">
       <fieldset class="step">
       <legend>Create Account hirarchy </legend>
       <p>
       <label>Account Name</label>
       <input type="text"></input>
         <input type="text"></input>
       </p>
       <p>
        <label>Client Name</label>
       <input type="text"></input>
         <input type="text"></input>
       
       </p>
       </fieldset>
       </div>
       </form>
                            
                
      </div>
      </div>
      </li>
      <li id="step2">
      <form action="">
	 <fieldset>
       <legend>Add Active Directory User </legend>
	   <p>
	    <label>User Name</label>
       <input type="text"></input>
	   
	   </p>
	  
	   <p>
	    <label>Password</label>
       <input type="text"></input>
	   
	   </p>
	   <p>
	    <label>Full Name</label>
       <input type="text"></input>
	   
	   </p>
	    </fieldset>
		</form>
		</li>
		<li id="step3>
		
		<form action="">
	 <fieldset>
       <legend>Add BI Role </legend>
	   <p>
	    <label>Role Name</label>
       <input type="text"></input>
	   
	   </p>
	  
	   <p>
	    <label>Role ID</label>
       <input type="text"></input>
	   
	   </p>
	   <p>
	    <label>Role Member Name</label>
       <input type="text"></input>
	   
	   </p>
	    </fieldset>
		</form>
		
		</form>
      
      </li>
	<li id="step3">
	
		<div id="tabs">
		<ul>
            <li><a href="#tabs-1">General</a></li>
            <li><a href="#tabs-2">BE Data</a></li>
            <li><a href="#tabs-3">Aquisition</a></li>
            <li><a href="#tabs-4">String Replace</a></li>
     	</ul>
     
	<div id="tabs-1">
		<form action="">
		<p>
		   <input id="contentCheck" type="checkbox"></input>
	    <label>Has Content</label>
    
	   
	   </p>
		<p>
		   <input id="ProccessCubeCheck" type="checkbox"></input>
	    <label>Proccess Cube</label>
    
	   
	   </p>
		
		</form>
	</div>
	<div id="tabs-2">
	<form action="">
	<p>
	<label>Be Data</label>
	<select id="bedata">
	<option>Be Data</option>
	</select>
	</p>
	<p>
	<label>Replace With</label>
	<input id="replacer" type="text"/>
	<input id="calccheck" type="checkbox"></input>
	<label>Calc Members Only</label>
	<a  id="replacebtn" href="#">Add</a>
		<a  id="clear" href="#">Clear</a>
	</p>
	<table id="replace">
	<tr><th>From</th><th>To</th><th>Only Calc</th></tr>
	
	
	</table>
	</form>
	</div>
	<div id="tabs-3">
	
	</div>
	<div id="tabs-4">
	</div>
		</div>
	
	</li>

	</div>



<script type="text/javascript">
var step1 ;
var step2 ;
var step3 ;
var i = 1;
$(function(){
	$("#bi").hide();
	 getStep(i);
	
	$("#tabs").tabs();
$("#accounthirarchyinput").click(function(){
	
		if($("#accounthirarchyinput").is(":checked")){
			$("#accounthirarchy").show();
			$("#bi").hide();
		}
		else
		{
			$("#accounthirarchy").hide();
			$("#bi").show();
			}
			
	
		
			

			});

$("span.forward a").live("click",function(){


	if(i == 1){

	 getStep(i+1);
	
	}
	else
	{
		 getStep(i);
		}
	// $('#slider1').data('AnythingSlider').goForward();

i++;


	return false;
	
});	

$("#replacebtn").button();
$("#clear").button();

$("#clear").click(function(){

$("#replace tr td").remove();

return false;
});
$("#replacebtn").click(function(){

var value = $("#bedata option:selected").text();
var calc;

if($("#calccheck").is(":checked")!= true){

calc = "N";
}
else
{
calc = "Y";
}

var replacer = $("#replacer").val();

$("#replace").append("<tr><td>"+value+"</td><td>"+replacer+"</td><td>"+calc+"</td><td class='del'>&nbsp;</td></tr>");

return false;

});

$(".del").live("click",function(){

$(this).parent().remove();

});
});


function getStep(i){


		var current = i;
		$.ajax({
		  url: "steps/step"+i,
		  success: function(data){
				var step = data;
				var current = $('#slider1').data('AnythingSlider').currentPage;
				var step1 = $(".tmpl").find('#'+step);
				
			
			$("#slider1").append(step1);
		
	
		$("#slider1").anythingSlider();
		// $('#slider1').data('AnythingSlider').goForward();
		 },
		 complete:function(){
		
			 }
	});
	
		
}

</script>
<style type="text/css">
#navigation ul li a:hover,
#navigation ul li.selected a{
    background:#d8d8d8;
    color:#666;
    text-shadow:1px 1px 1px #fff;
}
span.checked{
    background:transparent url(../images/checked.png) no-repeat top left;
    position:absolute;
    top:0px;
    left:1px;
    width:20px;
    height:20px;
}
span.error{
    background:transparent url(../images/error.png) no-repeat top left;
    position:absolute;
    top:0px;
    left:1px;
    width:20px;
    height:20px;
}
 form fieldset{
    border:none;
    padding-bottom:20px;
}
 form legend{
    text-align:left;
    background-color:#f0f0f0;
    color:#666;
    font-size:24px;
    text-shadow:1px 1px 1px #fff;
    font-weight:bold;
    float:left;
    width:590px;
    padding:5px 0px 5px 10px;
    margin:10px 0px;
    border-bottom:1px solid #fff;
    border-top:1px solid #d9d9d9;
}
 form p{
    background-color: #F4F4F4;
    border: 1px solid #FFFFFF;
    border-radius: 5px 5px 5px 5px;
    box-shadow: 0 0 3px #AAAAAA;
    clear: both;
    float: left;
    margin: 0 0 5px;
    padding: 10px;
    width: 820px;
}
form p label{
    width:133px;
    float:left;
    text-align:right;
    margin-right:15px;
    line-height:26px;
    color:#666;
    text-shadow:1px 1px 1px #fff;
    font-weight:bold;
    margin-top:10px;
}
 form input:not([type=radio]),
 form input:not([type=checkbox]),
 form textarea,
 form select{
    background: #ffffff;
    border: 1px solid #ddd;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    outline: none;
    padding: 5px;
    width: 200px;
    float:left;
    margin-top:10px;
}
 form input:focus{
    -moz-box-shadow:0px 0px 3px #aaa;
    -webkit-box-shadow:0px 0px 3px #aaa;
    box-shadow:0px 0px 3px #aaa;
    background-color:#FFFEEF;
}
 form p.submit{
    background:none;
    border:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    box-shadow:none;
}
 form button {
	border:none;
	outline:none;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    color: #ffffff;
    display: block;
    cursor:pointer;
    margin: 0px auto;
    clear:both;
    padding: 7px 25px;
    text-shadow: 0 1px 1px #777;
    font-weight:bold;
    font-family:"Century Gothic", Helvetica, sans-serif;
    font-size:22px;
    -moz-box-shadow:0px 0px 3px #aaa;
    -webkit-box-shadow:0px 0px 3px #aaa;
    box-shadow:0px 0px 3px #aaa;
    background:#4797ED;
}
 form button:hover {
    background:#d8d8d8;
    color:#666;
    text-shadow:1px 1px 1px #fff;
}
#bi{
display:none;
}
.clear{

clear:both;
}
#accounthirarchyinput{
margin:0px 0px 0px 10px;
padding:0px;
width:5px !important;
}
div.anythingSlider-metallic .anythingWindow {
	border-top: 3px solid #333;
	border-bottom: 3px solid #333;
}
div.anythingSlider-metallic .thumbNav a {
	border: 1px solid #000;
}
div.anythingSlider-metallic .start-stop {
	border: 1px solid #000;
}
div.anythingSlider-metallic .start-stop.playing {
	background-color: #300;
}
div.anythingSlider-metallic .start-stop:hover, div.anythingSlider-metallic .start-stop.hover {
	color: #ddd;
}

/* Active State */
div.anythingSlider-metallic.activeSlider .anythingWindow {
	border-color: #0355a3;
}
div.anythingSlider-metallic.activeSlider .thumbNav a {
	background-color: transparent;
	background-position: -68px -40px;
}
div.anythingSlider-metallic.activeSlider .thumbNav a:hover, div.anythingSlider-metallic.activeSlider .thumbNav a.cur {
	background-position: -76px -57px;
/*	background: #fff; */
}
div.anythingSlider-metallic.activeSlider .start-stop.playing {
	background-color: #f00;
}
div.anythingSlider-metallic .start-stop:hover, div.anythingSlider-metallic .start-stop.hover {
	color: #fff;
}

/* Navigation Arrows */
div.anythingSlider-metallic .arrow {
	top: 30%;
	position: absolute;
	display: block;
	z-index: 100;
}
div.anythingSlider-metallic .arrow a {
	display: block;
	height: 95px;
	margin-top: -47px; /* half height of image */
	width: 45px;
	outline: 0;
	background: url(./assets/img/arrows-metallic.png) no-repeat;
	text-indent: -9999px;
}
div.anythingSlider-metallic .forward { right: 0; }
div.anythingSlider-metallic .back { left: 0; }
div.anythingSlider-metallic .forward a { background-position: right bottom; }
div.anythingSlider-metallic .back a { background-position: left bottom; }
div.anythingSlider-metallic .forward a:hover, div.anythingSlider-metallic .forward a.hover { background-position: right top; }
div.anythingSlider-metallic .back a:hover, div.anythingSlider-metallic .back a.hover { background-position: left top; }

/* Navigation Links */
div.anythingSlider-metallic .anythingControls {
	position: absolute;
	width: 80%;
	bottom: 0;
	right: 15%;
	z-index: 100;
	opacity: 0.90;
	filter: alpha(opacity=90);
}
div.anythingSlider-metallic .thumbNav {
	float: right;
	margin: 0;
	z-index: 100;
}
div.anythingSlider-metallic .thumbNav li {
	display: block;
	float: left;
}
div.anythingSlider-metallic .thumbNav a {
	display: block;
	background: transparent url(./assets/img/arrows-metallic.png) -68px -136px no-repeat;
	height: 10px;
	width: 10px;
	margin: 3px;
	padding: 0;
	text-indent: -9999px;
	outline: 0;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
div.anythingSlider-metallic .thumbNav a:hover, div.anythingSlider-metallic .thumbNav a.cur {
	background: transparent url(./assets/img/arrows-metallic.png) -76px -57px no-repeat;
}

/* slider autoplay right-to-left, reverse order of nav links to look better */
div.anythingSlider-metallic.rtl .thumbNav a { float: right; } /* reverse order of nav links */
div.anythingSlider-metallic.rtl .thumbNav { float: left; }    /* move nav link group to left */
/* div.anythingSlider-metallic.rtl .start-stop { float: right; } */ /* move start/stop button - in case you want to switch sides */

/* Autoplay Start/Stop button */
div.anythingSlider-metallic .start-stop {
	margin: 3px;
	padding: 0;
	display: inline-block;
	width: 14px;
	height: 14px;
	position: relative;
	bottom: 2px;
	left: 0;
	z-index: 100;
	text-indent: -9999px;
	float: right;
	border-radius: 7px;
	-moz-border-radius: 7px;
	-webkit-border-radius: 7px;
}

/* Extra - replace defaults */
div.anythingSlider-metallic {
	padding: 6px 23px;
}

.tmpl{

display:none;
}
#replace{
    float: left;
color:#666666;
}
#replace th{
width:100px;

}
#replace td{

text-align:center;
}

.del{
background:url("assets/img/x_03.png") no-repeat scroll 0 0 transparent;
    width: 10px;

}

input[type="checkbox"]{
padding:0px;
margin:15px -20px 0 8px !important;
width:2px !important;

}
form p label{

font-size:10px;
}
</style>