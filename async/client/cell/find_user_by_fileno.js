var deletedStatus = '';
//alert("Inside User founder --" + user_record_found);
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
                      $("#output_pane").css({"display":"block"});
                      $("#spinner").css({"display":"block"});
                  },
                  success: function(data){
                      //alert("me");
                      //console.log(Object.keys(data).length);
                      //console.log(data);
                      $("#spinner").hide();
                      if (data.recordno){
                          console.log(data);


                          if (data.deleted==1){deletedStatus="<br/><small><span class='text-danger'>Record is marked as deleted</span></small>";}
                          $("#error-pane").html("");
                          $("#fullname").html(data.title + ' ' + data.first_name + ' ' + data.last_name + ' ' + data.other_names);
                          $("#position").html(data.position + ', ' + data.grade_level + deletedStatus);

                          // inside user_id and $cell_id
                          $("#selected_user_id").val(data.user_id);

                          // clear role-get_array
                          $("#role-array").hide();

                          // Add Appropriate button
                          user_record_found = 1;
                          add_button();

                      }else{
                          $("#fullname").html("");
                          $("#position").html("");

                          // hide role-panel
                          $("#role-pane").hide();

                          // hide role-array
                          $("#role-array").hide();

                          //$("#info-pane").hide();
                          $("#error-pane").html("<span><i class='fas fa-exclamation-triangle text-danger'></i> No such record is found.</span>");

                          // hide button panel
                          $("#button-pane").hide();
                      }
                  }
              }) // end of ajax

      }) // end of btn_fetch_user click
      //  end of fetch user data\
      // ------------------------------------------------------------------------



}); // end of document ready
