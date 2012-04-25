
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
	         <a href="#" class="nextbt">next</a>
	   </fieldset>
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
        <input id="accounthirarchyinput" type="checkbox" ></input>
       <label>Create Account hirarchy</label>
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
                <div id="navigation" style="display:none;">
                    <ul>
                        <li class="selected">
                            <a href="#">Account</a>
                        </li>
                        <li>
                            <a href="#">Personal Details</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </div>

<script>
$(function(){


	$("#wizard").tabs();
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
	
		

		

	
});
var fieldsetCount = $('#formElem').children().length;

/*
current position of fieldset / navigation link
*/
var current 	= 1;

/*
sum and save the widths of each one of the fieldsets
set the final sum as the total width of the steps element
*/
var stepsWidth	= 0;
var widths 		= new Array();
$('#steps .step').each(function(i){
    var $step 		= $(this);
	widths[i]  		= stepsWidth;
    stepsWidth	 	+= $step.width();
});
$('#steps').width(stepsWidth);

/*
to avoid problems in IE, focus the first input of the form
*/
$('#formElem').children(':first').find(':input:first').focus();	

/*
show the navigation bar
*/
$('#navigation').show();

/*
when clicking on a navigation link 
the form slides to the corresponding fieldset
*/
$('#navigation a').bind('click',function(e){
	var $this	= $(this);
	var prev	= current;
	$this.closest('ul').find('li').removeClass('selected');
    $this.parent().addClass('selected');
	/*
	we store the position of the link
	in the current variable	
	*/
	current = $this.parent().index() + 1;
	/*
	animate / slide to the next or to the corresponding
	fieldset. The order of the links in the navigation
	is the order of the fieldsets.
	Also, after sliding, we trigger the focus on the first 
	input element of the new fieldset
	If we clicked on the last link (confirmation), then we validate
	all the fieldsets, otherwise we validate the previous one
	before the form slided
	*/
    $('#steps').stop().animate({
        marginLeft: '-' + widths[current-1] + 'px'
    },500,function(){
		if(current == fieldsetCount)
			validateSteps();
		else
			validateStep(prev);
		$('#formElem').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();	
	});
    e.preventDefault();
});

/*
clicking on the tab (on the last input of each fieldset), makes the form
slide to the next step
*/
$('#formElem > fieldset').each(function(){
	var $fieldset = $(this);
	$fieldset.children(':last').find(':input').keydown(function(e){
		if (e.which == 9){
			$('#navigation li:nth-child(' + (parseInt(current)+1) + ') a').click();
			/* force the blur for validation */
			$(this).blur();
			e.preventDefault();
		}
	});
});

/*
validates errors on all the fieldsets
records if the Form has errors in $('#formElem').data()
*/
function validateSteps(){
	var FormErrors = false;
	for(var i = 1; i < fieldsetCount; ++i){
		var error = validateStep(i);
		if(error == -1)
			FormErrors = true;
	}
	$('#formElem').data('errors',FormErrors);	
}

/*
validates one fieldset
and returns -1 if errors found, or 1 if not
*/
function validateStep(step){
	if(step == fieldsetCount) return;
	
	var error = 1;
	var hasError = false;
	$('#formElem').children(':nth-child('+ parseInt(step) +')').find(':input:not(button)').each(function(){
		var $this 		= $(this);
		var valueLength = jQuery.trim($this.val()).length;
		
		if(valueLength == ''){
			hasError = true;
			$this.css('background-color','#FFEDEF');
		}
		else
			$this.css('background-color','#FFFFFF');	
	});
	var $link = $('#navigation li:nth-child(' + parseInt(step) + ') a');
	$link.parent().find('.error,.checked').remove();
	
	var valclass = 'checked';
	if(hasError){
		error = -1;
		valclass = 'error';
	}
	$('<span class="'+valclass+'"></span>').insertAfter($link);
	
	return error;
}

/*
if there are errors don't allow the user to submit
*/
$('#registerButton').bind('click',function(){
	if($('#formElem').data('errors')){
		alert('Please correct the errors in the Form');
		return false;
	}	
});
</script>

<style>
 span.reference{
            position:fixed;
            left:5px;
            top:5px;
            font-size:10px;
            text-shadow:1px 1px 1px #fff;
        }
        span.reference a{
            color:#555;
            text-decoration:none;
			text-transform:uppercase;
        }
        span.reference a:hover{
            color:#000;
            
        }
        h1{
            color:#ccc;
            font-size:36px;
            text-shadow:1px 1px 1px #fff;
            padding:20px;
        }
        #content{
    margin:15px auto;
    text-align:center;
    width:600px;
    position:relative;
    height:100%;
}
#wrapper{
    -moz-box-shadow:0px 0px 3px #aaa;
    -webkit-box-shadow:0px 0px 3px #aaa;
    box-shadow:0px 0px 3px #aaa;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
    border-radius:10px;
    border:2px solid #fff;
    background-color:#f9f9f9;
    width:830px;
    overflow:hidden;
}
#steps{
    width:830px;
	height:320px;
    overflow:hidden;
}
.step{
    float:left;
    width:830px;
	height:320px;
	 position: relative;
    top: 27px;
}
#navigation{
    height:45px;
    background-color:#e9e9e9;
    border-top:1px solid #fff;
    -moz-border-radius:0px 0px 10px 10px;
    -webkit-border-bottom-left-radius:10px;
    -webkit-border-bottom-right-radius:10px;
    border-bottom-left-radius:10px;
    border-bottom-right-radius:10px;
}
#navigation ul{
    list-style:none;
	float:left;
	margin-left:22px;
}
#navigation ul li{
	float:left;
    border-right:1px solid #ccc;
    border-left:1px solid #ccc;
    position:relative;
	margin:0px 2px;
}
#navigation ul li a{
    display:block;
    height:45px;
    background-color:#444;
    color:#777;
    outline:none;
    font-weight:bold;
    text-decoration:none;
    line-height:45px;
    padding:0px 20px;
    border-right:1px solid #fff;
    border-left:1px solid #fff;
    background:#f0f0f0;
    background:
        -webkit-gradient(
        linear,
        left bottom,
        left top,
        color-stop(0.09, rgb(240,240,240)),
        color-stop(0.55, rgb(227,227,227)),
        color-stop(0.78, rgb(240,240,240))
        );
    background:
        -moz-linear-gradient(
        center bottom,
        rgb(240,240,240) 9%,
        rgb(227,227,227) 55%,
        rgb(240,240,240) 78%
        )
}
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
#steps form fieldset{
    border:none;
    padding-bottom:20px;
}
#steps form legend{
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
#steps form p{
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
#steps form p label{
    width:133px;
    float:left;
    text-align:right;
    margin-right:15px;
    line-height:26px;
    color:#666;
    text-shadow:1px 1px 1px #fff;
    font-weight:bold;
}
#steps form input:not([type=radio]),
#steps form textarea,
#steps form select{
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
#steps form input:focus{
    -moz-box-shadow:0px 0px 3px #aaa;
    -webkit-box-shadow:0px 0px 3px #aaa;
    box-shadow:0px 0px 3px #aaa;
    background-color:#FFFEEF;
}
#steps form p.submit{
    background:none;
    border:none;
    -moz-box-shadow:none;
    -webkit-box-shadow:none;
    box-shadow:none;
}
#steps form button {
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
#steps form button:hover {
    background:#d8d8d8;
    color:#666;
    text-shadow:1px 1px 1px #fff;
}
</style>