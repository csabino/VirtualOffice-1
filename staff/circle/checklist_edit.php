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





    $page_title = 'Work Circle - Projects';

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


              <div id='checklist_form' class="border rounded z-index-5 col-xs-12 col-sm-12 col-md-8 col-lg-8 mt-1" style='display:none;'><!-- checklist add pane //-->
                <!-- checklist add //-->
                                <!-- Title //-->
                              <h4 class='mt-2'> Add Checklist</h4>

                              <div id='add_message'></div>

                              <div class="form-group row">
                                      <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Item</label>
                                      <div class="col-xs-12 col-sm-12 col-md-9">
                                                  <input class="form-control" id="checklist_item" placeholder="Item" required >

                                      </div>
                              </div>
                              <!-- end of Targets //-->

                              <!-- Description //-->
                              <div class="form-group row">
                                      <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Description</label>
                                      <div class="col-xs-12 col-sm-12 col-md-9">
                                                  <textarea class="form-control" id="checklist_description" placeholder="Description" ></textarea>

                                      </div>
                              </div>
                              <!-- end of Description //-->



                               <!-- Save button //-->
                               <div class="form-group row">
                                       <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right"></label>
                                       <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                           <div id='step2_btn_save' class="btn btn-sm btn-success btn-rounded mb-4">Save</div>
                                       </div>
                               </div>
                               <!-- end of save button //-->



                <!-- end of checklist add //-->
              </div><!-- Checklist add pane  //-->



              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
                  <div id='div_add_checklist' class='text-primary' style='cursor:pointer;'><i class="fas fa-plus mb-3 text-primary"></i> Add Checklist </div>
                  <!-- check list display from database //-->




                        <?php
                          $get_checklist = $project->get_project_checklist_by_project_id($_GET_URL_project_id);

                          foreach($get_checklist as $gc){
                              $checklist_id = $gc['id'];
                              $creator_id = $gc['user_id'];
                              $item = FieldSanitizer::outClean($gc['item']);
                              $description = FieldSanitizer::outClean($gc['description']);
                              $executed = $gc['executed'];

                              $li_id = 'chkLst'.$checklist_id;
                              $delete_icon_id = 'delChkLst'.$checklist_id;
                              $edit_icon_id = 'editChkLst'.$checklist_id;

                        ?>
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                              <div class='chklist_item' title='<?php echo $description; ?>' id='<?php echo $li_id; ?>' style='cursor:pointer;padding:3px;'>
                                         <i class='far fa-square fa-1x green-text pr-3'></i>
                                         <?php echo $item; ?> &nbsp; &nbsp;<small><i title='Delete this item' id='<?php echo $delete_icon_id; ?>' data-toggle='modal' data-target='#confirmDelete' class='fas fa-times text-danger delChkLst'></i></small>
                                         &nbsp; &nbsp; <small><i title='Edit this item' id='<?php echo $edit_icon_id; ?>' class='far fa-edit text-info delChkLst'></i></small>
                              </div>
                        </div>
                        <?php

                          } // end of foreach
                        ?>






                  <!-- end of checklist //-->



              </div><!-- end of inside pane //-->
      </div>


      <!-- end of list projects //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<input type='text' id='cell_id' value='<?php echo $_GET_URL_cell_id ?>' />
<input type='text' id='user_id' value='<?php echo $_GET_URL_user_id; ?>' />
<input type='text' id='new_project_id' value='<?php echo $_GET_URL_project_id; ?>' />
<input type='text' id='checklist_to_delete' value='' />

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
        <button type="button" id="delete_checklist_item" class="btn btn-danger" data-dismiss="modal"><i class="far fa-trash-alt"></i> Delete</button>
      </div>
    </div>
  </div>
</div>

<!--  End of Modal    ----------------------------------------------->

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

 <script>

 $(document).ready(function(){
   //-----------------------   Toggle checklist form ------------------------------------
    $("#div_add_checklist").on("click", function(){
        $("#checklist_form").toggle();
    });

   //-------------------------------------------------------------------------------------

   $(document).on("click",".chklist_item", function(){
     var selected_checklist_id = $(this).attr('id');
     var checkList_id = $(this).attr('id').replace(/\D/g,'');

     var state = $("#"+selected_checklist_id+">i").attr("class");

     if (state == 'far fa-square fa-1x green-text pr-3'){
        $("#"+selected_checklist_id+">i").attr("class", "far fa-check-square fa-1x green-text pr-3");
     }else{
        $("#"+selected_checklist_id+">i").attr("class", "far fa-square fa-1x green-text pr-3");
     }


   });

   //--------------------------------------------------------------------------------------

   //--------------------------------------------- Checklist Save Item by Save button click --------------------------------------------

   $("#step2_btn_save").bind("click", function(){
       if ($("#checklist_item").val()!=''){
             $("#checklist_item-error").hide();

             var project_id = $('#new_project_id').val();
             var user_id = $('#user_id').val();
             var checklist_item = $("#checklist_item").val();
             var checklist_description = $("#checklist_description").val();
             $.ajax({
               url: '../../async/server/projects/create_project_checklist_with_div.php',
               method: "POST",
               data: {project_id: project_id, user_id: user_id, checklist_item: checklist_item, checklist_description: checklist_description},
               dataType: 'html',
               cache: false,
               processdata: false,
               beforeSend: function(){},
               success: function(data){

                  //var result = jQuery.parseJSON(data);
                  if (data!=''){
                     $(".chklist_item:last").after(data);
                     //$("#divAddedCheckList").animate({"scrollTop": $("#divAddedCheckList")[0].scrollHeight}, "slow");
                  }

                  //alert(data);

               }
             });
       }
   });


   //-----------------------------------------------------------------------------------------------------------------------------------

   //------------------------------------- delChkLst click event -----------------------------------------------------------------------

   $(document).on("click", ".delChkLst", function(event){
     var icon_delete_checklist_id = $(this).attr('id');
     var icon_delete_checklist_id_value = $(this).attr('id').replace(/\D/g,'');
     $("#checklist_to_delete").val(icon_delete_checklist_id_value);

     //alert(icon_delete_checklist_id);

     event.stopProgation();
   });






   //------------------------------------- end of delChkLst event -----------------------------------------------------------------------


//----------------------------------------- Delete Selected Checklist Item -------------------------------------------------------------

  $("#delete_checklist_item").on("click", function(){
    //var selected_checklist_id = $(this).attr('id');
    var selected_checklist_id = $("#checklist_to_delete").val();
    //var checkList_id = $("#checklist_to_delete").attr('id').replace(/\D/g,'');

    $.post("../../async/server/projects/delete_checklist.php", {"checklist_id":selected_checklist_id}, function(data){

          if (data==1){

            //$("#chkLst"+checkList_id).remove();
            location.reload();
          }
    });


  });








//---------------------------------------- End of Delete Selected Checklist Item -------------------------------------------------------









 }); // end of document ready


 </script>

 <script src="../../lib/js/custom/tblData.js"></script>
