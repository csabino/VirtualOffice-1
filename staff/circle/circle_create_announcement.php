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





    $page_title = 'Work Circle | General Room';

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


//-----------------------------------------------------------------------------------------------------------------
// Postback function

  $errFlag = 0;
  $flagMsg = '';

  if (isset($_POST['btnSubmit'])){

      $title = FieldSanitizer::inClean($_POST['title']);
      $message = FieldSanitizer::inClean($_POST['message']);
      $file = '';

      // check if file upload type is checked
      if (!isset($_POST['file_upload_type'])){

          $file_upload_type = '';

      }else{

         $file_upload_type = $_POST['file_upload_type'];
           // check if file has been uploaded
           if (isset($_SESSION['announcement_file'])){
              $file = $_SESSION['announcement_file'];
           } // end of check for file upload

      } // end of check file upload type



      // check if all require fields are filled
      if ($title!='' && $message!=''){
          // create data array and populate data
          $dataArray = array("cell"=>$_GET_URL_cell_id, "author"=>$_GET_URL_user_id,
                        "title"=>$title, "message"=>$message,"file_upload_type"=>$file_upload_type,
                        "file"=>$file);


          // call class and methods
          $announcement = new Announcement();
          $result = $announcement->new_announcement($dataArray);

          if ($result){
              $errFlag = 0;
              $flagMsg = 'The <strong>Announcement</strong> has been successfully created and posted.';
          }else{
              $errFlag = 1;
              $flagMsg = 'There was a problem creating the <strong>Announcement</strong>. <br/>Please try again or contact the Administrator.';
          }

      }else{
              $errFlag = 1;
              $flagMsg = "The <strong>Title</strong> and <strong>Message</strong> are required to create an <strong>Announcement</strong>";
      }






  }// end of postback



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



      <!-- sub menu  //-->
      <div class="row border-bottom">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 mb-4 font-weight-bold' >
                  <?php  echo $circle_name.$circle_short_name; ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab' >
                  <?php
                        $general_link = "circle_general_room.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>General Room</a>";
                  ?>

            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active'>
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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 sub_menu_tab'>
                  <?php
                        $general_link = "circle_projects.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Projects</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 sub_menu_tab'>
                  <?php
                        $general_link = "circle_files.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Files</a>";
                  ?>
            </div>

      </div>
      <!-- end of sub menu //-->


      <!-- main body area //-->
      <div class="row mt-5">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-info font-weight-bold" >
                Compose Announcement
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                    $form_action_link = 'circle_create_announcement.php?en='.mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                ?>
                <form class="border border-light p-4 " style="border-radius:5px;"
                  name="compose announcement" action="<?php echo htmlspecialchars($form_action_link); ?>"
                  method="post">

                    <!-- Postback feedback //-->
                      <?php
                          if (isset($_POST['btnSubmit'])){
                              if ($errFlag){
                                  miniErrorAlert($flagMsg);
                              }else{
                                  miniSuccessAlert($flagMsg);
                                  unset($_SESSION['announcement_file']);
                              }
                          }
                      ?>

                    <!-- End of postback feedback //-->

                    <!-- Title //-->
                    <label for="title" class="text-info font-weight-normal">Title<span class='text-danger'>*</span></label>
                    <input type="text" id="title" name="title" class="form-control mb-3 " placeholder="Title" required>

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
                      <input type="radio" class="custom-control-input" id="file_upload_type_image" name="file_upload_type" value="image">
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
                            if (isset($_SESSION['announcement_file'])){
                                 $msgblock = "<div class='py-3' id='myuploadedfile_div'><i class='fas fa-paperclip'></i> <span id='myuploadedfile'>".$_SESSION['announcement_file']."</span>";
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
                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Send</button>
                    </div>

                </form>
          </div>


      </div>
      <!-- end of main body area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

<script src="../../async/client/announcement/upload_file.js"></script>
