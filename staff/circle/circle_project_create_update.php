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

//------------------------------------------------------------------------------------------------------------------------
// isPostback
  $errFlag = 0;
  $flagMsg = '';

  if (isset($_POST['btnSubmit'])){
        $message = FieldSanitizer::inClean($_POST['message']);
        $file = '';

        // check if file upload type is unchecked
        if (!isset($_POST['file_upload_type'])){
            $file_upload_type = '';
        }else{
            $file_upload_type = $_POST['file_upload_type'];
            // check if file has been uploaded
            if (isset($_SESSION['project_update_file'])){
                $file = $_SESSION['project_update_file'];
            } // end of check for file upload
        }


        // check if all required fields are filled
        if ($message!=''){
            // create data array and populate data
            $dataArray = array("cell"=>$_GET_URL_cell_id,"sender"=>$_GET_URL_user_id,
                         "project"=>$_GET_URL_project_id,"message"=>$message,
                         "source"=>"project", "file_upload_type"=>$file_upload_type,
                         "file"=>$file);

            // call class and methods
            $project = new Project();
            $result = $project->new_projects_update($dataArray);

            if ($result){
                $errFlag = 0;
                $flagMsg = 'The <strong>Update</strong> has been successfully created and posted.';
            }else{
                $errFlag = 1;
                $flagMsg = 'There was a problem creating the <strong>Update</strong>. <br/>Please try again or contact the Administrator.';
            }

        }else{
            $errFlag = 1;
            $flagMsg = "The <strong>Message</strong> is required to create an <strong>Update</strong>";
        }// end of if statement

  } // end of check file upload type



//------------------------------------------------------------------------------------------------------------------------




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



      <!-- project update title and back button //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-business-time"></i> Create Project Update</big>
                    <?php
                          $project = new Project();
                          $get_project = $project->get_project_by_id($_GET_URL_project_id);
                          $project_title = '';
                          foreach($get_project as $gp){
                              $project_title = $gp['project_title'];
                          }
                          echo '<br/>'.$project_title;

                    ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php
                        $code1 = mask($_GET_URL_cell_id);
                        $code2 = mask($_GET_URL_user_id);
                        $code3 = mask($_GET_URL_project_id);
                        $post_project_updates_link = "circle_project_updates.php?q=".$code1."&us=".$code2."&pid=".$code3;

                    ?>
                    <a href="<?php echo $post_project_updates_link; ?>" class="btn btn-sm btn-success btn-rounded"> <i class="fas fa-chevron-left"></i> &nbsp;Project Updates</a>
              </div>
      </div>
      <!-- end of project update title and back button //-->


      <!-- post form //-->
      <div class="row mt-5">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                    $form_action_link = 'circle_project_create_update.php?q='.mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id)."&pid=".mask($_GET_URL_project_id);
                ?>
                <form class="border border-light p-4 " style="border-radius:5px;"
                  name="create_project_update" action="<?php echo htmlspecialchars($form_action_link); ?>"
                  method="post">

                    <!-- Postback feedback //-->
                      <?php
                          if (isset($_POST['btnSubmit'])){
                              if ($errFlag){
                                  miniErrorAlert($flagMsg);
                              }else{
                                  miniSuccessAlert($flagMsg);
                                  unset($_SESSION['project_update_file']);
                              }
                          }
                      ?>

                    <!-- End of postback feedback //-->


                    <!-- Message //-->
                    <label for="message" class="text-info font-weight-normal">Message<span class='text-danger'>*</span></label>
                    <textarea id="message" rows="5" name="message" class="form-control mb-3 " placeholder="Message" required></textarea>

                    <!-- File Type  -->
                    <div>
                      <label for="file_upload" class="text-info font-weight-normal">File Upload Type<span class='text-danger'></span></label>
                    </div>
                    <!-- Default inline 1-->
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" id="file_upload_type_document" name="file_upload_type"  value="document" <?php if(isset($_POST['btnSubmit'])){ if(!$errFlag){echo "unchecked";} } ?> >
                      <label class="custom-control-label" for="file_upload_type_document">Document</label>
                    </div>

                    <!-- Default inline 2-->
                    <div class="custom-control custom-radio custom-control-inline">
                      <input type="radio" class="custom-control-input" id="file_upload_type_image" name="file_upload_type" value="image"  <?php if(isset($_POST['btnSubmit'])){ if(!$errFlag){echo "unchecked";} } ?> >
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
                            if (isset($_SESSION['project_update_file'])){
                                 $msgblock = "<div class='py-3' id='myuploadedfile_div'><i class='fas fa-paperclip'></i> <span id='myuploadedfile'>".$_SESSION['project_update_file']."</span>";
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
                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Post Update</button>
                    </div>

                </form>
          </div>


      </div>




      <!-- end of post form //-->




      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

 <script src="../../lib/js/custom/tblData.js"></script>
 <script src="../../async/client/project/upload_file.js"></script>
