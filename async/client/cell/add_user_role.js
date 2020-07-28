// role click buttons
var role_list = [];

$(document).ready(function(){
      //-------------------------------------------------------------------------


      $("#btn_add_role").bind("click", function(){
            var role_id = $("#cbl_role").val();
            var role = $("#cbl_role option:selected").text();
            console.log(role_list);
            //console.log(role);

            // check if role has alrady been already_added
            var already_added = 0;
            for (var i=0; i<role_list.length; i++){
                if (role_list[i]['id']==role_id){
                    already_added = 1;
                }
            }

            // check if a role is selected and not blank
            if (role_id != 0)
            {
                  // check that role is not already selected
                  if (already_added==0){
                        role_list.push({id:role_id,
                                        role: role});
                  }else{
                        alert("The role '" + role + "' has already been added");
                  }
            } else{
               alert("Please select a role to add to User");
            }//end of if statement

            //console.log(role_list);
            //console.log(role_list.length);

            // add added role to page
            var listOption = '';
            var just_array_ids = [];
            for (var i=0; i<role_list.length; i++){
                listOption += '<li>' + role_list[i]["role"] + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><span id="item-' + role_list[i]['id'] + '" class="spanbutton" >Remove</span></small></li>';
                just_array_ids.push(role_list[i]['id']);
            }

            $("#role-array").html("<ul>" + listOption + "</ul>");
            $("#role-array").show();

            $("#role_array_list").val(just_array_ids);   // container to pick selected role ids
      });// end of add role when button is clicked




});  // end of document ready
