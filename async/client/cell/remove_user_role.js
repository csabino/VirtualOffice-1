$(document).ready(function(){

      // --------------------------------------------------------------------------
      // delete a role from the role-array
      $("#role-array").on("click", "span.spanbutton", function(){
          //alert(role_list);
          get_role_id = $(this).attr('id');
          role_id = get_role_id.replace(/\D/g,'');
          //alert(role_id);

          // convert string back into array
          get_array = ($("#role_array_list").val()).split(",");

          for (var i=0; i<get_array.length; i++){
              if (role_id==get_array[i]){
                  get_array.splice(i,1);  // remove selected item
                  role_list.splice(i,1); // selected item from the role_list array in add_user_role.js
                  console.log($(this).attr('id'));
                  $(this).parents("li").hide();
              }
          }

          console.log(get_array);
          $("#role_array_list").val(get_array);

          console.log(role_list);
      });

      // end of delete tole from the role-array
      //----------------------------------------------------------------------------


})
