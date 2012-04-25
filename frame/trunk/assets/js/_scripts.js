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




$(function(){
	$('#accountwrapper').jScrollPane(
			{
				showArrows: true,
				horizontalGutter: 10
			}	
	);
	
/*
	var javaCheck = checkJavaSupport();
	if(!javaCheck.javaEnabled){
		window.location  = 'http://javadl.sun.com/webapps/download/AutoDL?BundleId=44472';
	}
	
	*/
	var viewportHeight =$(document).height();
	var headerHeight = $('header').outerHeight();
	$('#main').css('height',viewportHeight -headerHeight);


	
	
	var selected = $("#selected");
	 //DD_roundies.addRule('#accounts', '5px');
	 
	// var length = $("#Campaign").html().length;
	
	$("#breadcrumbs ul li:last-child").addClass("last-child");
	
	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$('h2.trigger').addClass("active");
	$("h2.trigger").live("click",function(){
		$(this).toggleClass("active").next().slideToggle("slow");
	});
	
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
	$(window).resize(function() {
		$('iframe').height(viewportHeight -headerHeight);
	
	});

	$(window).hashchange(function()
	{	
		$('iframe').height(viewportHeight -headerHeight);
	
	
		
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
     	$.each(_accountdata, function(index, accountObject) {
     	
			if (accountObject.ID != hashSegments.accountID)
				return;

			$('#sub li.menuheader a').each(function()
			{
				
				//if(jQuery.inArray($(this).attr("data-path")) >= 0, accountObject.Permissions)
				if (accountObject.Permissions.indexOf($(this).attr("data-path")) >= 0)
				{
					$(this).removeClass('disabled');
				}
				else
				{
					$(this).addClass('disabled');
				}
				
			});
			
		});
     	
     	
     	//================================================
     	var url = $("#selected").text();
    	var $parents = "";
    	var $sub  = "";
    	var $accountId="";  
    	
    	if (!accountListItem || !accountListItem.length)
    	{
    		$sub = "(Invalid Account)";
    		$('#arrow').show();
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
			$sub  = "Top Level Account";
			$accountId = accountListItem.attr("id");
    	}
    	else
    	{
			$parents = accountListItem.parent().parent().siblings(".campaign").find("span").text();
			$sub = accountListItem.text()
			$accountId = accountListItem.parent().parent().siblings(".campaign").attr("id");
    	}
    	
    	// Set cookies
    	$.cookie("edgebi_child_account",accountListItem.attr("id"),{expires: 7});
    	$.cookie("edgebi_parent_account",$accountId,{expires: 7});
    	
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
				if(item.parent("ul").hasClass("parent"))
				{
					$parent = item.parent("ul.parent").attr("data-name");
					$section = item.parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
				 	content =	$("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$parent+"</li><li class='bread'></li><li>"+item.find("a:first").text()+"</li></ul>");	
					$("#breadcrumbs").html(content);
					document.title = 'Edge.bi -'+$section+'-'+$parent+'-'+item.find("a:first").text();
					
				}	
				else if(item.parent().parent().parent("ul").hasClass("parent"))
				{
					$parent = item.parent("ul").attr("data-name");
					$grand = item.parent().parent().parent("ul.parent").attr("data-name");
					$section = item.parent().parent().parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
					 content =	$("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$grand+"</li><li class='bread'></li><li>"+$parent+"</li><li class='bread'></li><li>"+text+"</li></ul>");
					$("#breadcrumbs").html(content);
					document.title = 'Edge.bi -'+$section+'-'+$grand+'-'+$parent+'-'+text;
				}
				else if(item.parent().hasClass("list"))
				{
					$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>"+$section+"</li><li class='bread'></li><li>"+item.find("a:first").text()+"</li></ul>");
					$("#breadcrumbs").html(content);
					document.title = 'Edge.bi -'+$section+'-'+item.find("a:first").text();
				}
				else
				{
					$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>"+$section+"</li><span></span><li>"+text+"</li></ul>");
					$("#breadcrumbs").html(content);
					document.title = 'Edge.bi -'+$section+'-'+text;
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
			
    $("#accounts").delegate("li","click",function(){

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
		var item = $(this).parent(".current");
		var text = item.text();
		var content =""	;
		var $parent = "";
		var $grand = "";

		if(item.parent("ul").hasClass("parent"))
		{
			$parent = item.parent("ul.parent").attr("data-name");
			$section = item.parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
			
			content = $("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$parent+"</li><li class='bread'></li><li>"+item.find("a:first").text()+"</li></ul>");
			$("#breadcrumbs").html(content);
		}	
		else if(item.parent().parent().parent("ul").hasClass("parent"))
		{
			$parent = item.parent("ul").attr("data-name");
			$grand = item.parent().parent().parent("ul.parent").attr("data-name");
			$section = item.parent().parent().parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
		 	content =	$("<ul><li>"+$section+"</li><li class='bread'></li><li>"+$grand+"</li><<li class='bread'></li><li>"+$parent+"</li><span></span><li>"+text+"</li></ul>");
			$("#breadcrumbs").html(content);
		}
		else if(item.parent().hasClass("list"))
		{
		
			$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>"+$section+"</li><li class='bread'></li><li>"+item.find("a:first").text()+"</li></ul>");	
			$("#breadcrumbs").html(content);
					
		}
		else
		{
			$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>"+$section+"</li><li class='bread'></li><li>"+text+"</li></ul>");
			$("#breadcrumbs").html(content);	
		}
				
		return false;
	});

	// Slider operations
	$("#slider span").hover(
		function()
		{     
			$("#caption").html("Hide").show();   
		},
		function()
		{
			$("#caption").hide();
		}
	);
	
	$("#slider span").toggle(function(){
		$("#caption").html("Show");
		$("#menu").hide();
		// $("#menu").animate({width:'toggle'},500);
	//	$("#main").css({width:'100%'});
      /*
      $("#menu").animate({marginLeft:'-210px'},500);
      	$("#main").animate({width:'100%'},500);
      	
      	*/
		},function(){
			
			$("#menu").show();
			
			//$("#main").css({width:'83%'});
			/*
			 $("#main").animate({width:'81%'},500);
			 	
			 	$("#menu").animate({marginLeft:'19px'},500);
			 	
			 	*/
			 	return false;
		});
		


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
			$("#accounts").removeClass("folded");
			$("#accounts").addClass("unfolded");
			$("#Campaign").hide();
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
			$("#accounts").removeClass("unfolded");
			$("#accounts").addClass("folded");
			$("#Campaign").show();
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

var _generalErrorHandler = function(data)
{
	var json;
	
	if (data.responseText)
	{
		try { json = jQuery.parseJSON(data.responseText);}
		catch(ex) {}
	}	
	
	if (json)
	{
		if (json.redirect)
			window.location.href = data.redirect;
		else
			alert(json.message ? json.message : "Sorry, an unexpected error occured.");
	}
	else
	{
		$('#main').html(data.responseText ? data.responseText : "Sorry, an unexpected error occured.");
		
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



