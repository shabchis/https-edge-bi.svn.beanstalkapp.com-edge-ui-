<script id="groupstmpl"  type="text/x-jquery-tmpl">
			{{if Name}}
		<h2 class="grouptrigger" title="Group ID: ${GroupID}" data-group="${GroupID}"><span> ${Name}</span><img class="x" src="assets/img/x_03.png"/></h2>
        
           {{/if}}

</script>
<script id="groupNameTmpl"  type="text/x-jquery-tmpl">
		
		{{if Name}}
		
	<p class="name">
		
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="${Name}" />
	</p>
	
	
	<p class="enabled">
		<label>Enabled</label>
		<input type="checkbox" value="check" />
	</p>
        
       {{/if}}      


</script>
<script id="userstmpl"  type="text/x-jquery-tmpl">
		<option value="${UserID}">${Name}</option>


</script>

<script id="usersgrouptmpl"  type="text/x-jquery-tmpl">
             	<li id='${UserID}'>${Name}<span class="delete">&nbsp;</span></li>
</script>
<script id="accounttmpltest"  type="text/x-jquery-tmpl">
           {{if Name }}
         			 <option  id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
             	{{if ChildAccounts !=""}}
                	 {{each ChildAccounts}}
                  	  <option class="firstchild" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                        {{if ChildAccounts !=""}}
                            {{each ChildAccounts}}
                           <option class="secondchild" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                {{if ChildAccounts !=""}}
                                 {{each ChildAccounts}}
                                <option class="thirdchild" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                     {{if ChildAccounts !=""}}
                                 {{each ChildAccounts}}
                                <option class="forthchild" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                 {{/each}}
                                  {{/if}}
                                {{/each}}
                                  {{/if}}
                                {{/each}}
                          {{/if}}
						{{/each}}
                {{/if}}
         {{/if}}
</script>
<div id="tabs">
     	<ul>
            <li><a href="#tabs-1">General</a></li>
            <li><a href="#tabs-2">Members</a></li>
            <li><a href="#tabs-3">Permissions</a></li>
     	</ul>
	<div id="tabs-1">
       <form class="form">

        <p class="name">
		
		<label for="name">Name</label>
		<input type="text" name="name" id="name" />
	    </p>
		<p class="enabled">
		<label>Enabled</label>
		<input type="checkbox" value="check" id="checkbox" />
	    </p>

</form>

</div>
	<div id="tabs-2">
	      	<div id="addselected">
				<select>
				</select>
				<a id="add" href="#">Add</a>
		</div>
		<div class="clear"></div>
		<div id="userslist">
		<ul id="listings">
			
			
		</ul>
			
		</div>
		</div>
	<div id="tabs-3">
		<div id="accountwrap">


		<div id="accountscombo">
            <select>
               </select>

		</div>
		</div>
		<div class="clear"></div>
		<div id="permissions">

		</div>
	</div>

</div>



<div id="groupwrapper">
<div class="header">

		</div>
	<div id="groupcontent">
		
     
</div>
</div>


<script>
var userId ;
var globalGroups = "";
var groupID = "";
var globalID = "";
 var changed = false;
  var saved= false;
$(function(){
	$("#tabs").dialog("close");
var users = jQuery.parseJSON('<?php echo $users; ?>');
	var groups = jQuery.parseJSON('<?php echo $groups; ?>');
     $("#userlistings").empty();
  
	$("#groupstmpl").tmpl(groups).appendTo("#groupcontent");




$("#permissions ul li.rep").live("click",function(){

    if($(this).hasClass('question')){
    $(this).removeClass('question').addClass("v").css({'background':'url("./assets/img/_v.png") left no-repeat '})    ;
    }
    else if($(this).hasClass('v')){
      $(this).removeClass('v').addClass("-").css({'background':'url("./assets/img/-.png") left no-repeat'})    ;
    }
    else if($(this).hasClass('-')) {

      $(this).removeClass('-').addClass("question").css({'background':'url("./assets/img/_question.png") left no-repeat '})    ;
    }


      changed = true;
       saved = false;



 });

    $("#permissions ul li.arrow").live("click",function(){

       $(this).siblings('li').children().slideToggle("fast");


    });
    $("h2.grouptrigger img").live("click",function(){
  		var group = $(this).parent().attr("data-group");
  		
  		
  		  $("#modal").html('<p class="changemodal"> You are going to delete this group, are you sure?.</p>').dialog({
             title:"Delete Group ",
             modal:true,
             buttons:{
						"Cancel":function(){
						   $(this).dialog("close");
						},
                       "Ok":function(){

					$.ajax({
					            url: "groups/deleteGroup/"+group,
					            success: function(data){
					             $("#modal").dialog("close");
					          $("h2.grouptrigger[data-group='"+group+"']").remove();
					       
             }

         });
						
                                
			
                   }
             }

         });
    
  		
  		


               

			  



		});


$("h2.grouptrigger span").live("click",function(){
		var name =  $(this).text();
		var datagroup =  $(this).parent().attr('data-group');
		groupID =datagroup;
        
         $('#listings').empty();
          $("p.email").remove();
		//$("#groupNameTmpl").tmpl(groups).appendTo('#tabs-1 form.form');
		$('input#name').val(name);
		 permissionsMark();
		$.ajax({
			  url: "groups/getusers/"+datagroup,
			  success: function(data,index)
			  {
				var groupusers =jQuery.parseJSON(data);
   				if(groupusers == null){

                        $("#modal").html('<p class="changemodal">This group is disabled.</p>').dialog({
             title:"group not exists",
             modal:true,
             buttons:{

                       "Ok":function(){



                          $(this).dialog("close");
                       
                   }
             }

         });

                  }


				else 
				{
			$("#userstmpl").tmpl(users).appendTo("#addselected select");
			
			$("#usersgrouptmpl").tmpl(groupusers).appendTo("#listings");
			
			var permittedUser = groupusers;


			          userId =  groupusers["UserID"];
				$.each(permittedUser,function(k,v){
					
				
					
					$('#addselected select option[value='+v.UserID+']').remove();
			
				
				});
					
			 
			
				  }
				  }
			
		});

	
		$("#tabs").dialog({
		title:name,
         modal:true,
		resizable: true,
        autoOpen:false,
        resize:function(){
             $("#permissions").css("height",$(this).dialog().height()-50-38);
            $("#userlist").css("height",$(this).dialog().height()-50-38);

        } ,
		width:800,
		height:600,
		buttons: {
                "Cancel": function() {
					$(this).dialog( "close" );
                },
                  "Save and exit":function(){
                      SendGroups(globalGroups);
                       $(this).dialog( "close" );
                  },
				"Save": function() {
                    SendGroups(globalGroups);

				}


			}


		
		});
        
        $("#tabs").dialog("open").tabs();
         $(".ui-dialog-title").attr("title","ID:"+" " +groupID);
		
	
	});
	

	$("a#add").button();
	
//var accounts = recusiveAccounts(_accountdata);
//	$("#accountscombo").append(accounts);
//	$("#accounttmpl").tmpl(_accountdata).appendTo('#accountscombo');
	$("#accounttmpltest").tmpl(_accountdata).appendTo('#accountscombo select');




$.ajax({
  url: "groups/gettree",
  success: function(data){
  		
  	var permission = jQuery.parseJSON(data);

  	//  	$("#permissiontmpl").tmpl(permission).prependTo("#demo4");
  	

  	var html =  recursiveFunction(permission);

  $('#permissions').append(html);


permissionsMark();
	  $('#permissions a').click(function(){
	  return false;
	  });

  function recursiveFunction(permission) {
        var result = "";
        
     var str = "";


        
            $.each(permission, function(key,val) {

        		if(val.ChildPermissions != "")
      			  {

        			var func= recursiveFunction(val.ChildPermissions);

        			str =str+ '<ul><li class="arrow"></li><li class="rep question"></li><li class="data" id="root" data-name="'+val.PermissionName+'" data-path='+val.Path+'>'+val.PermissionName+func+'</li></ul>';
               
              	  }
                
                else
                {
             		   str = str+'<ul><li class="arrowchild"><li class="rep question"></li><li id="son"  class="data" data-name="'+val.PermissionName+'" data-path='+val.Path+'>'+val.PermissionName+'</li></ul>';
                }
                
                 
          });
     return str;
         
  

    }
  		
 } 		
  		
  	
});



$("a#add").click(function(){

	
	var selected =$('#addselected select option:selected');
	var selectedID =$('#addselected select option:selected').val();
	
	

    	$('#listings').append('<li id='+selectedID+'>'+selected.text()+'<span class="delete">&nbsp;</span></li>');
	
	selected.remove();

	return false;
});

$('#listings li span.delete').live('click',function(){


	 $('#addselected select').append('<option value='+$(this).parent().attr('id')+'>'+$(this).parent().not("span.delete").text()+'</option>');
$(this).parent().fadeOut(2000).remove();




});

$('#permissions').delegate('li.top','click',function(){
	
	$(this).toggleClass('close');

});


	$('#permissions').delegate('li.child','click',function(){
	
	$(this).toggleClass('close');
	//$(this).children().slideToggle("slow");
});
 $('#accountscombo').click(function(){

    if(changed  && !saved)
     {

         $("#modal").html('<p class="changemodal">You must save changes before you can edit permissions.</p>').dialog({
             title:"Save",
             modal:true,
             buttons:{
                       "Cancel":function(){
                         $(this).dialog("close");
                         saved = true;
                         changed = false;
                       },
                       "Ok":function(){

                          $(this).dialog("close");

                   }
             }

         });
         }
 });

//$('#accountscombo a').click(function(){
$('#accountscombo select').change(function(){
    permissionsMark();


});

});

function permissionsMark(){

    var $id =$('#accountscombo select option:selected').attr("id");
     globalID = $id;
    var position="";
    var parent  = $(this).parent().parent().prev();
    var grand = parent.parent().parent().parent();

    var gid = "";

$.ajax({
  url: "groups/getgroups/"+groupID,
  success: function(data){
     if( $("#permissions li.data").attr("data-name")){

  $("#permissions li.data").siblings("li.rep").css({'background':'url("./assets/img/_question.png") left no-repeat'})  ;

 }

      var group = jQuery.parseJSON(data);

      globalGroups =   group;

    
              
        if(group["IsActive"] == true){
            $("p.enabled #checkbox").attr("checked",group["IsActive"]); 
        }
 


       var users = {  };
        var groupUsers =  group["Members"];

      var assignedpermission  =   group["AssignedPermissions"][$id];

        if(assignedpermission || assignedpermission != undefined)
        {




    


       var b = "";

          $.each(assignedpermission,function(key,persmission){


                  $("#permissions li.data").each(function(){

                    if($(this).attr('data-name').toLowerCase() == persmission.PermissionName.toLowerCase()) {

               if(!persmission.Value )  {


                                 // $(this).css('color','blue');
                  $(this).siblings("li.rep").css({'background':'url("./assets/img/-.png") left no-repeat'}).removeClass("question").addClass('-');                            }
                               else
                    {

                              //  $(this).css('color','red');
                   $(this).siblings("li.rep").css({'background':'url("./assets/img/_v.png") left no-repeat'}).removeClass("question").addClass('v');

                    }

                    }
                    




             });

          });

        }
  },
    complete:function(data){
         saved = false;

    },
    error:function(){


    }

});




}

 function SendGroups(globalGroups){
       var value = null ;

     var jsonarray = [];
     var members =  [];
     var listing =[];

   //  if( globalGroups["AssignedPermissions"][globalID] == undefined)
    //    $('.ui-dialog-buttonpane button').eq(0).button().hide();


         globalGroups["Name"] =   $.trim($("#name").val());


         if( $("h2.grouptrigger[data-group='"+groupID+"']").find("img").hasClass("deleted")){
                   globalGroups["IsActive"] = false;
         }
     else
         {
       globalGroups["IsActive"]= $("p.enabled #checkbox").attr("checked");

         }
     $("#listings li").each(function(){
         if($(this).attr("id")){
          var userID = $(this).attr('id');
             var member = {UserID:$(this).attr('id'),Name:$(this).text()};
          members.push(member)  ;

         }



     });

           globalGroups["Members"] = members;

        $("#permissions li.data").each(function(){
          if($(this).attr("data-name")) {

              if($(this).prev("li").hasClass("v")){

                  value = true;
              }
              else if($(this).prev("li").hasClass("-"))
              {

                  value = false;
              }
              else if($(this).prev("li").hasClass("question"))
              {

                  value = null;
              }


              if(value != undefined || value != null){

               var  json = {
                     "PermissionName":$(this).attr("data-name"),
                      "PermissionType": $(this).attr("data-path"),
                      "value":value


                  } ;

             jsonarray.push(json) ;

              }



          }



     });



  globalGroups["AssignedPermissions"][globalID]  =    jsonarray;

     var jsongroup = JSON.stringify(globalGroups);



    $.ajax({
       dataType:"json",
     type: "POST",
      data: jsongroup,
      url: 'Groups/sendGroup/'+groupID,

      success: function(){
          if(  globalGroups["IsActive"] == false){
                $("h2.grouptrigger[data-group='"+groupID+"']").remove();
          }
          else
          {
          $("h2.grouptrigger[data-group='"+groupID+"']").find("span").text($("#name").val());
           saved = true  ;
          }
      }
});


 }
</script>
<style>

.header {
  background-color:#8D8D8D;
        height:20px;
        -moz-border-radius:5px 5px 0px 0px;
        width:90%;
        margin:0 auto 0 20px ;
        float:left;
      	border: 1px solid #8D8D8D;
}
li.top{


}

.opened{
  color: #616161;
list-style-image:url('./assets/img/minus_04.png');
}
.close{

list-style-image:url('./assets/img/plus_04.png')
}
li.child{
  color: black;

}
li.grandchild{
  color: black;
}
.ui-tabs .ui-tabs-nav {
    font-size: 14px;
    margin: 0;
    padding: 0 0 0;
         -moz-border-radius: 0; /* FF1+ */
  -webkit-border-radius: 0; /* Saf3-4, iOS 1+, Android 1.5+ */
          border-radius: 0;
}




#userslist,#permissions{
overflow-y:auto;
color:#666;
height:400px;
      margin-top: 15px;
        margin-left: 10px;
}
#permissions ul{
     margin:0;
    position:relative;
}
#permissions ul li{
        position:relative ;
    margin:0;
}
#permissions ul li{
      line-height: 20px;
    position:relative;

    text-indent: 8px;
    vertical-align:top;
    list-style:none;
}

#permissions ul li#root:before{
    content:"";
    position:absolute;
  background:url('./assets/img/arrow-down_01.png') no-repeat 0 100%;
    left:-40px;
    width:8px;
    height:15px;


}
#permissions  li#son {

}
 #permissions ul li#son:before{
    content:"";
    position:absolute;
  background:url('./assets/img/arrow-right_01.png') no-repeat 0 100%;
    left:-40px;
    width:8px;
    height:9px;
     top:5px;


}
#addselected{
	width: 500px;
	height:25px;
	float: left;
	color: white;
	position:relative;
	z-index: 1000;
}

#addselected>select{
width:300px;
background:#F5F5F5;
-moz-border-radius:5px;
-webkit-border-radius:5px;
border-radius:5px;
position: absolute;
z-index: 1000;
top:0;
border:1px solid #F5F5F5;
margin-right:4px;
float: left;
font-size: 12px;
padding: 5px;
    color:#666;

}
#accountscombo select {
 background:#F5F5F5;
  font-size: 12px;
padding: 5px;
    border:0;
}
#addselected>select:selected{

font-size: 12px;
}
#addselected>select>option{

font-size:12px;
width: 100%;

}
#addselected a#add{
float: right;
width: 20%;
display: block;
}
#listings{
width:300px;
display: block;
   margin: 0;
    padding: 0;

}

#listings li{
  float: left;
    list-style: none outside none;
    margin: 10px 0;
    position: relative;
    text-indent: 24px;
    width: 100%;

}
#listings li:hover{
        background:#F5F5F5;
   -moz-border-radius: 5px;
    -webkit-border-radius:5px;
    border-radius: 5px;
}

#listings li span.delete{
     color: red;
    display: none;
    font-weight: bold;
    left: 271px;
    position: absolute;
    text-shadow: 1px 1px 1px #383838;
    top: 7px;

    background:url("assets/img/x_03.png")  no-repeat;
}
#listings li:hover span.delete{
  display:block;

}
.ui-button {
float: right !important;
}
#tabs{
	display:none;
	width: 80%;
    overflow:hidden;

	

}
#groupwrapper{
	width: 100%;
	overflow:hidden;
}
#groupcontent{
     width:90%;
    overflow:hidden;
    border-left: 1px solid #C2C3C5 ;
    border-right: 1px solid #C2C3C5 ;
     border-bottom: 1px solid #C2C3C5 ;
	float:left;
	

    margin: 0 auto 10px 20px;

 

}
h2.grouptrigger {
	background:#F5F5F5 url('assets/img/grid_small.gif') 10px no-repeat ;
    border-top:1px solid #C2C3C5;
    float:left;
    font-family:"verdana";
    font-size:14px;
    font-weight:normal;
    height:23px;
    line-height:23px;
    margin:0;
    outline:medium none;
    padding:1px 0px 1px 50px;

    width:100%;
        position:relative;
		width:95%\9;
 color: #616161;
}
h2.grouptrigger span{

cursor:pointer;

}
h2.grouptrigger a {
	
	text-decoration: none;
	display: block;
	color: #616161;
    

}

h2.grouptrigger:hover{

    background-color:#E3EDCB   ;
   
}
h2.grouptrigger a:hover {
    color:#7CA81D;
   
}

h2.grouptrigger img{
position:absolute;

width:15px;
height:12px;
top:7px;



right:7%;
}

h2.groupactive {
  
    background:#E3EDCB url("assets/img/tb-open.png") left no-repeat;
    padding: 0 0 0 50px;
	height:23px;
    line-height:23px;
	width: 100%;
	font-size: 14px;
    font-family:"verdana";
	font-weight: normal;
	float: left;
    position:relative;
	width:95%\9;
    
}

/*--When toggle is triggered, it will shift the image to the bottom to show its "opened" state--*/



.group_toggle_container {
	margin: 0px 0px 0px 0px;
	padding: 0;
	font-size: 12px;
    overflow:auto;
	width: 100%;
	clear: both;
    display: block;
}




.toggle_container .block {
	padding: 0px; /*--Padding of Container--*/
	width:960px;
    font-size:12px;
    margin-top:0px;
    margin-bottom:0px;
     
}
/*
#accountscombo{
display:none;
font-size: 12px;
font-family: verdana;
position:absolute;
z-index:100000;
background-color: #F5F5F5;
width: 100%;
height: 300px;
overflow: auto;
top:22px;


}
#accountscombo ul{

padding-left:20px; 
}
#accountscombo li{
list-style: none;
margin-left: 1px;

}
*/
#accountwrap{
width: 500px;
font-size: 12px;
position: relative;


}

#arrows{
width: 19px;
position: absolute;
top:1px;
height:19px;
right: 2px;
}

.comboregular{

    background: url("assets/img/down-arrow_04.png") left no-repeat;

}

.openarrow{

    background:url("assets/img/down-arrow-pressed_04.png") left no-repeat;


}
 #permissions ul li.rep{
     list-style:none;
     background:url("./assets/img/_question.png") no-repeat left ;
 }
#permissions ul li.rep{
    float:left;
    position:absolute;
    width:20px   ;
    height:20px;
    left:10px;
    z-index:10000;
    margin-left:8px;


}
#permissions ul li.arrow,#permissions ul li.arrowchild {
    list-style:none;

}
#permissions ul li.arrow{
   position:absolute;
    width:8px   ;
    height:9px;
    left:0px;
    z-index:10000;
   top:5px;

}
#tabs-1 label{
    float:left;
    width:64px;
    line-height:25px;


}
#tabs-1 input[type="text"]  {
    width:200px;
    padding:5px 3px 5px 3px;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
     background: none repeat scroll 0 0 #F5F5F5;
    border:1px solid  #F5F5F5;
    color:    #666666;




}
#tabs-1 input[type="text"]:focus,#tabs-1 input[type="text"]:hover{

   border-color:#90B63D;

}
#tabs-1 input[type="checkbox"]{
    float:left;
      margin-left: 1px;
    margin-top:7px;
}

.firstchild{

    padding-left:40px;
}
.secondchild{
    padding-left:60px;
}
.thirdchild{

    padding-left:90px;
}
.forthchild{

    padding-left:100px;
}
#addselected>select:hover,#accountscombo>select:hover{
     border-color:#90B63D;

}
/*
</style>
