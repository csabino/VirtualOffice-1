<?php

if (!isset($_GET['ut']) || $_GET['ut']==''){
    header("location:users.php");
}else{
    $GET_URL_param = explode("-",htmlspecialchars(strip_tags($_GET['ut'])) );
    $URL_param = $GET_URL_param[1];
    if ($URL_param=='s'){
        $URL_user_role = 'staff';
    }else{
        $URL_user_role = 'admin';
    }

}

    $page_title = "Create User";

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
        $role = $URL_user_role;


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
                <h3>Create <?php echo ucwords($URL_user_role); ?></h3>
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

                  <!-- form to create user //-->
                  <?php
                          //create user url link

                          $action_url = "create_user.php?ut=".mask($URL_param);
                          //echo $action_url;
                  ?>
                  <form class="border border-light p-4 " style="border-radius:5px;"
                    name="create_user" action="<?php echo $action_url; ?>"
                    method="post">

                      <label for="file_no" class="text-info font-weight-normal">File No.</label>
                      <input type="text" id="file_no" name="file_no" class="form-control mb-3 " placeholder="File No." required>


                      <label for="title" class="text-info font-weight-normal">Title</label>
                      <select class="browser-default custom-select mb-3" id="title" name="title" required>
                          <option value="" selected=""></option>
                          <option value="Prof.">Prof.</option>
                          <option value="Dr.">Dr.</option>
                          <option value="Mr.">Mr.</option>
                          <option value="Mrs.">Mrs.</option>
                          <option value="Ms">Ms</option>
                      </select>


                      <label for="firstname" class="text-info font-weight-normal">Firstname</label>
                      <input type="text" id="firstname" name="firstname" class="form-control mb-3 " placeholder="Firstname">

                      <label for="lastname" class="text-info font-weight-normal">Lastname</label>
                      <input type="text" id="lastname" name="lastname" class="form-control mb-3 " placeholder="Lastname">

                      <label for="othernames" class="text-info font-weight-normal">Othernames</label>
                      <input type="text" id="othernames" name="othernames" class="form-control mb-3 " placeholder="Othernames">

                      <label for="email" class="text-info font-weight-normal">Email</label>
                      <input type="email" id="email" name="email" class="form-control mb-3 " placeholder="Email">

                      <label for="position" class="text-info font-weight-normal">Position</label>
                      <input type="text" id="position" name="position" class="form-control mb-3 " placeholder="Position">


                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Create</button>
                  </form>
                  <!-- end of form o create cell //-->


        </div><!-- end of form to create cell //-->

    </div><!-- end of container //-->

    <br/><br/>

 <?php
     //footer.php
     require('../../includes/footer.php');
  ?>
