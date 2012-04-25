<script type=" type="text/x-jquery-tmpl" id="reccomendationtmpl">



</script>

<div id="recommendations">
    <div id="wrapper">

        <ul>
       <li>
            <div class="description">
                <p>
            		<b> Poor performance </b>Detected on <span class="campaignName"> AdWords > 2tier - US – Search > Branding.</span>
                    <div class="clear"></div>
           		 	Incurred loss: <span class="lost">$100.</span>
                </p>
                 </div>
                 <div class="recommended">
                	<span class="action"> Recommended Action:</span>
                    <br/> Lower ADGROUP's Max CPC. <a href="#"> Details...</a>
                 </div>
                <div class="details">
                    deata
                </div>

            </li>
        </ul>

    </div>

</div>

<script type="text/javascript">

    $(".recommended a").click(function(){

        $(".details").slideToggle();

        return false;
    });

</script>


<style type="text/css">


#recommendations{
    color:#666;
    font-size:12px;
}
#recommendations a{
color:#90b63e;
}



#recommendations ul {

	list-style:none;
	list-style-position:inside;

}


#recommendations li{
background:url('./assets/img/red_arrow_03.jpg') no-repeat top left;
background-position:0px 5px;
padding:0px 0px 15px 40px;
border-bottom:#e6e6e6 solid 1px;

}


#recommendations .recommend {
/* border-top:#e6e6e6 solid 1px; */
background:url('img/arrows_03.jpg') no-repeat top left;
padding:5px 0px 0px 40px;
margin:0px;

}

#recommendations .description{
	margin:0px;
	padding:0px 0px 5px 0px;

}
.description p {
    margin:0;
    padding:0;
        line-height:40px;
}
    .details{
        display:none;
        margin-top:30px;

    }
    .campaignName{


        text-decoration:underline;

    }
    .clear{
        clear:both;
    }
    .action{
        display:block;
     font-weight:bold;
        background:url('./assets/img/arrows_03.jpg') no-repeat left bottom;
       padding:0px 0px 0px 37px;
        margin:0px 0px 0px -8px;
        line-height:38px;
        height:38px;

    }
</style>