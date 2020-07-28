<?php
    $page_title = 'Create Staff';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");


    // create cell object
    $user = new StaffUser();

    // create and initialize err params...
    $errFlag = 0;
    $errmsg = '';


    // PostBack
    if (isset($_POST['btnSubmit'])){
        $file_no = FieldSanitizer::inClean($_POST['file_no']);
        $title = FieldSanitizer::inClean($_POST['title']);
        $firstname = FieldSanitizer::inClean($_POST['firstname']);
        $lastname = FieldSanitizer::inClean($_POST['lastname']);
        $othernames = FieldSanitizer::inClean($_POST['othernames']);
        $email = FieldSanitizer::inClean($_POST['email']);
        $position = FieldSanitizer::inClean($_POST['position']);
        $role = 'staff';


        if ($file_no=='' || $title=='' || $firstname=='' || $lastname=='' ||  $email=='' || $position==''){
            $errFlag = 1;
            $errmsg = "All fields are required to be filled.";

        }else{

            // check if user already exist
            $user_exist = $user->user_exist($file_no)->rowCount();
            if (!$user_exist)
            {

                      //check if email already apc_exists
                      $email_exist = $user->email_exist($email)->rowCount();

                      if (!$email_exist){
                                // collect data into dataArray
                                $dataArray = array("file_no"=>$file_no, "title"=>$title, "firstname"=>$firstname,
                                                  "lastname"=>$lastname, "othernames"=>$othernames, "email"=>$email,
                                                  "position"=>$position, "role"=>$role);

                                $user_creator = $user->create_user($dataArray);

                                //check if user_creation was successful
                                if ($user_creator->rowCount()){
                                    $errFlag = 0;
                                    $errmsg = "The User <strong>{$title} {$firstname} {$lastname} {$othernames}</strong> has been successfully created.";
                                }else{
                                    $errFlag = 1;
                                    $errmsg = "An error occurred creating the User <strong>'".$name."'.</strong>";
                                }
                      }else{
                          $errFlag = 1;
                          $errmsg = "The Email <strong>{$email}</strong> has already been used for a User.";
                      }


            }else{
                  $errFlag = 1;
                  $errmsg = "The File No. <strong>'".$file_no."'</strong> already exist, and cannot be duplicated.";
            }




        }

    }

 ?>


    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Upload Staff</h3>
            </div>

        </div>
        <!-- end of page header //-->





        <div class="form mt-2 col-xs-12 col-sm-12 col-md-8 col-lg-8">

                  <!-- display feedback //-->
                  <?php
                        if (isset($_POST['btnSubmit'])){
                            if ($errFlag==1){
                                miniErrorAlert($errmsg);
                            }else{
                                $msg = $errmsg;
                                miniSuccessAlert($msg);
                            }
                        }


                   ?>

                  <!-- form to create cell //-->


                  <form class="md-form mt-5">
                      <div class="file-field">
                                <div class="btn btn-primary btn-sm float-left">
                                    <span>Choose file</span>
                                    <input type="file">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Upload a CSV file">

                                </div>
                      </div>
                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded disabled" type="submit"> Upload</button>
                      <small id="emailHelp" class="form-text text-muted mt-3">Template Fields (<strong>File No., Title, Firstname, Lastname, Othernames,
                                        Email, Position</strong>). No title, just data.</small>
                  </form>






                  <!-- end of form o create cell //-->


        </div><!-- end of form to create cell //-->

    </div><!-- end of container //-->

    <br/><br/>

 <?php
     //footer.php
     require('../../includes/footer.php');
  ?>
