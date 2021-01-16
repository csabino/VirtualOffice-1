<?php

    // get circle and user eligibility by circle idea
    if (!isset($_GET['en']) || $_GET['en']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['us']) || $_GET['us']==''){
          header("location: work_circle.php");
    }


    $_GET_URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
    $_GET_URL_cell_id = $_GET_URL_cell_id[1];

    $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
    $_GET_URL_user_id = $_GET_URL_user_id[1];





    $page_title = 'Work Circle - Create Project';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");



    $circle = new Circle();
    $my_circle = $circle->get_circle_user_info($_GET_URL_cell_id, $_SESSION['loggedIn_profile_user_id']);
    if (!$my_circle->rowCount()){
        $title = 'Unauthorised User Access';
        $msg = "Sorry, you do not have the required privilege to access the services on this page.";
        $footer = "<hr/><a href='work_circle.php'>Find your Work Circle</a>";
        errorAlert($title=$title,$message=$msg,$footer=$footer);
        exit;
    }

    $circle_id = '';
    $circle_name = '';
    $circle_short_name = '';

    foreach($my_circle as $row){
        $circle_id = $row['circle_id'];
        $circle_name = $row['circle_name'];
        $circle_short_name = $row['short_name'];

        if ($circle_short_name!=''){ $circle_short_name = " (". $circle_short_name.")";  }

    }






  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Work Circle </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <div class="row border-bottom">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1 mb-4 font-weight-bold' >
                  <?php  echo $circle_name.$circle_short_name; ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab' >
                  <?php
                        $general_link = "circle_general_room.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>General Room</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_announcements.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Announcements</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_team.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Team</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active'>
                  <?php
                        $general_link = "circle_projects.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Projects</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_files.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Files</a>";
                  ?>
            </div>

      </div>






      <!-- Projects //-->
      <div class="row mt-5">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-business-time"></i> Create Project</big>
              </div>



              <!-- stepper panel //-->
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <!-- Stepper widget //-->
                      <ul class="stepper linear horizontal " style="height:600px;">
                            <!-- Step 1 //-->
                            <li class="step active" >
                                <div data-step-label="" class="step-title waves-effect waves-dark" style='pointer-events:none;'>Step 1 - Definition</div>
                                <div class="step-new-content">
                                    <div class="row">
                                          <?php
                                                include_once("circle_create_project_definition.php");
                                           ?>
                                    </div>
                                    <div class="step-actions py-8">
                                        <button id="step1_continue" class="waves-effect waves-dark btn btn-sm btn-primary next-step" style='display:none;'>CONTINUE</button>
                                    </div>
                                </div>
                            </li>
                            <!-- end of step 1 //-->


                            <!-- Step 2 //-->
                            <li class="step">
                                <div class="step-title waves-effect waves-dark" style='pointer-events:none;'>Step 2 - Checklist</div>
                                <div class="step-new-content">
                                    <div class="row">
                                        <?php
                                              include_once("circle_create_project_checklist.php");
                                         ?>
                                    </div>
                                    <div class="step-actions">
                                        <button id='step2_continue' class="waves-effect waves-dark btn btn-sm btn-primary next-step">CONTINUE</button>
                                        <button id='step2_back' class="waves-effect waves-dark btn btn-sm btn-secondary previous-step">BACK</button>
                                    </div>
                                </div>
                            </li>
                            <!-- end of Step 2 //-->


                            <!-- Step 3 //-->
                            <li class="step">
                                <div class="step-title waves-effect waves-dark" style='pointer-events:none;'>Step 3 - Milestone</div>
                                <div class="step-new-content">
                                  <div class="row">
                                      <?php
                                            include_once("circle_create_project_milestones.php");
                                       ?>
                                  </div>

                                    <div class="step-actions">
                                        <?php
                                              $general_link = "circle_projects.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                                        ?>
                                        <button class="waves-effect waves-dark btn btn-sm btn-secondary previous-step mt-4">BACK</button>
                                        <a href="<?php echo $general_link; ?>" class="waves-effect waves-dark btn btn-sm btn-primary mt-4" >SUBMIT</a>

                                    </div>
                                </div>
                            </li>
                      </ul>
                      <!-- end of Stepper widget //-->




              </div><!-- end of stepper panel //-->
      </div>
      <!-- end of Projects //-->



      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type="hidden" name="cell_id" id="cell_id" value="<?php echo $_GET_URL_cell_id ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET_URL_user_id; ?>">
<input type='hidden' name='new_project_id' id='new_project_id' value="" >
<input type='hidden' name='project_source' id='project_source' value="circle" >

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>


 // Stepper JavaScript
  <script type="text/javascript" src="../../lib/js/addons-pro/stepper.js"></script>

 // Stepper JavaScript - minified
  <script type="text/javascript" src="../../lib/js/addons-pro/stepper.min.js"></script>



  <script src="../../lib/js/custom/circle/project-stepper.js"></script>
  <script src="../../lib/js/custom/circle/from-to-date.js"></script>
  <script src="../../lib/js/custom/project/from-to-date.js"></script>
  <script src="../../lib/js/custom/circle/stepper-buttons-functions.js"></script>

  <script>

  // ----------------------------------- Pop over ------------------------------------

  $(function () {
    $('[data-toggle="popover"]').popover();
  })


  //----------------------------------------------------------------------------------

  //-------------------

  $("#btn_create_project").bind("click", function(e){

       var btn_text = $("#btn_create_project").text();

       if (btn_text=='Create Project'){
           //check if  title is filled in
           if ($("#title").val()!=''){
                 create_project();
           }else{
                alert("You have not supplied required information \nto create a project.");
           }


       }else if(btn_text=='Update Project'){
           if ($("#title").val()!=''){
                 update_project();
           }else{

           }

       }
  });


  //------------------------------------------------------------------------------------------------------

    // Create Project
    function create_project(){
          var service_url = '../../async/server/projects/create_update_project.php';
          var operation = 'create';
          var project_log = 'Creating Project..';
          execute_create_update_function(service_url, operation, project_log);
    }//end of function create_project

//---------------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------------------------
//----------------------------  Update Project ------------------------------------------------------------

    function update_project(){
          // get $new_project_id
          var service_url = '../../async/server/projects/create_update_project.php';
          var operation = 'update';
          var project_log = 'Updating Project..';
          execute_create_update_function(service_url, operation, project_log);
    }

//---------------------------- end of Updating project //--------------------------------------------------

    // function to perform either create or update of project based on user interaction

    function execute_create_update_function(service_url, ops_mode, project_log){
              var cell_id = $("#cell_id").val();
              var creator = $("#user_id").val();
              var title = $("#title").val();
              var description = $("#description").val();
              var startDate = $("input#startingDate").val();
              var endDate = $("input#endingDate").val();
              var source = $("#project_source").val();
              var new_project_id = $("#new_project_id").val();


              $.ajax({
                  url: service_url,
                  method: "POST",
                  data: {cell_id: cell_id, creator: creator, title: title, description: description, startDate: startDate, endDate: endDate, source: source, operation: ops_mode, new_project_id: new_project_id},
                  dataType: 'json',
                  cache: false,
                  processdata: false,
                  beforeSend: function(){
                        console.log(project_log);
                  },
                  success: function(data){

                        if (data.status=='success'){

                            var outcome = "<div class='alert alert-success py-1' role='alert'>";
                            outcome += "<i class='far fa-check-circle'></i>&nbsp;&nbsp;&nbsp;&nbsp;" + data.msg + "</div>";

                            $("#step1_output_status").html(outcome);

                            if (ops_mode=='create'){

                                // display continue button
                                $("#step1_continue").show();
                                $("#btn_create_project").text('Update Project')

                                // Store new_project_id into hidden field
                                $("#new_project_id").val(data.new_project_id);
                            }


                        } else if (data.status=='failed'){
                            var outcome = "<div class='alert alert-danger py-1' role='alert'>";
                            outcome += "<i class='fas fa-exclamation-triangle'></i>&nbsp;&nbsp;&nbsp;&nbsp;" + data.msg + "</div>";
                            $("#step1_output_status").html(outcome);


                            if (ops_mode=='create'){
                                //clear title field
                                $("#title").val('');
                                //$("#step1_continue").hide();
                            }

                        }
                  }

              });  // end of ajax

    }

  //----------------------------- end of execute_create_update_function //----------------------------------------------
  //--------------------------------------------------------------------------------------------------------------------




 //---------------------------------------------------------------------------------------------------------------------
// --------------------------- Disable Checklist button if new_project_id is not available in hidden field

      $("#step1_continue").bind("click", function(){

          // check to know if a new project has been created
          var new_project_id = $("#new_project_id").val();

          // if no project is created or selected execute the function
          if (new_project_id==''){
                $("#checklist_item").prop('disabled', true);
                $("#checklist_description").prop('disabled', true);
                $("#step2_btn_save").prop('disabled', true);

                var status_msg = "Create or select a project to add checklist to it.";
                var outcome = "<div class='alert alert-danger py-1' role='alert'>";
                outcome += "<i class='fas fa-exclamation-triangle'></i>&nbsp;&nbsp;&nbsp;&nbsp;" + status_msg + "</div>";
                $("#step2_output_status").html(outcome);
          }


      });

//-----------------------------end of Disable checklist button if new_project _id is not available in hidden field ----------------
//--------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------- TAB 2 - Checklist ----------------------------------------------------------------------
//*********************************************************************************************************************************
//--------------------------------------------- Checklist change event of Item------------------------------------------------------
      $("#checklist_item").bind("change", function(){


      });
//--------------------------------------------- Checklist Description change focus event --------------------------------------------

      $("#checklist_description").bind("focus", function(){
        if ($("#checklist_item").val()!=''){
              $("#checklist_item-error").hide();
        }

      });



//--------------------------------------------- Checklist Save Item by Save button click --------------------------------------------

$("#step2_btn_save").bind("click", function(){
    if ($("#checklist_item").val()!=''){
          $("#checklist_item-error").hide();

          var project_id = $('#new_project_id').val();
          var user_id = $('#user_id').val();
          var checklist_item = $("#checklist_item").val();
          var checklist_description = $("#checklist_description").val();
          $.ajax({
            url: '../../async/server/projects/create_project_checklist.php',
            method: "POST",
            data: {project_id: project_id, user_id: user_id, checklist_item: checklist_item, checklist_description: checklist_description},
            dataType: 'html',
            cache: false,
            processdata: false,
            beforeSend: function(){},
            success: function(data){

               //var result = jQuery.parseJSON(data);
               if (data!=''){
                  $("#chkLstItems").append(data);
               }

               //alert(data);

            }
          });
    }
});


//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------- Checklist Delete Icon Click ---------------------------------------------

$(document).on("click",".delChkLst", function(){
    var selected_checklist_id = $(this).attr('id');
    var checkList_id = $(this).attr('id').replace(/\D/g,'');

    $.post("../../async/server/projects/delete_checklist.php", {"checklist_id":checkList_id}, function(data){
          if (data==1){
            $("#chkLst"+checkList_id).remove();
          }
    });

});




//------------------------------------------ End of Checklist Delete Icon Click ----------------------------------------

//--------------------------------------------- Milestone Title lost focus event --------------------------------------------

      $("#milestones_title").bind("focusout", function(){
        if ($("#milestones_title").val()!=''){
              $("#milestones_title-error").hide();
        }

      });



//--------------------------------------------- Milestone Description change focus event --------------------------------------------

      $("#milestone_description").bind("focus", function(){
        if ($("#milestones_title").val()!=''){
              $("#milestones_title-error").hide();
        }

      });

//------------------------------------------ Save Milestone //---------------------------------------------------------
$("#save_milestone").bind("click", function( event){
    event.preventDefault();

    if ($("#milestones_title").val()!=''){
        $("#milestones_title-error").hide();

        var project_id = $('#new_project_id').val();
        var user_id = $('#user_id').val();
        var milestone_title = $("#milestones_title").val();
        var description = $("#milestone_description").val();
        var milestone_date = $("#milestoneDate").val();

        console.log("Project Id: " + project_id);
        console.log("User_Id: " + user_id);
        console.log("Milestone_title: " + milestone_title);
        console.log("Description: " + description);
        console.log("Milestone Date: " + milestone_date);

        $.ajax({
          url: '../../async/server/projects/create_project_milestone.php',
          method: "POST",
          data: {project_id: project_id, user_id: user_id, milestone_title, description: description,
            milestone_date: milestone_date},
          dataType: 'html',
          cache: false,
          processdata: false,
          beforeSend: function(){},
          success: function(data){

              if (data!=''){
                $("#milestoneItems").append(data);
                //$("#divAddedMilestones").scrollTop = $("#divAddedMilestones").scrollHeight;
                //$('#divAddedMilestones').scrollTop($('#divAddedMilestones')[0].scrollHeight);
                $("#divAddedMilestones").animate({"scrollTop": $("#divAddedMilestones")[0].scrollHeight}, "slow");
              }

          }

        })
    }
});



// -------------------------------------------End of saving of milestone ----------------------------------------------


//------------------------------------------- Milestone Delete Icon Click ---------------------------------------------

$(document).on("click",".delMilestone", function(){
    var selected_milestone_id = $(this).attr('id');
    var milestone_id = $(this).attr('id').replace(/\D/g,'');

    $.post("../../async/server/projects/delete_milestone.php", {"milestone_id":milestone_id}, function(data){
          if (data==1){
            $("#milestone"+ milestone_id).remove();
          }
    });

});




//------------------------------------------ End of Milestone Delete Icon Click ----------------------------------------

  </script>
