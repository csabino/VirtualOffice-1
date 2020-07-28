$(document).ready(function(){
      //-------------------------------------------------------------------------
      // fetch user data
      $("#btn_fetch_user").on("click", function(){

              var user_file_no = $("#user_file_no").val();
              var mydata = {fileno:user_file_no};

              //connect to server using ajax
              $.ajax({
                  url:'../../async/server/cell/search_user_by_fileno.php',
                  method: "POST",
                  data: mydata,
                  dataType: 'json',
                  cache: false,
                  processdata: false,
                  beforeSend: function(){
                      console.log("Am going now ");
                  },
                  success: function(data){
                      //alert("me");
                      //console.log(Object.keys(data).length);
                      //console.log(data);
                      if (data.recordno){
                          console.log(data);
                          $("#error-pane").html("");
                          $("#fullname").html(data.title + ' ' + data.first_name + ' ' + data.last_name + ' ' + data.other_names);
                          $("#position").html(data.position + ', ' + data.grade_level);
                      }else{
                          $("#fullname").html("");
                          $("#position").html("");
                          //$("#info-pane").hide();
                          $("#error-pane").html("<span><i class='fas fa-exclamation-triangle'></i> No such record is found.</span>");
                      }
                  }
              }) // end of ajax

      }) // end of btn_fetch_user click
      //  end of fetch user data\
      // ------------------------------------------------------------------------

      // role click buttons
      var role_list = [];
      var already_added = 0;
      $("#btn_add_role").bind("click", function(){
            var role_id = $("#cbl_role").val();
            var role = $("#cbl_role option:selected").text();
            console.log(role_list);
            console.log(role);

            if (role_id != 0)
            {
                        //-----------------------------------------------------------------
                        // check if role has been added already

                        $.each(role_list, function(key, value){
                            console.log(key + ' - ' + value);
                            if(key==role_id){
                                already_added = 1;
                                alert("The Role '" + role + "' has already been added.");
                            }

                        });

                        //  end of check if selected role has already been added
                        //-----------------------------------------------------------------

                        // Add role to add if not already added
                        if (already_added==0){
                            role_list[role_id] = role;
                        }
                        // end of add
                        //-----------------------------------------------------------------

                        // Read list into page
                        var listOption = '';
                        $.each(role_list, function(key, value){
                            console.log(key + ' - ' + value);
                            if (key!=''){
                                listOption +=  "<li>" + value + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small><span id='item-" + key + "' class='spanbutton' >Remove</span></small> </li>";
                            }

                        });

                        console.log(listOption);

                        $("#role-array").html("<ul>" + listOption + "</ul>");

            }









      });// end of add role when button is clicked



      //---------------------------------------------------------------------------

      // --------------------------------------------------------------------------
      // delete a role from the role-array
      $("span").live("click", function(){
          alert("am here");
      })





      // end of delete tole from the role-array
      //----------------------------------------------------------------------------


})
