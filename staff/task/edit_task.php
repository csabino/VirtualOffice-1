<?php

  // get user eligibility
  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: ../my_dashboard.php");
  }

  if (!isset($_GET['t']) || $_GET['t']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

  $_GET_URL_task_id = explode("-",htmlspecialchars(strip_tags($_GET['t'])));
  $_GET_URL_task_id = $_GET_URL_task_id[1];

    $page_title = 'Edit Task';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");

// -----------------------------------------------------------------------------
// ---- Postback functions

    $errFlag = 0;
    $flagMsg = '';
    if (isset($_POST['btnSubmit'])){
        $title = FieldSanitizer::inClean($_POST['title']);
        $project_name = FieldSanitizer::inClean($_POST['project']);
        $project_id = '';
        $description = FieldSanitizer::inClean($_POST['description']);
        $file = '';
        $cell_id = '';
        $file_upload_type = '';


      // ------------ file uploaded ---------------------------------------
      //  ------ check if file upload type is checked  ------------------------------
        if (!isset($_POST['file_upload_type'])){
            $file_upload_type = '';
            $file = '';
        }else{
            $file_upload_type = $_POST['file_upload_type'];
            // check if file has been uploaded
            if (isset($_SESSION['task_file']))
            {
                $file = $_SESSION['task_file'];
            } // end of check for file upload
            else{
                $file_upload_type = '';
            }
        }
      //------------- end of file uploaded  -------------------------------

      // Check if all fields are filled in
      if ($title!='' && $description!=''){
            // create data array and populate data
            $source = "My Task";
            $dataArray = array("cell_id"=>$cell_id, "author"=>$_GET_URL_user_id, "id"=>$_GET_URL_task_id,
            "project_id"=>$project_id, "project_name"=>$project_name, "title"=>$title, "description"=>$description,
            "source"=>$source, "file_upload_type"=>$file_upload_type, "file"=>$file);

            // call class and method
            $task = new Task();
            $result = $task->update_task($dataArray);

            if ($result){
                $errFlag = 0;
                $flagMsg = 'The <strong>Task</strong> has been successfully updated.';
            }else{
                $errFlag = 1;
                $flagMsg = 'There was a problem updating the <strong>Task</strong>. <br/>Please try again or contact the Administrator.';
            }

            unset($_SESSION['task_file']);
      }else{
        $errFlag = 1;
        $flagMsg = "The <strong>Title</strong> and <strong>Description</strong> are required to create a <strong>Task</strong>";
        unset($_SESSION['task_file']);
      } // end of all fields check


    } // end of isset

//----------------------- end of post back function //-----------------------------------------

//---Retrieve Task Information to Edit & Update -----------------------------------------------

$task = new Task();
$taskDetails = $task->get_task_by_id($_GET_URL_task_id);

$task_title = '';
$task_project = '';
$task_description = '';
$file_type = '';

foreach($taskDetails as $td){
  $task_title = FieldSanitizer::outClean($td['subject']);
  $task_project = FieldSanitizer::outClean($td['project_name']);
  $task_description = FieldSanitizer::outClean($td['description']);
  $file_type = $td['file_type'];
  $file = $td['file'];
}

  if ($file_type!=''){
        // check if file has been uploaded
         if ($file!=''){
            $_SESSION['task_file'] = $file;
         } // end of check for file upload
  }



//--- End of retrieval -----------------------------------------------------------------------


?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>My Task </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- Create a task //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-business-time"></i> Edit Task</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php



                        $code1 = mask($_GET_URL_user_id);
                        $create_task_link = "create_task.php?q=".$code1;
                        $tasks_list_link = "tasks.php?en=".$code1;

                    ?>
                    <a href="<?php echo $tasks_list_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-chevron-left"></i>&nbsp; Tasks List</a>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><!-- Task body //-->

                <?php
                    $form_action_link = 'edit_task.php?q='.mask($_GET_URL_user_id).'&t='.mask($_GET_URL_task_id);
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
                      <input type="text" id="title" name="title" class="form-control mb-3 " placeholder="Title" required maxlength="300"
                      value="<?php echo $task_title; ?>"
                      >

                      <!-- Project //-->
                      <label for="project" class="text-info font-weight-normal">Project</label>
                      <input type="text" id="project" name="project" class="form-control mb-3 " placeholder="Project" maxlength="300"
                      value="<?php echo $task_project; ?>"
                      >

                      <!-- Description //-->
                      <label for="description" class="text-info font-weight-normal">Description<span class='text-danger'>*</span></label>
                      <textarea id="description" rows="5" name="description" class="form-control mb-3 " placeholder="Description" required><?php echo $task_description; ?></textarea>


                      <!-- File Type  -->
                          <div>
                            <label for="file_upload" class="text-info font-weight-normal">File Upload Type<span class='text-danger'></span></label>
                          </div>
                          <!-- Default inline 1-->
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="file_upload_type_document" name="file_upload_type"  value="document" <?php if($file_type=='document'){echo 'checked'; } ?>  >
                            <label class="custom-control-label" for="file_upload_type_document">Document</label>
                          </div>

                          <!-- Default inline 2-->
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="file_upload_type_image" name="file_upload_type" value="image" <?php if($file_type=='image'){echo 'checked'; } ?> >
                            <label class="custom-control-label" for="file_upload_type_image">Image</label>
                          </div>

                          <!-- spinner //-->
                          <div id='spinner' style="display:none;">
                                <?php
                                    include("../../functions/BigBlueSpinner.php");
                                    echo "<span class='text-primary'>Uploading...</span>";
                                ?>
                          </div>
                          <!-- end of spinner //-->

                          <div id='activity_notifier'>
                              <?php
                                  if (isset($_SESSION['task_file'])){
                                       $msgblock = "<div class='py-3' id='myuploadedfile'><i class='fas fa-paperclip'></i> <span id='myuploadedfile'>".$_SESSION['task_file']."</span>";
                                       $msgblock .= "&nbsp;&nbsp;&nbsp;<span id='deletefile' title='Delete file' style='cursor:pointer'><i class='fas fa-times text-danger'></i></span>";
                                       $msgblock .= "</div>";

                                      echo $msgblock;
                                  }
                              ?>
                          </div>

                          <!-- file uploader //-->
                          <div class="md-form" id='file_uploader' style="display:none;">
                              <div class="file-field">
                                  <div class="btn btn-info btn-sm float-left">
                                    <span>Choose file</span>
                                    <input type="file" id="file">
                                  </div>
                                  <div class="file-path-wrapper">
                                    <input class="file-path validate"  type="text" placeholder="Upload your file">
                                  </div>
                              </div>
                         </div>
                      <!-- end of file uploader //-->

                      <div class='mt-3'>
                        <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Update</button>
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
<!-- <script src="../../lib/js/custom/tblData.js"></script> //-->
<script src="../../async/client/task/upload_file.js"></script>
