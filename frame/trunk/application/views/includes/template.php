<!DOCTYPE html>

<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=9" >
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		<title>Edge.BI</title>
		<!--<link rel="stylesheet" href="<?php base_url(); ?>assets/css/style.css" type="text/css" media="screen" />-->
		<link rel="stylesheet" href="<?php base_url(); ?>assets/css/exstyle.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php base_url(); ?>assets/css/960.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php base_url(); ?>assets/css/jquery.jscrollpane.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php base_url(); ?>assets/css/jquery-ui-1.8.8.custom.css" media="screen"/>  	
		<!--[if IE]>
		<script src="<?php base_url();?>assets/js/html5shiv.js"></script>
		<![endif]-->
		<script src="<?php base_url();?>assets/js/jquery-1.4.4.js"></script>  
		<script src="<?php base_url();?>assets/js/json_encoder.js"></script>  
		<script src="<?php base_url();?>assets/js/selectivizr.js"></script>  
		<script src="<?php base_url();?>assets/js/jquery.tmpl.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.tmplPlus.js"></script>
		<script src="<?php base_url();?>assets/js/DD_roundies_0.0.2a.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.ba-hashchange.js"></script>
		<script src="<?php base_url();?>assets/js/animatetoselector.jquery.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.cookie.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.jqplugin.1.0.2.min.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.dropshadow.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.jscrollpane.min.js"></script>
		<script src="<?php base_url();?>assets/js/jquery.mousewheel.js"></script>
		<script src="<?php base_url();?>assets/js/jquery-ui-1.8.8.custom.min.js"></script>
		<script src="<?php base_url();?>assets/js/json2.js"></script>
		<script src="<?php base_url();?>assets/js/scripts.js"></script>
		<script type="text/javascript">
			var _menudata = jQuery.parseJSON('<?php echo $menu; ?>');
			var _accountdata = 	jQuery.parseJSON('<?php echo $account; ?>');
			var _userdata = jQuery.parseJSON('<?php echo $user; ?>');
		</script>		
	</head>
	<body>
		<div id="container" >
			<div id="modal">
			<div id="content"></div>
			</div>
			<script id="usertmpl"  type="text/x-jquery-tmpl">
				<span class="${UserID}">${Name}</span>
			</script>

			<!--   Add menu items -->
			<script id="tmpl"  type="text/x-jquery-tmpl">
				{{if Name != "TOPBAR"}}
				<h2 class="trigger ${IsOpen}" data-state="${IsOpen}" ><span> ${Name} </span></h2>
				<div class='toggle_container'>
					<div class='block'>
					{{if ChildItems}} 
					<ul class="list">
						<!-- 2nd level -->
						{{each ChildItems}}
							{{if MetaData}}
							<li class="menuheader"><a href="#" data-path="${Path}">${Name}</a>
							{{/if}}
								{{if ChildItems != ""}}
									<ul data-name ="${Name}" class="parent">
									<!-- 3rd level -->
									{{each ChildItems}} 
										<li class="menuitem"><a href="#" data-path="${Path}">${Name} </a>
										{{if ChildItems }}
											<ul data-name ="${Name}">  	
										{{each ChildItems}}
											<li class="menuitem"><a href="#" data-path="${Path}">${Name}</a> </li>
										{{/each}}
											</ul>
										</li>
										{{/if}}
									{{/each}}
									</ul>
								{{/if}}
							</li>
						{{/each}}
					</ul>
					{{/if}}
					</div>
				</div>
				{{/if}}
			</script>

			<!--   Top  menu external links -->
			<script id="topmenu" type ="text/x-jquery-tmpl">
				{{if Name == "TOPBAR"}}
					<ul>
					{{each ChildItems}}
						<li>| <a TARGET="_blank" href="${MetaData.External}">${Name}</a></li>
					{{/each}}
					</ul>
				{{/if}}
			</script>
			
			<!--   Top  menu internal links (logout & toolboard -->
			<header>
				<img src="<?php base_url();?>assets/img/logo_app.jpg" id="logo" />
				<div id="login">
					<div id="user">
					&nbsp; <span id="loginout"><a href="login/logout">(Log Out)</a> </span>
					</div>				
					<div id="top"></div>	
				</div>
				<div id="login">
					&nbsp; <span id="toolBox"><a href="#" id ="link" title="Tool Box"><img src="<?php base_url();?>assets/img/gear.jpg" id ="gear"  border =" 0"/></a> </span>				
					<div id="popup" hidden="true" style="display:none" > 
							<table class="toolsTable">
								<tr>
									<td id ="reportCell"><img src="<?php base_url();?>assets/img/tools/report_disabled.png" title="Service Report" id ="report"   border =" 0" class="toolIcons" onmouseover="changeImgs(this)" onmouseout="disableImgs()" />
										Service Report
									</td>
									<td id ="importCell"><img src="<?php base_url();?>assets/img/tools/import_disabled.png" title="Import Data" id ="import"  border =" 0" class="toolIcons" onmouseover="changeImgs(this)" onmouseout="disableImgs()"/>
										Import Data
									</td>
									<td id ="addRefundCell"><img src="<?php base_url();?>assets/img/tools/addRefund_disabled.png" title="Add Refund" id ="addRefund"  border =" 0" class="toolIcons" onmouseover="changeImgs(this)" onmouseout="disableImgs()"/>
										Add Refund
									</td>
								</tr>
								<tr>
									<td id ="deleteRefundCell"><img src="<?php base_url();?>assets/img/tools/deleteRefund_disabled.png" title="Delete Refund" id ="deleteRefund"  border =" 0" class="toolIcons" onmouseover="changeImgs(this)" onmouseout="disableImgs()"/>
										Delete Refund
									</td>
									<td id ="reportGeneratorCell"><img src="<?php base_url();?>assets/img/tools/reportGenerator_disabled.png" title="Generate Report" id ="reportGenerator"  border =" 0" class="toolIcons" onmouseover="changeImgs(this)" onmouseout="disableImgs()"/>
										Generate Report
									</td>
								</tr>
							</table>
						<br/>
						<div class =" back" >&lt; <a href="#"  id ="back">Back</a></div>
						<div id ="showTool"></div>
						
					</div>
					<div id="top" ></div>							
				</div>
				<div id="breadcrumbs"><div>		
			</header>
			
			<div id="ajaxloader">
				<img src="<?php base_url(); ?>assets/img/no-bg.gif" id="ajax" />
				<div>loading....</div>
			</div>
			<div class="clear"></div>

			<!--   Account  menu display -->
			<script id="accountbar"  type="text/x-jquery-tmpl">
			{{if Name }}
			<ul>
				<li id="${ID}" class="campaign" data-url="${SiteURL}" {{if Permissions}}data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
					<span><a href="accounts/${ID}">${ Name }</a></span>
					{{if ChildAccounts}}
						{{each ChildAccounts}}
							{{if ChildAccounts}}
								<li id="${ID}" class="parent" {{if Permissions}}data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
									<a href="accounts/${ID}">${ Name }</a>
									{{if ChildAccounts}}
										<ul>
										{{each ChildAccounts}}
											<li id="${ID}"{{if Permissions}}data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
												<a href="accounts/${ID}" >${Name}</a>
											</li>
										{{/each}}
										</ul>
									{{/if}}
								</li>
							{{else}}
								<li id="{ID}" {{if Permissions}} data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
									<a href="accounts/${ID}">${Name}</a>
								</li>
							{{/if}}
						{{/each}}
					{{/if}}
				</li>
			</ul>
			{{/if}}
			</script>

			<div id="slider">
			<span data-show="true"><img src="<?php base_url();?>assets/img/arrows_04.png" /></span>
			<div id="caption">Hide</div>
			</div>

			<div id="inner">	
			<div id="menu">
				<div id="menuwrapper">
					<div id="accounts" class="folded">	
						<div id="head">
							<div id="favicon"><img src='<?php base_url();?>assets/img/favicon4.ico'></img></div>	
							<div  id="selected"></div>
							<div id="arrow" class="regular">&nbsp;</div>
						</div>
						<div class="clear"></div>
						<div id="Campaign"></div>	
					</div>
					<div id="accountwrapper" class="shadow"></div>	
					<div id="sub"></div>
				</div>
			</div>
			<div id="main">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
			</div>

			<div class="clear"></div>
			<footer></footer>
		</div>	
		<script type='text/javascript'>
			if(_menudata)
			{
				$("#tmpl").tmpl(_menudata).appendTo("#sub");
				$("#topmenu").tmpl(_menudata).appendTo("#top");
			}
			else{

				$("#sub").html("the menu is unavailible for some reason");
			}
			if (_userdata)
			{
				$("#usertmpl").tmpl(_userdata).prependTo("header #login #user");
			}
			if(_accountdata)
			{
				$("#accountbar").tmpl(_accountdata).appendTo("#accountwrapper");
			}
			
			//onclick function for the tools icon
			$('#link').click(function() { 
				$('.back').hide();
				$('.toolsTable').show();
				$('#popup').dialog({			 
				resizable: true,
				title:"Tool Box",
				modal: true,
				height:'500',
				width:'700',
				buttons: { "Close": function() {
							$(this).dialog('destroy');
							$(".modal").remove();
							$('#showTool').html("");
							disableImgs();
							return false;
							}
						}
				}); 
				return false; 
			});
			
			//function for changing the images from color to greyscale when hovering over them
			function changeImgs(img){				
				$('#'+img.id).attr('src','<?php base_url();?>assets/img/tools/'+img.id+'.png');
				$('#'+img.id+'Cell').css('color' , 'black');
				$('img').each(function () {
					var curSrc = $(this).attr('src');
					if(curSrc.indexOf("tools") != -1&&this.id != img.id)
						$('#'+this.id).attr('src','<?php base_url();?>assets/img/tools/'+this.id+'_disabled.png');
					});
			}
			
			function disableImgs(){
				$('img').each(function () {
					var curSrc = $(this).attr('src');
					if(curSrc.indexOf("tools") != -1)
						$('#'+this.id).attr('src','<?php base_url();?>assets/img/tools/'+this.id+'_disabled.png');
						$('#'+this.id+'Cell').css('color' , '#666666');
				});
			}
			
			//function that handles the "back" link click
			$("#back").click(function() {
				$('#showTool').html("");
				$('#popup').dialog('option', 'title', 'Tool Box');
				$('.toolsTable').show();
				$('.back').hide();
			});
			
			//function that load page once clicking a tool image
			$("#report").click(function() {
				$('.toolsTable').hide();
				$.ajax({
					url: "serviceStats", 
					type: "POST",        
					cache: false,
					success: function (html) {  
					$('#showTool').html(html); 
					}       
				});
				$('.back').show();
				$('#popup').dialog('option', 'title', 'Services Outcome');		
			});
			
			$("#import").click(function() {
				$('.toolsTable').hide();
				$.ajax({
					url: "importer", 
					type: "POST",        
					cache: false,
					success: function (html) {  
					$('#showTool').html(html); 
					}       
				});
				$('.back').show();
				$('#popup').dialog('option', 'title', 'Import Data');
			});
			
			$("#addRefund").click(function() {
				$('.toolsTable').hide();
				$.ajax({
					url: " refund", 
					type: "POST",        
					cache: false,
					success: function (html) {  
					$('#showTool').html(html); 
					}       
				});
				$('.back').show();
				$('#popup').dialog('option', 'title', 'Add Refund');
			});
			$("#deleteRefund").click(function() {
				$('.toolsTable').hide();
				$.ajax({
					url: " refund/delete", 
					type: "POST",         
					cache: false,
					success: function (html) {  
					$('#showTool').html(html); 
					}       
				});
				$('.back').show();
				$('#popup').dialog('option', 'title', 'Delete Refund');
			});
			$("#reportGenerator").click(function() {
				$('.toolsTable').hide();
				$.ajax({
					url: " reportGenerator", 
					type: "POST",        
					cache: false,
					success: function (html) {  
					$('#showTool').html(html); 
					}       
				});
				$('.back').show();
				$('#popup').dialog('option', 'title', 'Generate Report');
			});
			

		</script>	
	</body>
</html>