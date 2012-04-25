// Adds the indexOf function for internet explorer 
if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length >>> 0;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}

function checkJavaSupport () {
	  var result = { 
	    javaEnabled: false,
	    version: ''
	  };
	  if (typeof navigator != 'undefined' && typeof navigator.javaEnabled != 'undefined') 
	    result.javaEnabled = navigator.javaEnabled();
	  else
	    result.javaEnabled = 'unknown';
	  if (navigator.javaEnabled() && typeof java != 'undefined')
	    result.version = java.lang.System.getProperty("java.version");
	  return result;
	}


	
var parentAccount = "";
var subaccount = "";
$(function(){
    
    
  $("#modal small a").live('click',function(){
  
  $("#modal #content").slideToggle("slow");
  
  return false;
});
var selectedAccount = $("#selected").text();


/*
$("#modal").html('<h2>A PHP Error was encountered</h2><small><a href="#">Details</a></small><div id="content"><p> Severity: Notice Message: Undefined index: Intelligence/Dashboard/Test1/Filename: controllers/iframe.php Line Number: 11</p></div>').dialog({
	title:'Edge.BI Error',
	modal: true,
	resizable: false,
	buttons: {
				"OK": function() {
					$( this ).dialog( "close" );
				}
				
			}

});

*/
  var viewportHeight =$(window).height();
  var headerHeight = $('header').outerHeight();
function frameheight(){

  


$("#main").height(viewportHeight -headerHeight-70);

$("#frame").height($("#main").height());
  if($.browser.msie){
   $("#main").height(viewportHeight-headerHeight-100);
   $("#frame").height($("#main").height());
   
 
   
}
}
/*
  $("#modal #content").text($("iframe").height()+'px').dialog({
  title:'Edge.BI Error',
  modal: false,
  resizable: false,
  buttons: {
        "OK": function() {
          $( this ).dialog( "close" );
        }
        
      }

});
*/
	//$('#accountwrapper').jScrollPane({scrollbarWidth:20, scrollbarMargin:10,showArrows:true});
	
	
	//alert($('#main').height());
/*
	var javaCheck = checkJavaSupport();
	if(!javaCheck.javaEnabled){
		window.location  = 'http://javadl.sun.com/webapps/download/AutoDL?BundleId=44472';
	}

	/*
		if($.browser.java){
			console.log("You don't to java installed ");
		
		}
		*/	
		

 frameheight();


	
	
	var selected = $("#selected");
	 //DD_roundies.addRule('#accounts', '5px');
	 
	// var length = $("#Campaign").html().length;
	
	//$("#breadcrumbs ul li:last-child").addClass("last-child");
	
	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$('h2.trigger').removeClass("active").next().hide();
	
	$('h2.true').addClass("active").next().slideToggle("fast");
		
	$("h2.trigger").click(function(){
		$(this).toggleClass("active").next().slideToggle("fast");
	
	}
	);
	
	$("#main").ajaxStart(function(){
		$("#ajaxloader").fadeIn(500);	
	});
	
	$("#main").ajaxComplete(function(){
		$("#ajaxloader").fadeOut(500);
	});
	$("#main").ajaxError(function(){
		$("#ajaxloader").fadeOut(500);
	});

	// -------------------------------------------
	// Hash changes
	$(window).bind('resize',function() {
		 frameheight();
	
	});

	$(window).hashchange(function()
	{

	if(selectedAccount){
	
}
		// If there is only one account, hide the drop down
		if (_accountdata.length < 2)
			$('#arrow').hide();

		// Get path info			
		var hashSegments = getHashSegments();
     	var accountListItem;
     	var wasAccountSpecified = false;

     	if (hashSegments && hashSegments.accountID)
     	{
     	 	accountListItem = $("#" + hashSegments.accountID);
     	 	wasAccountSpecified = true;
     	 
     	}
     	
     	// Check if nothing was found for this item
     	if (!wasAccountSpecified)
     	{
     		var firstID = _accountdata[0].ID;
     		
     		window.location.hash = "#accounts/" + firstID;
     		return;
     	}
     	
     	//================================================
     	// Update menu permissions according to selected account
     	applyMenuPermissions(null,null);
     	
     	
     	//================================================
     	var url = $("#selected").text();
    	var $parents = "";
    	var $sub  = "";
    	var $accountId="";  
    	var $link ='<a TARGET="_blank" href="http://'+accountListItem.attr("data-url")+'">'+accountListItem.attr("data-url")+'</a>';
    	
    		
    	if (!accountListItem || !accountListItem.length)
    	{
 		  	window.location.hash = "#accounts/" + _accountdata[0].ID;		

    		//$sub = "(Invalid Account)";
    		//$('#arrow').show();
    		
    		/*
    		$parents = _accountdata[0].Name;
    		$sub = "Top Level Account";
    		*/
    		
    	}
    	else if(accountListItem.hasClass("parent"))
    	{
    		 $parents = accountListItem.siblings(".campaign").find("span").text();
    		 $sub  = accountListItem.find('a:first').text();
    		
    		 $accountId = accountListItem.siblings(".campaign").attr("id");
     	}
    	else if(accountListItem.hasClass("campaign"))
    	{
			$parents = 	accountListItem.find("span").text();
			$sub  = $link;
			$accountId = accountListItem.attr("id");
    	}
    	else
    	{
			$parents = accountListItem.parent().parent().siblings(".campaign").find("span").text();
			$sub = accountListItem.text()  ;
			 console.log(accountListItem);
			$accountId = accountListItem.parent().parent().siblings(".campaign").attr("id");
    	}
    	parentAccount = $parents;
    	subaccount = $sub;
    	// Set cookies
    	$.cookie("edgebi_child_account",accountListItem.attr("id"),{expires: 14});
    	$.cookie("edgebi_parent_account",$accountId,{expires: 14});
    	
    	$("#selected").html($parents);
		$("#selected").attr("class",$accountId);
		
		$("#Campaign").html($sub);
		
		// Change menu item hrefs
		$('#sub li.menuheader  a').each(function(){
			$(this).attr("href", "accounts/"+ hashSegments.accountID + "/" +$(this).attr("data-path"));
		});
		
     	 //================================================
      
		$.ajax({
			url: hashSegments.fullHash,
			
			success: function(data)
			{
				$('#main').html(data);
			},
			
			error: _generalErrorHandler,
			
			complete:function(data)
			{
				
				$("#sub li").removeClass("current");
				$("#sub li a[data-path="+hashSegments.path+"]").parent().addClass("current");
				$("#sub li a.menuitem").removeClass("current");
				
				var item = $("#sub a").parent(".current");
				var text = item.text();
				var content =""	;
				var $parent = "";
				var $grand = "";
				var account = $('#selected').text()+'->'+$("#Campaign").text() ;
			
				
				if(item.parent("ul").hasClass("parent"))
				
				{
					$parent = item.parent("ul.parent").attr("data-name");
					$section = item.parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
				 	content =	$("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$parent+"</li><li class='bread'></li><li class='last'>"+item.find("a:first").text()+"</li></ul>");	
					$("#breadcrumbs").html(content);
					
					if($section.length == 0){
						document.title = 'Edge.BI';
					}
					
					else
					{
						document.title = 'Edge.BI'+'-'+$section+'->'+$parent+'->'+item.find("a:first").text();

					}
				}	
				else if(item.parent().parent().parent("ul").hasClass("parent"))
				{
					$parent = item.parent("ul").attr("data-name");
					$grand = item.parent().parent().parent("ul.parent").attr("data-name");
					$section = item.parent().parent().parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
					 content =	$("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$grand+"</li><li class='bread'></li><li>"+$parent+"</li><li class='bread'></li><li class='last'>"+text+"</li></ul>");
					$("#breadcrumbs").html(content);
				
					if($section.length == 0){
						document.title = 'Edge.BI';
					}
					else
					{
					document.title ='Edge.BI'+'-'+$section+'->'+$grand+'->'+$parent+'->'+text;
					}
				}
				else if(item.parent().hasClass("list"))
				{
					$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>"+$section+"</li><li class='bread'></li><li class='last'>"+item.find("a:first").text()+"</li></ul>");
					$("#breadcrumbs").html(content);
				
					
					if($section.length == 0){
						document.title = 'Edge.BI';
						
					}
					
					else
					{
						document.title ='Edge.BI'+'-'+$section+'->'+item.find("a:first").text();
					}
					

				}
				else
				{
					$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>"+$section+"</li><span></span><li class='last'>"+text+"</li></ul>");
					$("#breadcrumbs").html(content);
				
					if($section.length == 0)
					{
						document.title = 'Edge.BI';
					}
					
					else
					{
						document.title = 'Edge.BI'+'-'+$section+'->'+text;
					}
					
				}
				
				
			}
	
		});

	});
    
    // Force a hash change on load
    if (getHashSegments())
    {
    	$(window).hashchange();
    }
    else
    {
	    var cookieAccount = $.cookie("edgebi_child_account");
	    if (cookieAccount && window.location.hash.length < 2)
	    	window.location.hash = "#accounts/"+cookieAccount;
	    else
	    	$(window).hashchange();
    }
		
	
	// -------------------------------------------
	// Account operations
			
    $("#accountwrapper").delegate("li","click",function(){

		var hashSegments =  getHashSegments();
    	var link = $(this).find("a").attr("href");
    	var appendPath = hashSegments != null ?  "/" + hashSegments.path : '';
		
		// hide the menu
		$("#arrow").click();
	 
    	window.location.hash = "#" + link + appendPath;
    
		return false;
	});
   
   		
    // -------------------------------------------
    // Menu operations    
	
 	
	$("#sub").delegate("a", "click", function()
	{
		if($(this).hasClass('disabled')){
			
			return false;
		}
		$(this).parent("li").removeClass("current");
		$(this).parent("li").addClass("current");

		
		var hashSegments = getHashSegments();
		if(!hashSegments || !hashSegments.accountID)
		{
			alert("please choose an account");
			return false;
		}

		location.hash = $(this).attr("href");
		
		//VVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVVV
		// TODO: KIIIIIIIIIIIIIIIILLLL this section
		var item = $(this).parent(".current");
		var text = item.text();
		var content =""	;
		var $parent = "";
		var $grand = "";

		if(item.parent("ul").hasClass("parent"))
		{
			$parent = item.parent("ul.parent").attr("data-name");
			$section = item.parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
			
			content = $("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$parent+"</li><li class='bread'></li><li class='last'>"+item.find("a:first").text()+"</li></ul>");
			$("#breadcrumbs").html(content);
		}	
		else if(item.parent().parent().parent("ul").hasClass("parent"))
		{
			$parent = item.parent("ul").attr("data-name");
			$grand = item.parent().parent().parent("ul.parent").attr("data-name");
			$section = item.parent().parent().parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
		 	content =	$("<ul><li>"+$section+"</li><li class='bread'></li><li class='last'>"+$grand+"</li><li class='bread'></li><li>"+$parent+"</li><li class='last'>"+text+"</li></ul>");
			$("#breadcrumbs").html(content);

		}
		else if(item.parent().hasClass("list"))
		{
		
			$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>"+$section+"</li><li class='bread'></li><li class='last'>"+item.find("a:first").text()+"</li></ul>");	
			$("#breadcrumbs").html(content);
					
		}
		else
		{
			$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>"+$section+"</li><li class='bread'></li><li class='last'>"+text+"</li></ul>");
			$("#breadcrumbs").html(content);	
		}
		//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
				
		return false;
	});

	// Slider operations
	$("#slider span").hover(
		function()
		{     
			$("#caption").css({'display':'block','float':'right','margin-right':'7px'});   
		},
		function()
		{
			$("#caption").css('display','none');   
		}
	);

	$("#slider span").toggle(
		function(){
			$("#caption").html("Show");
			//$("#menu").hide();
			$("#menuwrapper").animate(
				{marginLeft:'-250px', opacity:0},
				500
			);
			
				
		
		
				
		// $("#menu").animate({width:'toggle'},500);
	//	$("#main").css({width:'100%'});
      /*
      $("#menu").animate({marginLeft:'-210px'},500);
      	$("#main").animate({width:'100%'},500);
      	
      	*/
		},
		function(){
			$("#caption").html("Hide");
			//	$("#menu").show();
			//$("#menu").css("width",'200px');
			$("#menuwrapper").animate(
				{marginLeft:'0px', opacity:1},
				500
			);
			
			 return false;
		}
	);
		


    // -------------------------------------------
	// Account picker drop down
	
	var documentArrowToggle = function() {
		$("#arrow").click();
	};

	$("#arrow").toggle
	(
		function()
		{
			$(this).removeClass("regular");
			$(this).addClass("pressed");
			$("#accountwrapper").removeClass("shadow").addClass("shadowOpen").show();
			$("#accounts").removeClass("folded");
			$("#accounts").addClass("unfolded");
		//	$("#Campaign").hide();
			$(document).click(documentArrowToggle);
			
			/*
			$("#accounts").animateToSelector({
    			selectors: ['.unfolded'],
   				 properties: [
   				 'height','-moz-box-shadow','box-shadow'
   				 ],
   				duration:[100000],
   				 events: ['click']
			});
			*/
		},
		function()
		{
			
			$(this).removeClass("pressed");
			$(this).addClass("regular");
			$("#accountwrapper").removeClass("shadowOpen").addClass("shadow").hide();
			$("#accounts").removeClass("unfolded");
			$("#accounts").addClass("folded");
			//$("#Campaign").show();
			$(document).unbind('click', documentArrowToggle);
			
			/*
			$("#accounts").animateToSelector({
    			selectors: ['.folded'],
   				 properties: [
   				 'height','-moz-box-shadow','box-shadow'
   				 ],
   				 duration:[100000],
			    events: ['click']
			 */
		}
	);	
});

function applyMenuPermissions(index, accountObject)
{
	//console.log(accountObject);
	if (!accountObject)
	{
		// if null parameters were passed, apply for accounts
		$.each(_accountdata, applyMenuPermissions);
		return;
	}
	
	var hashSegments = getHashSegments();	
	if (accountObject.ID != hashSegments.accountID)
	{
		// recursive apply if there are child accounts
		if (accountObject.ChildAccounts)
			$.each(accountObject.ChildAccounts, applyMenuPermissions);
			
		return;
	}


	// we found the right one, so apply classes
	$('#sub li a').each(function(index, listItem)
	{
		if (accountObject.Permissions.indexOf($(this).attr("data-path")) >= 0)
		{					
			$(this).removeClass('disabled').parent().removeClass('disabled');				
		}
		else
		{
			$(this).addClass('disabled').parent().addClass('disabled');
		}		
	});
	
}

var _generalErrorHandler = function(data)
{
	var json;
	
	if (data.responseText)
	{
		try { json = jQuery.parseJSON(data.responseText);}
		catch(ex) {}
	}	
	
	if (json && json.redirect)
	{
		window.location.href = json.redirect;
	}
	else
	{
		$("#modal").html(
			json && json.message ?
			
				json.message :
				//'<h2>A PHP Error was encountered</h2><small><a href="#">Details</a></small><div id="content"><p> Severity: Notice Message: Undefined index: Intelligence/Dashboard/Test1/Filename: controllers/iframe.php Line Number: 11</p></div>'

				'<h2>Sorry, an unexpected error occured. Please check your network connection</h2><small><a href="#">Details</a></small><div id="content"><p>'+data.responseText+'</p></div>'
				//"<div>asdasasd</div><details></"
			
			).dialog({			
				title:'Edge.BI Error',
				modal: true,
				resizable: false,
				buttons: {
					Ok: function() {
						$( this ).dialog( "close" );
					}
				}
		});
	}
};




var rx = new RegExp("accounts/([0-9]+)(?:/(.*))*", "i");
function getHashSegments()
{
	if(window.location.hash.length < 2)
		return null;
		
	var h = window.location.hash.substring(1);
	var matches = rx.exec(h);
	
	if (!matches || matches.length != 3)
		return null;
	
	var json = ({
		"accountID": matches[1],
		"path": matches[2] ? matches[2] : '',
		"fullHash": h
	});
	
	return json ;
	
	
}



