<?php
global $REFURL;

$REFURL = base_url().uri_string();


  ?>
<style>


	#install{
   		 width:555px;
   		 margin:auto;
 		border-bottom: 1px solid #B1B1B1;
 		font-family:Verdana;
 		color:#616161;
 		font-size:12px;
 		line-height:1.5em;
}
 	#install   h1{
       	color:#616161;
        border-bottom: 1px solid #B1B1B1;
       padding-bottom: 7px;
        font-size:18px;

    }
	 #install   a#installbtn{
        background:url("assets/img/run-btn_03.jpg") no-repeat;
        display:block;
        width:161px;
        height:75px;
    }
     #install a#already,  #install a#already:active,#install a#already:visited{
     	display: block;
     	margin-left: 30px;
     	margin-top: 0px;
     	color:black;
     	margin-bottom:10px;
     	color: #83888E;
     }
	 #install li{
        list-style-image:url("assets/img/bullet_1_03.gif");
		line-height: 21px;
    }

</style>
<body>
<div id="install">
    <h1>Edge.BI setup</h1>

    <p>The Management and Find sections allow you to create and assign virtual groupings &amp; targets, import data, find and associate keywords or creatives.
		Edge.BI requires support from other software packages to perform this functionality.
</p>
Click <u>run</u> to setup the following packages:
    <ul>
        <li>Edge.BI certificate</li>
        <li>.NET framework 3.5</li>
    </ul>
    <a id="installbtn" href="wpf/setup.exe"></a>
    <a id="already" href="#">Edge.BI is already set up</a>
</div>

<script>
	
	$('a#already').click(function(){
		$.cookie("edgebi_wpf",'true',{expires: 14});
		window.location="<?php echo $REFURL;?>";
		return false;
	});

		
		


</script>
