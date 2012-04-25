<script id="groupstmpl"  type="text/x-jquery-tmpl">
			{{if Name}}
		<h2 class="grouptrigger" data-group="${GroupID}"><span> ${Name}</span><img class="x" src="assets/img/delete-icon.png"/></h2>
        
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

		<li id='${UserID}'>${Name}</li>
</script>
<script id="accounttmpltest"  type="text/x-jquery-tmpl">
           {{if Name }}
         			 <option  id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
             	{{if ChildAccounts !=""}}
                	 {{each ChildAccounts}}
                  	  <option style="padding-left:40px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                        {{if ChildAccounts !=""}}
                            {{each ChildAccounts}}
                                <option style="padding-left:60px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                {{if ChildAccounts !=""}}
                                 {{each ChildAccounts}}
                                <option style="padding-left:80px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
                                     {{if ChildAccounts !=""}}
                                 {{each ChildAccounts}}
                                <option style="padding-left:100px" id="${ID}"><a href="accounts/${ID}">${ Name }</a> </option>
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
		<input type="checkbox" value="check" />
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
	<div id="groupcontent">
		<div class="header">
			Name
		</div>
     
</div>
</div>


<script>
	
var globalGroups = "";
var groupID = "";
var globalID = "";
 var changed = false;
  var saved= false;
$(function(){

var users = jQuery.parseJSON('<?php echo $users; ?>');
	var groups = jQuery.parseJSON('<?php echo $groups; ?>');
     $("#userlistings").empty();
	$("#groupstmpl").tmpl(groups).appendTo("#groupcontent");




$("#permissions ul li.rep").live("click",function(){

    if($(this).hasClass('question')){
    $(this).removeClass('question').addClass("v").next('li').css('list-style-image','url("./assets/img/_v.png") ')    ;
    }
    else if($(this).hasClass('v')){
      $(this).removeClass('v').addClass("-").next('li').css('list-style-image','url("./assets/img/-.png") ')    ;
    }
    else if($(this).hasClass('-')) {

      $(this).removeClass('-').addClass("question").next('li').css('list-style-image','url("./assets/img/_question.png") ')    ;
    }
          saved = false;
     changed = true;
 });

    $("#permissions ul li.arrow").live("click",function(){

       $(this).siblings('li').children().slideToggle("fast");


    });
$("h2.grouptrigger span").live("click",function(){
		var name =  $(this).text();
		var datagroup =  $(this).parent().attr('data-group');
		groupID =datagroup;
         $('#listings').empty();
		//$("#groupNameTmpl").tmpl(groups).appendTo('#tabs-1 form.form');
		$('input#name').val(name);
		 permissionsMark();
		$.ajax({
			  url: "groups/getusers/"+datagroup,
			  success: function(data,index)
			  {
				var groupusers =jQuery.parseJSON(data);

			$("#userstmpl").tmpl(users).appendTo("#addselected select");
			
			$("#usersgrouptmpl").tmpl(groupusers).appendTo("#listings");
			
			var permittedUser = groupusers;

			
				$.each(permittedUser,function(k,v){
					
				
					
					$('#addselected select option[value='+v.UserID+']').remove();
			
				
				});
					
			 
			
				  }
			
		});

	
		$("#tabs").dialog({

		title:name,
         modal:true,
		resizable: true,
        resize:function(){
             $("#permissions").css("height",$(this).dialog().height()-50-38);
            $("#userlist").css("height",$(this).dialog().height()-50-38);

        } ,
		width:800,
		height:600,
		buttons: {"Cancel": function() {
					$( this ).dialog( "close" );
                },
                  "Save and exit":function(){
                      SendGroups(globalGroups);
                       $( this ).dialog( "close" );
                  },
				"Save": function() {
                    SendGroups(globalGroups);

				}


			}


		
		});
		
	
	});
	
	$("#tabs").tabs();
	$("a#add").button();
	
//var accounts = recusiveAccounts(_accountdata);
//	$("#accountscombo").append(accounts);
//	$("#accounttmpl").tmpl(_accountdata).appendTo('#accountscombo');
	$("#accounttmpltest").tmpl(_accountdata).appendTo('#accountscombo select');

/*
$('#accountscombo').find('li.child').each(function(){

		$(this).before($(this).parent().parent().text()+">"+$(this).parent().parent().parent().text());
	

});
*/


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
	
	
	$('#listings').append('<li id='+selectedID+'>'+selected.text()+'</li>');
	
	selected.remove();

	return false;
});

$('#listings li').live('click',function(){

	$('#addselected select').append('<option value='+$(this).attr('id')+'>'+$(this).text()+'</option>');
	
	$(this).remove();




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

      var group = jQuery.parseJSON(data);

      globalGroups =   group;
       var users = {  };
        var groupUsers =  group["Members"];

      var assignedpermission  =   group["AssignedPermissions"][$id];

        if(assignedpermission || assignedpermission != undefined)
        {




     //  console.log(group["GroupID"]);


       var b = "";

          $.each(assignedpermission,function(key,persmission){


                  $("#permissions li.data").each(function(){

                    if($(this).attr('data-name') == persmission.PermissionName ) {

                            if(!persmission.Value )  {


                                 // $(this).css('color','blue');
                                $(this).css('list-style-image','url("./assets/img/-.png") ').prev().removeClass("question").addClass('-');
                            }
                               else
                            {

                              //  $(this).css('color','red');
                                $(this).css('list-style-image','url("./assets/img/_v.png")').prev().removeClass("question").addClass('v');

                              }

                    }
                    else
                       {

                           $(this).css('list-style-image','url("./assets/img/_question.png") ')  ;
                        }




             });

          });

        }
  },
    complete:function(data){
         saved = false;

    },
    error:function(){

alert("error");
    }

});




}

 function SendGroups(globalGroups){
       var value = null ;

     var jsonarray = [];
     var members =  [];
     var listing =[];

     if( globalGroups["AssignedPermissions"][globalID] == undefined)
        $('.ui-dialog-buttonpane button').eq(0).button().hide();
      if(globalGroups["Name"] != $("#name").val()){

         globalGroups["Name"] =   $.trim($("#name").val());

      }

      if($("p.enabled input[type='checkbox']:checked")){

          globalGroups["IsActive"]  = true;
      }
         else
      {
          globalGroups["IsActive"]  = false;

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
          $("h2.grouptrigger[data-group='"+groupID+"']").find("span").text($("#name").val());
           saved = true  ;
      }
});


 }
</script>
<style>


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
        -moz-border-radius: 0px; /* FF1+ */
  -webkit-border-radius: 0px; /* Saf3-4, iOS 1+, Android 1.5+ */
          border-radius: 0px;
}




#userslist,#permissions{
overflow-y:auto;
color:#666;
height:400px;
      margin-top: 15px;
        margin-left: 10px;
}
#permissions ul{
     margin:0px;
    position:relative;
}
#permissions ul li{
      line-height: 20px;
    position:relative;
    list-style-image:url("./assets/img/_question.png")   ;
    vertical-align:top;
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
position: absolute;
z-index: 1000;
top:0;
border:0;
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
 #listings li:hover:before  {
      position:absolute;
    content:"X";
    margin-right:10px;
    font-weight:bold;
    color:red;
    left:-20px;
 text-shadow: 1px 1px 1px #383838;
filter: dropshadow(color=#383838, offx=1, offy=1);

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
    width:50%;
    overflow:hidden;
    border: 1px solid #C2C3C5 ;
    margin: 0 auto;
 

}
h2.grouptrigger {
	background:#F5F5F5 url('assets/img/tb-closed.png') left no-repeat ;
    border-top:1px solid #C2C3C5;
    float:left;
    font-family:"verdana";
    font-size:14px;
    font-weight:normal;
    height:23px;
    line-height:23px;
    margin:0;
    outline:medium none;
    padding:0 0 0 50px;
    width:100%;
        position:relative;
		width:95%\9;
 color: #616161;
}
h2.grouptrigger a {
	
	text-decoration: none;
	display: block;
	color: #616161;
    

}

h2.grouptrigger:hover{

    background:#E3E3E3 url("assets/img/tb-closed-hover.png") left no-repeat   ;
   
}
h2.grouptrigger a:hover {
    color:#7CA81D;
   
}

h2.grouptrigger img{
position:absolute;

width:16px;
height:16px;
top:3px;



right:10%;
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


h2.grouptrigger:hover{
    background:#E3EDCB url("assets/img/tb-open-hover.png") left no-repeat;

}
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
 }
#permissions ul li.rep{
    float:left;
    position:absolute;
    width:20px   ;
    height:20px;
    left:10px;
    z-index:10000;


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
#tabs-1 input[type="text"]:focus{

   border-color:#90B63D;

}
#tabs-1 input[type="checkbox"]{
    float:left;
      margin-left: 1px;
    margin-top:7px;
}


/*
</style>
