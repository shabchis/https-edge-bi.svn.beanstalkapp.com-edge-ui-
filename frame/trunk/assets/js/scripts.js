$(function ()
{
	$("#errorDialog #errorDetails").click(function ()
	{
		$("#errorDialog #errorContent").slideToggle("slow");
	});
	
	window.adjustFrameHeight();
	$(window).bind('resize',window.adjustFrameHeight);
	
	//Switch the "Open" and "Close" state per click then slide up/down (depending on open/close state)
	$('h2.trigger').removeClass("active").next().hide();
	$('h2.true').addClass("active").next().slideToggle("fast");
	$("h2.trigger").click(function ()
	{
		$(this).toggleClass("active").next().slideToggle("fast");
	});
	
	// Ajax 'loading'
	$("#main").ajaxStart(window.ajaxLoaderShow);
	$("#main").ajaxComplete(window.ajaxLoaderHide);
	$("#main").ajaxError(window.ajaxLoaderHide);
	
	// -------------------------------------------
	// Hash changes
	
	$(window).hashchange(function ()
	{
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
		
		var applyMenuPermissions = function(index, accountObject)
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
			$('#sub li a').each(function (index, listItem)
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
		applyMenuPermissions(null, null);
		
		//================================================
		var $parents = "";
		var $sub = "";
		var $accountId = "";
		var $link = '<a target="_blank" href="http://' + accountListItem.attr("data-url") + '">' + accountListItem.attr("data-url") + '</a>';
		if (!accountListItem || !accountListItem.length)
		{
			window.location.hash = "#accounts/" + _accountdata[0].ID;
		}
		else if (accountListItem.hasClass("account-sub1"))
		{
			$parents = accountListItem.siblings(".account-root").find("span").text();
			$sub = accountListItem.find('a:first').text();
			$accountId = accountListItem.siblings(".account-root").attr("id");
		}
		else if (accountListItem.hasClass("account-root"))
		{
			$parents = accountListItem.find("span").text();
			$sub = $link;
			$accountId = accountListItem.attr("id");
		}
		else
		{
			$parents = accountListItem.parent().parent().siblings(".account-root").find("span").text();
			$sub = accountListItem.text();
			$accountId = accountListItem.parent().parent().siblings(".account-root").attr("id");
		}
		
		
		// Set cookies
		$.cookie("edgebi_child_account", accountListItem.attr("id"),
		{
			expires: 14
		});
		$.cookie("edgebi_parent_account", $accountId,
		{
			expires: 14
		});
		
		$("#selected").html($parents);
		$("#selected").attr("class", $accountId);
		$("#account-url").html($sub);
		
		// Change menu item hrefs
		$('#sub li.menuheader a').each(function ()
		{
			$(this).attr("href", "accounts/" + hashSegments.accountID + "/" + $(this).attr("data-path"));
		});
		
		//================================================
		$.ajax(
		{
			url: hashSegments.fullHash,
			success: function (data)
			{
				$('#main').html(data);
			},
			error: window.handleError,
			complete: function (data)
			{
				$("#sub li").removeClass("current");
				$("#sub li a[data-path=" + hashSegments.path + "]").parent().addClass("current");
				$("#sub li a.menuitem").removeClass("current");
				var item = $("#sub a").parent(".current");
				var text = item.text();
				var content = "";
				var $parent = "";
				var $section = "";
				var $grand = "";
				document.title = "Edge.BI - " + $("#"+getHashSegments().accountID).data("name");
				
				if (item.parent("ul").hasClass("parent"))
				{
					$parent = item.parent("ul.parent").attr("data-name");
					$section = item.parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>" + $section + "</li><li class='bread'></li><li>" + $parent + "</li><li class='bread'></li><li class='last'>" + item.find("a:first").text() + "</li></ul>");
					$("#breadcrumbs").html(content);
					if ($section.length > 0)
						document.title += ' / ' + $section + ' / ' + $parent + ' / ' + item.find("a:first").text();
				}
				else if (item.parent().parent().parent("ul").hasClass("parent"))
				{
					$parent = item.parent("ul").attr("data-name");
					$grand = item.parent().parent().parent("ul.parent").attr("data-name");
					$section = item.parent().parent().parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>" + $section + "</li><li class='bread'></li><li>" + $grand + "</li><li class='bread'></li><li>" + $parent + "</li><li class='bread'></li><li class='last'>" + text + "</li></ul>");
					$("#breadcrumbs").html(content);
					if ($section.length > 0)
						document.title += ' / ' + $section + ' / ' + $grand + ' / ' + $parent + ' / ' + text;
				}
				else if (item.parent().hasClass("list"))
				{
					$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>" + $section + "</li><li class='bread'></li><li class='last'>" + item.find("a:first").text() + "</li></ul>");
					$("#breadcrumbs").html(content);
					if ($section.length > 0)
						document.title += ' / ' + $section + ' / ' + item.find("a:first").text();
				}
				else
				{
					$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
					content = $("<ul><li>" + $section + "</li><span></span><li class='last'>" + text + "</li></ul>");
					$("#breadcrumbs").html(content);
					if ($section.length > 0)
						document.title += ' / ' + $section + ' / ' + text;
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
			window.location.hash = "#accounts/" + cookieAccount;
		else
			$(window).hashchange();
	}
	// -------------------------------------------
	// Account operations
	$("#accountwrapper").delegate("li", "click", function ()
	{
		var hashSegments = getHashSegments();
		var link = $(this).find("a").attr("href");
		var appendPath = hashSegments != null ? "/" + hashSegments.path : '';
		// hide the menu
		$("#arrow").click();
		window.location.hash = "#" + link + appendPath;
		return false;
	});
	// -------------------------------------------
	// Menu operations    
	$("#sub").delegate("a", "click", function ()
	{
		if ($(this).hasClass('disabled'))
		{
			return false;
		}
		$(this).parent("li").removeClass("current");
		$(this).parent("li").addClass("current");
		var hashSegments = getHashSegments();
		if (!hashSegments || !hashSegments.accountID)
		{
			alert("please choose an account");
			return false;
		}
		window.location.hash = $(this).attr("href");
		//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
		// TODO: KIIIIIIIIIIIIIIIILLLL this section
		var item = $(this).parent(".current");
		var text = item.text();
		var content = "";
		var $parent = "";
		var $section = "";
		var $grand = "";
		if (item.parent("ul").hasClass("parent"))
		{
			$parent = item.parent("ul.parent").attr("data-name");
			$section = item.parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>" + $section + "</li><li class='bread'></li><li>" + $parent + "</li><li class='bread'></li><li class='last'>" + item.find("a:first").text() + "</li></ul>");
			$("#breadcrumbs").html(content);
		}
		else if (item.parent().parent().parent("ul").hasClass("parent"))
		{
			$parent = item.parent("ul").attr("data-name");
			$grand = item.parent().parent().parent("ul.parent").attr("data-name");
			$section = item.parent().parent().parent().parent().parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>" + $section + "</li><li class='bread'></li><li class='last'>" + $grand + "</li><li class='bread'></li><li>" + $parent + "</li><li class='last'>" + text + "</li></ul>");
			$("#breadcrumbs").html(content);
		}
		else if (item.parent().hasClass("list"))
		{
			$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>" + $section + "</li><li class='bread'></li><li class='last'>" + item.find("a:first").text() + "</li></ul>");
			$("#breadcrumbs").html(content);
		}
		else
		{
			$section = item.parent().parent().parent().prev("h2.trigger").find("span").text();
			content = $("<ul><li>" + $section + "</li><li class='bread'></li><li class='last'>" + text + "</li></ul>");
			$("#breadcrumbs").html(content);
		}
		//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
		return false;
	});
	
	// Slider operations
	$("#slider").hover(
		function (){
			$("#caption").css({
				'display': 'block',
				'float': 'right',
				'margin-right': '7px'
			});
		},
		function (){
			$("#caption").css('display', 'none');
		}
	);
		
	$("#slider").toggle(
		function (){
			$("#caption").html("Show");
			$("#slider-open").hide();
			$("#slider-closed").show();
			$("#menuwrapper").animate({
				marginLeft: '-250px',
				opacity: 0
				}, 500);
		},
		function () {
			$("#caption").html("Hide");
			$("#slider-open").show();
			$("#slider-closed").hide();
			$("#menuwrapper").animate({
				marginLeft: '0px',
				opacity: 1
				}, 500);
			return false;
		}
	);
	// -------------------------------------------
	// Account picker drop down
	var documentArrowToggle = function ()
	{
		$("#arrow").click();
	};
	$("#arrow").toggle(function ()
	{
		$(this).removeClass("regular");
		$(this).addClass("pressed");
		$("#accountwrapper").removeClass("shadow").addClass("shadowOpen").show();
		$("#accounts").removeClass("folded");
		$("#accounts").addClass("unfolded");
		$(document).click(documentArrowToggle);
		
	}, function ()
	{
		$(this).removeClass("pressed");
		$(this).addClass("regular");
		$("#accountwrapper").removeClass("shadowOpen").addClass("shadow").hide();
		$("#accounts").removeClass("unfolded");
		$("#accounts").addClass("folded");
		$(document).unbind('click', documentArrowToggle);
	});
});

window.handleSessionExpired = function() {

	var $errorDialog = $("#errorDialog");
	$errorDialog.find('#errorMessage').html("Sorry, but you've been away for a while.<br/><br/>Press 'OK' to login again (unsaved changes will be lost).");
	$errorDialog.find('#errorDetails').hide();
	$errorDialog.find('#errorContent').html("");

	$errorDialog
		.dialog({
			title: 'Session expired',
			modal: true,
			resizable: false,
			buttons: {
				OK: function () {
					window.location.reload(true);
				},
				Cancel: function() {
					$(this).dialog("close");
				}
			}
		});
};

window.ajaxLoaderShow = function()
{
	$("#ajaxloader").dialog({
		resizable: false,
		modal: true,
		height: 100,
		width: 120,
		dialogClass: "ajaxloader-dialog"
	});
};
window.ajaxLoaderHide = function()
{
	$("#ajaxloader").dialog("close");
};

window.handleInfo = function(data) {
	var json;
	var responseText;
	if (data.responseText)
	{
		responseText = data.responseText;
		try { json = jQuery.parseJSON(data.responseText); }
		catch (ex)
		{}
	}
	else {
		json = data;
	}
	
	var details = json && json.details ? json.details : (responseText ? responseText: null);
	
	var $errorDialog = $("#infoDialog");
		
	$errorDialog.find('#infoMessage')
		.html(json && json.message ? json.message : 'No message to display, but everything is okay');

	if (details)
		$errorDialog.find('#infoDetails').show();
	else
		$errorDialog.find('#infoDetails').hide();

	$errorDialog.find('#infoContent')
		.html(details);

	$errorDialog
		.dialog({
			title: 'Info',
			modal: true,
			resizable: false,
			buttons: {
				OK: function () {
					$(this).dialog("close");
				}
			}
		});
}
	
window.handleError = function (data)
{
	var json;
	var responseText;
	if (data.responseText)
	{
		responseText = data.responseText;
		try { json = jQuery.parseJSON(data.responseText); }
		catch (ex)
		{}
	}
	else {
		json = data;
	}
	
	var details = json && json.details ? json.details : (responseText ? responseText: null);
	
	if (json && json.redirect)
	{
		window.location.href = json.redirect;
	}
	else
	{
		var $errorDialog = $("#errorDialog");
		
		$errorDialog.find('#errorMessage')
			.html(json && json.message ? json.message : 'Sorry, an unexpected error occured.');
		
		if (details)
			$errorDialog.find('#errorDetails').show();
		else
			$errorDialog.find('#errorDetails').hide();
		
		$errorDialog.find('#errorContent')
			.html(details);
			
		$errorDialog
			.dialog({
				title: 'Error',
				modal: true,
				resizable: false,
				buttons: {
					OK: function () {
						$(this).dialog("close");
					}
				}
			});
	}
};

window.adjustFrameHeight = function()
{
	var viewportHeight = $(window).height();
	var headerHeight = $('header').outerHeight();
	$("#main").height(viewportHeight - headerHeight - 70);
	$("#frame").height($("#main").height());
	if ($.browser.msie)
	{
		$("#main").height(viewportHeight - headerHeight - 100);
		$("#frame").height($("#main").height());
	}
}
	

window.getHashSegments = function()
{
	if (window.location.hash.length < 2)
		return null;
	var h = window.location.hash.substring(1);
	var matches = /accounts\/([0-9]+)(?:\/(.*))*/i.exec(h);
	if (!matches || matches.length != 3)
		return null;
	var json = (
	{
		"accountID": matches[1],
		"path": matches[2] ? matches[2] : '',
		"fullHash": h
	});
	return json;
}

// Adds the indexOf function for internet explorer 
if (!Array.prototype.indexOf)
{
	Array.prototype.indexOf = function (elt /*, from*/ )
	{
		var len = this.length >>> 0;
		var from = Number(arguments[1]) || 0;
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);
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
