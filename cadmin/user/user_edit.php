<?php

    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:users.php");
    }else{
        $GET_URL_param = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $URL_user_id =   $GET_URL_param[1];

    }
    $page_title = 'Edit User';

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
        $user_category = FieldSanitizer::inClean($_POST['user_category']);
        $DOB = FieldSanitizer::inClean($_POST['dob']);
        $grade_level = FieldSanitizer::inClean($_POST['grade_level']);
        $phone = FieldSanitizer::inClean($_POST['phone']);
        $about = FieldSanitizer::inClean($_POST['about']);



        if ($file_no=='' || $title=='' || $firstname=='' || $lastname=='' ||  $email=='' || $position==''){
            $errFlag = 1;
            $errmsg = "Please fill the required fields to update the profile...";

        }else{

            // check if the file no has been used for another user
            $is_fileno_used_other_than_this_user = $user->is_fileno_used_other_than_this_user($URL_user_id , $file_no)->rowCount();
            if (!$is_fileno_used_other_than_this_user)
            {// file_no is not in use by another use


                      //check if email already apc_exists
                      $is_email_used_other_than_this_user = $user->is_email_used_other_than_this_user($URL_user_id, $email)->rowCount();
                      if (!$is_email_used_other_than_this_user){
                          // email is not being used by another user
                          // perform update
                          // collect data into dataArray
                            $dataArray = array("user_id"=>$URL_user_id, "file_no"=>$file_no, "title"=>$title, "firstname"=>$firstname,
                                               "lastname"=>$lastname, "othernames"=>$othernames, "email"=>$email, "position"=>$position,
                                               "user_category"=>$user_category, "dob"=>$DOB, "grade_level"=>$grade_level, "phone"=>$phone, "about"=>$about);

                            $result_update = $user->update_user($dataArray);
                            if ($result_update){
                                $errFlag = 0;
                                $errmsg = "The record has been successfully updated.";
                            }else{
                                $errFlag = 1;
                                $errmsg = "An error occurred updating the record.";
                            }


                      }else{
                          // email is being used by another email
                          $errFlag = 1;
                          $errmsg = "The Email <strong>{$email}</strong> is being used by another User.";
                      }

            }else{
                  // file_no is in use by another user
                  $errFlag = 1;
                  $errmsg = "The File No. <strong>'".$file_no."'</strong> is in use by another user, and cannot be duplicated.";
            }




        }

    }



    // Retrieve the user Information
    $get_user = $user->get_user_by_id($URL_user_id);
    $file_no = '';
    $title = '';
    $first_name = '';
    $last_name = '';
    $other_names = '';
    $email = '';
    $position = '';
    $user_category = '';
    $dob = '';
    $grade_level = '';
    $phone = '';
    $about = '';
    foreach($get_user as $row){
        $file_no = $row['file_no'];
        $title = $row['title'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $other_names = $row['other_names'];
        $email = $row['email'];
        $role = $row['role'];
        $position = $row['position'];
        $user_category = $row['user_category'];
        $dob = $row['dob'];
        $grade_level = $row['grade_level'];
        $phone = $row['phone'];
        $about = $row['about'];
    }
 ?>


    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Edit <?php echo ucwords($role); ?></h3>
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
                  <?php
                      $form_action_link = "user_edit.php?en=".mask($URL_user_id);
                      //echo $form_action_link;
                   ?>
                  <form class="border border-light p-4 " style="border-radius:5px;"
                    name="edit user" action="<?php echo htmlspecialchars($form_action_link); ?>"
                    method="post">

                      <!-- file no //-->
                      <label for="file_no" class="text-info font-weight-normal">File No.<span class='text-danger'>*</span></label>
                      <input type="text" id="file_no" name="file_no" class="form-control mb-3 " placeholder="File No." value="<?php echo $file_no; ?>" required>


                      <!-- title //-->
                      <label for="title" class="text-info font-weight-normal">Title <span class='text-danger'>*</span></label>
                      <select class="browser-default custom-select mb-3" id="title" name="title" required>
                          <option value="" ></option>
                          <option value="Prof." <?php echo ($title=='Prof.')? 'selected': ''; ?> >Prof.</option>
                          <option value="Dr."   <?php echo ($title=='Dr.')? 'selected': ''; ?>   >Dr.</option>
                          <option value="Mr."   <?php echo ($title=='Mr.')? 'selected': ''; ?> >Mr.</option>
                          <option value="Mrs."  <?php echo ($title=='Mrs.')? 'selected': ''; ?> >Mrs.</option>
                          <option value="Ms"    <?php echo ($title=='Ms.')? 'selected': ''; ?>>Ms</option>
                      </select>

                      <!-- firstname //-->
                      <label for="firstname" class="text-info font-weight-normal">Firstname <span class='text-danger'>*</span></label>
                      <input type="text" id="firstname" name="firstname" class="form-control mb-3 " placeholder="Firstname" value="<?php echo $first_name; ?>"  >

                      <!-- Last name //-->
                      <label for="lastname" class="text-info font-weight-normal">Lastname <span class='text-danger'>*</span></label>
                      <input type="text" id="lastname" name="lastname" class="form-control mb-3 " placeholder="Lastname" value="<?php echo $last_name?>" >

                      <!-- Othernames //-->
                      <label for="othernames" class="text-info font-weight-normal">Othernames</label>
                      <input type="text" id="othernames" name="othernames" class="form-control mb-3 " placeholder="Othernames" value="<?php echo $other_names; ?>" >

                      <!-- Email //-->
                      <label for="email" class="text-info font-weight-normal">Email <span class='text-danger'>*</span></label>
                      <input type="email" id="email" name="email" class="form-control mb-3 " placeholder="Email" value="<?php echo $email; ?>" >

                      <!-- position //-->
                      <label for="position" class="text-info font-weight-normal">Position <span class='text-danger'>*</span></label>
                      <input type="text" id="position" name="position" class="form-control mb-3 " placeholder="Position" value="<?php echo $position; ?>" >

                      <!-- User Category //-->
                      <label for="user_category" class="text-info font-weight-normal">User Category</label>
                      <select class="browser-default custom-select mb-3" id="user_category" name="user_category" required>
                          <option value="" ></option>
                          <option value="Teaching" <?php echo ($user_category=='Teaching')? 'selected': ''; ?> > Teaching </option>
                          <option value="Non-teaching"   <?php echo ($user_category=='Non-teaching')? 'selected': ''; ?>   > Non-teaching </option>
                      </select>

                      <!-- DOB //-->
                      <label for="user_category" class="text-info font-weight-normal">DOB</label>
                      <!--<div class="mb-3 md-form"> //-->
                        <input type="text" name="dob" id="date" class="form-control datepicker mb-3" value="<?php echo $dob; ?>" />
                            <!-- <label for="date">Date</label> //-->
                        <div class="invalid-feedback">Please select a valid date.</div>
                      <!-- </div> //-->

                      <!-- Grade level //-->
                      <label for="grade_level" class="text-info font-weight-normal">Grade Level</label>
                      <input type="text" id="grade_level" name="grade_level" class="form-control mb-3 " placeholder="Grade Level" value="<?php echo $grade_level; ?>" >

                      <!-- Phone //-->
                      <label for="phone" class="text-info font-weight-normal">Phone</label>
                      <input type="text" id="phone" name="phone" class="form-control mb-3 " placeholder="Phone" value="<?php echo $phone; ?>" >


                      <!-- About //-->
                      <label for="about" class="text-info font-weight-normal">About</label>
                      <textarea id="about" rows="10" name="about" class="form-control mb-3 " placeholder="About User" ><?php echo $about; ?></textarea>



                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Update</button>
                  </form>
                  <!-- end of form o create cell //-->


        </div><!-- end of form to create cell //-->

    </div><!-- end of container //-->

    <br/><br/>

 <?php
     //footer.php
     require('../../includes/footer.php');
  ?>



  <script>
      (function() {
      'use strict';
      window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
      if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
      }
      form.classList.add('was-validated');
      }, false);
      });
      }, false);
      })();

      $(document).ready(function() {
      $('.datepicker').pickadate();
      $('.datepicker').removeAttr('readonly');
      });
  </script>
