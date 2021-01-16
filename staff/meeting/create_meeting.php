<?php

  // get user eligibility
  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'Create Meeting';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");


// -----------------------------------------------------------------------------
// ---- Postback functions

    $errFlag = 0;
    $flagMsg = '';
    if (isset($_POST['btnSubmit'])){
        $title = FieldSanitizer::inClean($_POST['title']);
        $meeting_date = FieldSanitizer::inClean($_POST['meeting_date']);
        $meeting_time = FieldSanitizer::inClean($_POST['meeting_time']);
        $description = FieldSanitizer::inClean($_POST['description']);

      // Check if all fields are filled in
      if ($title!='' && $description!=''){
            // create data array and populate data

            $dataArray = array("creator"=>$_GET_URL_user_id,"title"=>$title,"meeting_date"=>$meeting_date,
                          "meeting_time"=>$meeting_time, "description"=>$description);

            // call class and method
            $meeting = new Meeting();
            $result = $meeting->new_meeting($dataArray);

            if ($result){
                $errFlag = 0;
                $flagMsg = 'The <strong>Meeting</strong> has been successfully created.';
            }else{
                $errFlag = 1;
                $flagMsg = 'There was a problem creating the <strong>Meeting</strong>. <br/>Please try again or contact the Administrator.';
            }


      }else{
        $errFlag = 1;
        $flagMsg = "The <strong>Title</strong> is required to create a <strong>Meeting</strong>";
      } // end of all fields check


    } // end of isset





?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Meeting </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- Create a task //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="far fa-comments"></i> Create Meeting</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php



                        $code1 = mask($_GET_URL_user_id);
                        $create_task_link = "create_meeting.php?q=".$code1;
                        $tasks_list_link = "meetings.php?en=".$code1;

                    ?>
                    <a href="<?php echo $tasks_list_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-chevron-left"></i>&nbsp; Meetings</a>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><!-- Task body //-->

                <?php
                    $form_action_link = 'create_meeting.php?q='.mask($_GET_URL_user_id);
                ?>

                <!-- form //-->
                  <form class="border border-light p-4 " style="border-radius:5px;"
                    name="create task" action="<?php echo htmlspecialchars($form_action_link); ?>"
                    method="post">

                      <!-- Postback feedback //-->
                        <?php
                            if (isset($_POST['btnSubmit'])){
                                if ($errFlag){
                                    miniErrorAlert($flagMsg);
                                }else{
                                    miniSuccessAlert($flagMsg);
                                }
                            }
                        ?>
                      <!-- End of postback feedback //-->

                      <!-- Title //-->
                      <label for="title" class="text-info font-weight-normal">Title<span class='text-danger'>*</span></label>
                      <input type="text" id="title" name="title" class="form-control mb-3 " placeholder="Title" required maxlength="150">

                      <!-- Start Date //-->
                      <div class="row">
                              <label for="startingDate" class="col-xs-11 col-sm-11 col-md-2 col-form-label text-md-right">Date</label>
                              <div class="col-xs-12 col-sm-12 col-md-4">
                                          <input type='text' class="form-control datepicker" id="startingDate" name='meeting_date' placeholder="Date" >

                              </div>
                              <label for="input_starttime" class="col-xs-11 col-sm-11 col-md-2 col-form-label text-md-right">Time</label>
                              <div class="col-xs-11 col-sm-11 col-md-3">
                                          <input type='time' id="input_starttime" placeholder="Time" name='meeting_time' class="form-control" >

                              </div>
                      </div>
                      <!-- end of Start Date //-->





                      <!-- Description //-->
                      <label for="description" class="text-info font-weight-normal mt-3">Description<span class='text-danger'>*</span></label>
                      <textarea id="description" rows="5" name="description" class="form-control mb-3 " placeholder="Description" required></textarea>

                      <div class='mt-3'>
                        <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Create</button>
                      </div>


                <!-- end of form //-->


              </div><!-- end of body task //-->
      </div>


      <!-- end of list of tasks //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
   <script>
   $(document).ready(function(e){
         // Time Picker Initialization
     //$('#input_starttime').pickatime({});


   });

   </script>

  <script src="../../lib/js/custom/tblData.js"></script>
  <script src="../../lib/js/custom/circle/from-to-date.js"></script>
