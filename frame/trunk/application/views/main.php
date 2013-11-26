<!DOCTYPE html>

<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		<title>Edge.BI</title>
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
			
			<div id="errorDialog">
				<div id="errorMessage"></div>
				<div id="errorDetails">(details)</div>
				<p id="errorContent"></p>
			</div>
			
			<div id="infoDialog">
				<div id="infoMessage"></div>
				<div id="infoDetails">(details)</div>
				<p id="infoContent"></p>
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
			
			<!-- Top  menu internal links -->
			<header>
				<img src="<?php base_url();?>assets/img/logo_app.jpg" id="logo" />
				<div id="login">
					<div id="user">Logged in as <span id="username"></span> <span id="loginout"><a href="login/logout">(log out)</a></span></div>				
					<div id="top"></div>
				</div>
				<div id="breadcrumbs"><div>		
			</header>
			
			<div id="ajaxloader">
				<div id="ajaxloader-content">
					<img src="<?php base_url(); ?>assets/img/no-bg.gif" id="ajax" />
					<div>loading....</div>
				</div>
			</div>
			<div class="clear"></div>

			<!--   Account  menu display -->
			<script id="accountbar"  type="text/x-jquery-tmpl">
				{{if Name }}
				<ul>
					<li id="${ID}" class="account-root" data-url="${SiteURL}" data-name="${Name}" {{if Permissions}}data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
						<span><a href="accounts/${ID}">${ Name }</a></span>
						{{if ChildAccounts}}
							{{each ChildAccounts}}
								{{if ChildAccounts}}
									<li id="${ID}" data-name="${Name}" class="account-sub1" {{if Permissions}}data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
										<a href="accounts/${ID}">${ Name }</a>
										{{if ChildAccounts}}
											<ul>
											{{each ChildAccounts}}
												<li id="${ID}" data-name="${Name}" {{if Permissions}}data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
													<a href="accounts/${ID}" >${Name}</a>
												</li>
											{{/each}}
											</ul>
										{{/if}}
									</li>
								{{else}}
									<li id="{ID}" data-name="${Name}" {{if Permissions}} data-Permissions=${Permissions} {{else}} data-Permissions="none" {{/if}}>
										<a href="accounts/${ID}">${Name}</a>
									</li>
								{{/if}}
							{{/each}}
						{{/if}}
					</li>
				</ul>
				{{/if}}
			</script>

			<div id="slider" data-show="true">
				<span id="slider-open"><img src="<?php base_url();?>assets/img/arrows_04.png" /></span>
				<span id="slider-closed" style="display: none"><img src="<?php base_url();?>assets/img/arrows_03.png" /></span>
				<div id="caption">Hide</div>
			</div>

			<div id="inner">	
				<div id="menu">
					<div id="menuwrapper">
						<div id="accounts" class="folded">	
							<div id="head">
								<div id="favicon"><img src='<?php base_url();?>assets/img/favicon4.ico'></img></div>	
								<div id="selected"></div>
								<div id="arrow" class="regular">&nbsp;</div>
							</div>
							<div class="clear"></div>
							<div id="account-url"></div>	
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
				$("#sub").html("The menu is unavailible for some reason. Please contact an administrator.");
			}
			if (_userdata)
			{
				$("#usertmpl").tmpl(_userdata).appendTo("header #login #user #username");
			}
			if(_accountdata)
			{
				$("#accountbar").tmpl(_accountdata).appendTo("#accountwrapper");
			}

		</script>	
	</body>
</html>