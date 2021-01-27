<?php

    // get circle and user eligibility by circle idea
    if (!isset($_GET['q']) || $_GET['q']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['us']) || $_GET['us']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['pid']) || $_GET['pid']==''){
          header("location: work_circle.php");
    }


    $_GET_URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_cell_id = $_GET_URL_cell_id[1];

    $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
    $_GET_URL_user_id = $_GET_URL_user_id[1];

    $_GET_URL_project_id = explode("-",htmlspecialchars(strip_tags($_GET['pid'])));
    $_GET_URL_project_id = $_GET_URL_project_id[1];





    $page_title = 'Work Circle - Projects | Milestone - Edit';

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



      <!-- list of projects //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class='fas fa-cogs'></i> Project Information & Settings</big>
                    <?php
                          $project = new Project();
                          $get_project = $project->get_project_by_id($_GET_URL_project_id);
                          $project_title = '';
                          foreach($get_project as $gp){
                              $project_title = $gp['project_title'];
                          }
                          echo "<div class='py-2'><span style='color:#1c2331'>".$project_title.'</span></div>';

                    ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php
                        $code1 = mask($_GET_URL_cell_id);
                        $code2 = mask($_GET_URL_user_id);
                        $code3 = mask($_GET_URL_project_id);
                        $post_project_create_link = "circle_project_create_update.php?q=".$code1."&us=".$code2."&pid=".$code3;
                        $post_project_updates_link = "circle_projects.php?en=".$code1."&us=".$code2;

                    ?>
                    <a href="<?php echo $post_project_updates_link; ?>" class="btn btn-sm btn-success btn-rounded"> <i class="fas fa-chevron-left"></i> &nbsp;Project Updates</a>
                    <a href="<?php echo $post_project_create_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> &nbsp;Create Update</a>
              </div>

              <!-- inside pane //-->

              <!--    MILESTONE ADD FORM     //-->
              <div id='milestone_add_form' class="border rounded z-index-5 col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-1" style='display:none;'><!-- checklist add pane //-->
                <!-- milestone add //-->
                                <!-- Title //-->
                              <h4 class='mt-2'> Add Milestone</h4>

                              <div id='add_message'></div>

                              <div class="form-group row">
                                      <label for="milestone_title" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Item</label>
                                      <div class="col-xs-12 col-sm-12 col-md-9">
                                                  <input class="form-control" id="milestone_title" placeholder="Title" required >

                                      </div>
                              </div>
                              <!-- end of title //-->

                              <!-- Description //-->
                              <div class="form-group row">
                                      <label for="milestone_description" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Description</label>
                                      <div class="col-xs-12 col-sm-12 col-md-9">
                                                  <textarea class="form-control" id="milestone_description" placeholder="Description" ></textarea>

                                      </div>
                              </div>
                              <!-- end of Description //-->

                              <!-- Start Date //-->
                               <div class="form-group row">
                                       <label for="milestoneDate" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Start Date</label>
                                       <div class="col-xs-12 col-sm-12 col-md-9">
                                                   <input class="form-control datepicker" id="milestoneDate" placeholder="Start Date" >

                                       </div>
                               </div>
                               <!-- end of Start Date //-->



                               <!-- Save button //-->
                               <div class="form-group row">
                                       <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right"></label>
                                       <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                           <div id='btn_save_milestone' class="btn btn-sm btn-success btn-rounded mb-4">Save</div>
                                       </div>
                               </div>
                               <!-- end of save button //-->



                <!-- end of milestone add //-->
              </div><!-- Milestone add pane  //-->
              <!-- END OF MILESTONE ADD FORM //-->





              <!--    MILESTONE EDIT FORM     //-->
              <div id='milestone_edit_form' class="border rounded  col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-1" style='display:none;'><!-- checklist edit pane //-->
                <!-- milestone add //-->
                                <!-- Title //-->
                              <h4 class='mt-2'> Edit Milestone</h4>

                              <div id='edit_message'></div>

                              <div class="form-group row">
                                      <label for="milestone_edit_title" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Title</label>
                                      <div class="col-xs-12 col-sm-12 col-md-9">
                                                  <input class="form-control" id="milestone_edit_title" placeholder="Title" required >
                                                  <div id='milestone_edit_title-error' class='text-danger'></div>

                                      </div>
                              </div>
                              <!-- end of title //-->

                              <!-- Description //-->
                              <div class="form-group row">
                                      <label for="milestone_edit_description" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Description</label>
                                      <div class="col-xs-12 col-sm-12 col-md-9">
                                                  <textarea class="form-control" id="milestone_edit_description" placeholder="Description" ></textarea>

                                      </div>
                              </div>
                              <!-- end of Description //-->

                              <!-- Start Date //-->
                               <div class="form-group row">
                                       <label for="startingDate" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Start Date</label>
                                       <div class="col-xs-12 col-sm-12 col-md-9">
                                                   <input class="form-control datepicker" id="startingDate" placeholder="Start Date" >

                                       </div>
                               </div>
                               <!-- end of Start Date //-->



                               <!-- Save button //-->
                               <div class="form-group row">
                                       <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right"></label>
                                       <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                           <div id='btn_milestone_update' class="btn btn-sm btn-success btn-rounded mb-4">Update</div>
                                       </div>
                               </div>
                               <!-- end of save button //-->



                <!-- end of milestone add //-->
              </div><!-- Milestone add pane  //-->
              <!-- END OF MILESTONE EDIT FORM //-->



              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                  <div id='div_add_milestone' class='text-primary' style='cursor:pointer;'><i class="fas fa-plus mb-3 text-primary"></i> Add Milestone </div>
                  <!-- check list display from database //-->

                      <ul id='milestoneItems' style='list-style-type:none;'>


                        <?php
                          $get_milestones = $project->get_project_milestone_by_project_id($_GET_URL_project_id);

                          foreach($get_milestones as $gm){
                              $milestone_id = $gm['id'];
                              $creator_id = $gm['user_id'];
                              $title = FieldSanitizer::outClean($gm['title']);
                              $description = FieldSanitizer::outClean($gm['description']);
                              $milestone_date = $gm['milestone_date'];

                              $the_specified_date = '';
                              if ($milestone_date!=''){
                                 $the_specified_date = "<span id='mdate{$milestone_id}'>".$milestone_date.'</span> <small><i class="fas fa-chevron-right"></i></small> ';
                                 $title = "<span id='mtitle{$milestone_id}'>".$title."</span>";
                              }

                              $li_id = 'milestone'.$milestone_id;
                              $delete_icon_id = 'delMilestone'.$milestone_id;
                              $edit_icon_id = 'editMilestone'.$milestone_id;

                        ?>
                                              <li  class='li_milestone_item' title='<?php echo $description; ?>' id='<?php echo $li_id; ?>' style='cursor:pointer;padding:3px;'>
                                                    <i class='far fa-calendar-check fa-1x green-text pr-2'></i>
                                                    &nbsp; <?php echo $the_specified_date.$title; ?> &nbsp;&nbsp; <small><i title='Delete this item' id='<?php echo $delete_icon_id; ?>' data-toggle='modal' data-target='#confirmDelete' class='fas fa-times text-danger delMilestone'>
                                                    </i> &nbsp; &nbsp; <i title='Edit this item' id='<?php echo $edit_icon_id; ?>' class='far fa-edit text-info editMilestone'></i></small>
                                              </li>
                        <?php
                          } // end of foreach
                        ?>
                  <!-- end of milestone item loop//-->

                    </ul>

              </div><!-- end of inside pane //-->
      </div>


      <!-- end of list projects //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<input type='hidden' id='cell_id' value='<?php echo $_GET_URL_cell_id ?>' />
<input type='hidden' id='user_id' value='<?php echo $_GET_URL_user_id; ?>' />
<input type='hidden' id='new_project_id' value='<?php echo $_GET_URL_project_id; ?>' />
<input type='hidden' id='milestone_to_delete' value='' />
<input type='hidden' id='milestone_to_edit' value='' />

<br/><br/><br/>

<!-- Modal Module -------------------------------->

<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         Do you really wish to delete the <strong>Checklist item</strong>? <br/>
         <small>Note: The action is not reversible.</small>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="button" id="delete_milestone_item" class="btn btn-danger" data-dismiss="modal"><i class="far fa-trash-alt"></i> Delete</button>
      </div>
    </div>
  </div>
</div>

<!--  End of Modal    ----------------------------------------------->

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

 <script src="../../lib/js/custom/project/from-to-date.js"></script>
 <script src="../../lib/js/custom/circle/from-to-date.js"></script>

 <script>

 $(document).ready(function(){
   //-----------------------   Toggle checklist Add form ------------------------------------
    $("#div_add_milestone").on("click", function(){
        $("#milestone_edit_form").hide();
        $("#milestone_add_form").toggle();
    });

   //------------------------  End of toggling checklist Add form-----------------------------


   //------------------------ Toggle milestone Edit form -------------------------------------
   $(document).on("click",".editMilestone", function(event){
    $("#milestone_add_form").hide();
    $("#milestone_edit_form").toggle();

    var selected_milestone_id = $(this).attr("id").replace(/\D/g,'');


    // get checklist item content and insert into title and description fields
    //var title_content = $("#milestone"+selected_milestone_id).text();
    var title_content = $("#mtitle"+selected_milestone_id).text();
    title_content = $.trim(title_content);

    var description_content = $("#milestone"+selected_milestone_id).attr("title");
    var date_content = $("#mdate"+selected_milestone_id).text();

    //alert(description_content);

    // insert content into fields
    $("#milestone_edit_title").val(title_content);
    $("#milestone_edit_description").val(description_content);
    $("#startingDate").val(date_content);

    // set checklist_to_edit
    $("#milestone_to_edit").val(selected_milestone_id);


     event.stopProgation();

   })



   //----------------------- End of checklist Edit form -------------------------------------


   //-------------------------marking or unmarking of checklist--------------------------------------------

   $(document).on("click",".chklist_item", function(){
     var selected_checklist_id = $(this).attr('id');
     var checkList_id = $(this).attr('id').replace(/\D/g,'');

     var state = $("#"+selected_checklist_id+">i").attr("class");
     var action = '';

     if (state == 'far fa-square fa-1x green-text pr-3'){
        $("#"+selected_checklist_id+">i").attr("class", "far fa-check-square fa-1x green-text pr-3");
        action = "check";
     }else{
        $("#"+selected_checklist_id+">i").attr("class", "far fa-square fa-1x green-text pr-3");
        action = "uncheck";
     }

     // call async service for checking or unchecking of checklist item
     $.post("../../async/server/projects/set_checklist_executed_status.php", {"checklist_id":checkList_id, "action":action}, function(data){
        //alert(data)
     });


   });

   //--------------------------------------------------------------------------------------

   //--------------------------------------------- Milestone Save Item by Save button click --------------------------------------------

   $("#btn_save_milestone").bind("click", function(){
       if ($("#milestone_title").val()!=''){
             $("#milestone_title-error").hide();

             var project_id = $('#new_project_id').val();
             var user_id = $('#user_id').val();
             var milestone_title = $("#milestone_title").val();
             var milestone_description = $("#milestone_description").val();
             var milestone_date = $("#milestoneDate").val();

             $.ajax({
               url: '../../async/server/projects/create_project_milestone.php',
               method: "POST",
               data: {project_id: project_id, user_id: user_id, milestone_title: milestone_title, description: milestone_description, milestone_date: milestone_date},
               dataType: 'html',
               cache: false,
               processdata: false,
               beforeSend: function(){},
               success: function(data){

                  //var result = jQuery.parseJSON(data);
                  if (data!=''){
                     //$(".chklist_item:last").after(data);
                     //$(".li_milestone_item:last").after(data);
                     $("#milestoneItems").append(data);

                     var success_message = "<div class='alert alert-success mb-1' role='alert'>The Item has been successfully added to the Checklist</div>";
                     $("#add_message").html(success_message).slideDown().delay(5000).slideUp(2000);

                     //$("#divAddedCheckList").animate({"scrollTop": $("#divAddedCheckList")[0].scrollHeight}, "slow");
                  }
               } // end of success: function(data)

             });
       }else{
           // if title field is blank
           var error_message = "<div class='alert alert-danger mb-1' role='alert'>The title of the <strong>Item</strong> and <strong>description</strong> are required</div>";
           $("#add_message").html(error_message).slideDown().delay(5000).slideUp(2000);


       }
   });


   //-----------------------------------------------------------------------------------------------------------------------------------

   //------------------------------------- delMilestone click event -----------------------------------------------------------------------

   $(document).on("click", ".delMilestone", function(event){

     var icon_delete_milestone_id = $(this).attr('id');
     var icon_delete_milestone_id_value = $(this).attr('id').replace(/\D/g,'');
     $("#milestone_to_delete").val(icon_delete_milestone_id_value);

     //alert(icon_delete_checklist_id);

     event.stopProgation();
   });






   //------------------------------------- end of delChkLst event -----------------------------------------------------------------------


//----------------------------------------- Delete Selected Checklist Item -------------------------------------------------------------

  $("#delete_milestone_item").on("click", function(){
    //var selected_milestone_id = $(this).attr('id');
    var selected_milestone_id = $("#milestone_to_delete").val();
    //var checkList_id = $("#checklist_to_delete").attr('id').replace(/\D/g,'');

    $.post("../../async/server/projects/delete_milestone.php", {"milestone_id":selected_milestone_id}, function(data){

          if (data==1){

            //$("#chkLst"+checkList_id).remove();
            location.reload();
          }
    });


  });


//---------------------------------------- End of Delete Selected Checklist Item -------------------------------------------------------



//----------------------------------------- BtnUpdate for Checklist item edit -------------------------------------------------
$("#btn_milestone_update").bind("click", function(event){

  var milestone_title = $("#milestone_edit_title").val();
  var milestone_description = $("#milestone_edit_description").val();
  var milestone_date = $("#startingDate").val();
  var project_id = $("#new_project_id").val();
  var milestone_id = $("#milestone_to_edit").val();

  if (milestone_title==''){

     $("#milestone_edit_title-error").html("<small>Milestone title is required");

  }else{

    //-------------   Ajax -----------------------------------------------------
     $.ajax({
        url: '../../async/server/projects/edit_project_milestone.php',
        method: "POST",
        data: {project_id: project_id, milestone_title: milestone_title, milestone_description: milestone_description, milestone_date: milestone_date, milestone_id: milestone_id},
        dataType: 'html',
        cache: false,
        processdata: false,
        beforeSend: function(){},
        success: function(data){

            if (data==1){
                  var success_message = "<div class='alert alert-success mb-1' role='alert'>The Item has been successfully edited and updated.</div>";
                  $("#edit_message").html(success_message).slideDown().delay(5000).slideUp(2000);

            }else{
                 var error_message = "<div class='alert alert-danger mb-1' role='alert'>No update is performed. Make a change and update.</div>";
                 $("#edit_message").html(error_message).slideDown().delay(5000).slideUp(2000);
            }
        }
     });
     //------------- end of ajax -----------------------------------------------

  }

  event.stopProgation();

})






//---------------------------------------- End BtnUpdate for Checklist item Edit ---------------------------------------------









 }); // end of document ready


 </script>

 <script src="../../lib/js/custom/tblData.js"></script>
