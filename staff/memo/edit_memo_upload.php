<?php

  // get user eligibility
  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

  $_GET_URL_memo_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
  $_GET_URL_memo_id = $_GET_URL_memo_id[1];

    $page_title = 'Edit Memo';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");


// -----------------------------------------------------------------------------
// ---- Postback functions

    $errFlag = 0;
    $flagMsg = '';
    if (isset($_POST['btnSubmit'])){
        $title = FieldSanitizer::inClean($_POST['title']);
        $remark = FieldSanitizer::inClean($_POST['remark']);
        $file = '';
        $file_upload_type = '';

        // check if file upload type is checked
        if (!isset($_POST['file_upload_type'])){

            $file_upload_type = '';

        }else{

           $file_upload_type = $_POST['file_upload_type'];
             // check if file has been uploaded
             if (isset($_SESSION['memo_file'])){
                $file = $_SESSION['memo_file'];
             } // end of check for file upload

        } // end of check file upload type

        //echo $file;


      // Check if all fields are filled in
      if ($title!='' && $remark!='' && $file!=''){
            // create data array and populate data
            $memo_type = "upload";
            $dataArray = array("memo_id"=>$_GET_URL_memo_id,"author"=>$_GET_URL_user_id,"title"=>$title,
                          "remark"=>$remark, "file_upload_type"=>$file_upload_type,"file"=>$file,
                          "memo_type"=>$memo_type);

            // call class and method
            $memo = new Memo();
            $result = $memo->update_upload_memo($dataArray);

            // get the uploaded file -------------------------------------------
            $get_memo = $memo->get_memo_by_id($_GET_URL_memo_id);
            foreach($get_memo as $row){
              $file = FieldSanitizer::outClean($row['file']);
              if ($file!=''){
                $_SESSION['memo_file'] = $file;
              }
            }
            // -----------------------------------------------------------------


            if ($result){
                $errFlag = 0;
                $flagMsg = 'The <strong>Memo</strong> has been successfully updated.';
            }else{
                $errFlag = 1;
                $flagMsg = 'There was a problem updating the <strong>Memo</strong>. <br/>Please try again or contact the Administrator.';
            }


      }else{
        $errFlag = 1;
        $flagMsg = "The <strong>Title</strong> and <strong>File</strong> are required to create a <strong>Task</strong>";
      } // end of all fields check


    } // end of isset



//----------------------------------------------------------------------------------------
// Retrieve memo information

$memo = new Memo();
$get_memo = $memo->get_memo_by_id($_GET_URL_memo_id);
$memo_title = '';
$memo_remark = '';
$file = '';
foreach($get_memo as $row){
  $memo_title = FieldSanitizer::outClean($row['subject']);
  $memo_remark = FieldSanitizer::outClean($row['remark']);
  $file_type = FieldSanitizer::outClean($row['file_type']);
  $file = FieldSanitizer::outClean($row['file']);

  if ($file!=''){
    $_SESSION['memo_file'] = $file;
  }
  echo "am here again<br/>";
  echo $_SESSION['memo_file'];
  echo "<br/>";
  echo $_SESSION['memo_file'];




}




//---------------------------------------------------------------------------------------





?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Upload Memo </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- Create a task //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="far fa-newspaper"></i> Edit Memo</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php



                        $code1 = mask($_GET_URL_user_id);
                        $create_task_link = "create_task.php?q=".$code1;
                        $memo_list_link = "memos.php?en=".$code1;

                    ?>
                    <a href="<?php echo $memo_list_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-chevron-left"></i>&nbsp; Memo List</a>
              </div>



              <!-- main body area //-->


                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php
                            $form_action_link = 'edit_memo_upload.php?q='.mask($_GET_URL_user_id).'&m='.mask($_GET_URL_memo_id);
                        ?>
                        <form class="border border-light p-4 " style="border-radius:5px;"
                          name="upload memo" action="<?php echo htmlspecialchars($form_action_link); ?>"
                          method="post">

                            <!-- Postback feedback //-->
                              <?php
                                  if (isset($_POST['btnSubmit'])){
                                      if ($errFlag){
                                          miniErrorAlert($flagMsg);
                                      }else{
                                          miniSuccessAlert($flagMsg);
                                          unset($_SESSION['memo_file']);
                                      }
                                  }
                              ?>

                            <!-- End of postback feedback //-->

                            <!-- Title //-->
                            <label for="title" class="text-info font-weight-normal">Title<span class='text-danger'>*</span></label>
                            <input type="text" id="title" name="title" class="form-control mb-3 " placeholder="Title" value="<?php echo $memo_title; ?>" required>

                            <!-- File Type  -->
                            <div>
                              <label for="file_upload" class="text-info font-weight-normal mt-2">File Upload Type<span class='text-danger'></span></label>
                            </div>
                            <!-- Default inline 1-->
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input" id="file_upload_type_document" name="file_upload_type"  value="document"
                               <?php if($file_type=='document'){echo 'checked'; } ?>
                               <?php if(isset($_POST['btnSubmit'])){ if(!$errFlag){echo "unchecked";} } ?> >
                              <label class="custom-control-label" for="file_upload_type_document">Document</label>
                            </div>

                            <!-- Default inline 2-->
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" class="custom-control-input" id="file_upload_type_image" name="file_upload_type" value="image"
                               <?php if($file_type=='image'){echo 'checked'; } ?>
                              >
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
                                    if (isset($_SESSION['memo_file'])){
                                         $msgblock = "<div class='py-3' id='myuploadedfile_div'><i class='fas fa-paperclip'></i> <span id='myuploadedfile'>".$_SESSION['memo_file']."</span>";
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


                            <!-- Remark //-->
                            <label for="remark" class="text-info font-weight-normal mt-4">Remark<span class='text-danger'>*</span></label>
                            <textarea id="remark" rows="5" name="remark" class="form-control mb-3 " placeholder="Remark" required><?php echo $memo_remark; ?></textarea>



                            <div class='mt-3'>
                              <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Update</button>
                            </div>

                        </form>
                  </div>



              <!-- end of main body area //-->



      </div>


      <!-- end of list of tasks //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
<script src="../../async/client/memo/upload_file.js"></script>
