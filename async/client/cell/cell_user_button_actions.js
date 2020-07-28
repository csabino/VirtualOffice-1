
$(document).ready(function(){

//-------------------------------------------------------------------------
    $("#button-pane").on("click", function(){

        var user_id = $("#selected_user_id").val();
        var cell_id = $("#current_cell_id").val();
        var roles = $("#role_array_list").val();

        var btn_id = $("#button-pane>button").attr("id");


        if (btn_id=='btn_add')
        {
                  //----------  Add User to Cell -----------------------------------------------------
                  $.post("../../async/server/cell/add_user_to_cell.php",{"user_id":user_id, "cell_id": cell_id,
                        "roles":roles},function(data){

                          data = JSON.parse(data);

                          $("#role-pane").hide();
                          $("#role-array").hide();
                          $("#button-pane").hide();
                          $("#output_pane").hide();

                          if (data.status=='success')
                          {
                              $("#success-add-notification-pane").slideDown(2000)
                              .delay(5000)
                              .slideUp(2000);

                          }else{
                              $("#error-add-notification-pane").slideDown(2000)
                              .delay(5000)
                              .slideUp(2000);
                          }
                  }); // end of $.post
                  // --------- End of Add User to Cell  ------------------------------------------------


        }else{
                  //----------  Remove User from Cell -----------------------------------------------------
                  $.post("../../async/server/cell/remove_user_from_cell.php",{"user_id":user_id, "cell_id": cell_id
                        },function(data){

                          data = JSON.parse(data);

                          $("#role-pane").hide();
                          $("#role-array").hide();
                          $("#button-pane").hide();
                          $("#output_pane").hide();

                          if (data.status=='success')
                          {
                              $("#success-remove-notification-pane").slideDown(2000)
                              .delay(5000)
                              .slideUp(2000);

                          }else{
                              $("#error-remove-notification-pane").slideDown(2000)
                              .delay(5000)
                              .slideUp(2000);
                          }
                  }); // end of $.post
                  // --------- End of Remove User from Cell  ------------------------------------------------


        } // end of if statement


    })






});  // end of document ready
