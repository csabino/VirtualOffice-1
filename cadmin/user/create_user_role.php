<?php

    $page_title = "Create User Role";
    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");


    // create cell object
    $user_role = new StaffUser();

    // create and initialize err params...
    $errFlag = 0;
    $errmsg = '';


    // PostBack
    if (isset($_POST['btnSubmit'])){
        $role = FieldSanitizer::inClean($_POST['role']);
        if (isset($_POST['authority'])){
              $authority = 1;
        }else{
              $authority = '';
        }
        $description = FieldSanitizer::inClean($_POST['description']);


        if ($role==''){
            $errFlag = 1;
            $errmsg = "Role is required to proceed.";

        }else{

                  // check if user role already exist
                  $role_exist = $user_role->user_role_exist($role)->rowCount();

                  if (!$role_exist)
                  {
                    // role does not exist
                      $dataArray = array("role"=>$role, "authority"=>$authority, "description"=>$description);
                      $role_creator = $user_role->create_user_role($dataArray);

                      if ($role_creator){
                          $errFlag = 0;
                          $errmsg = "The role <strong>'{$role}'</strong> has been successfully created.";
                      }else{
                          $errFlag = 1;
                          $errmsg = "An error has occurred creating the role '{$role}'";
                      }


                  }else{
                        $errFlag = 1;
                        $errmsg = "The File No. <strong>'".$file_no."'</strong> already exist, and cannot be duplicated.";
                  }
                  // end of check if role already exists




        }

    }

 ?>


    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Create User Role</h3>
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
                  <form class="border border-light p-4 " style="border-radius:5px;"
                    name="create_user_role" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    method="post">

                      <label for="role" class="text-info font-weight-normal">Role</label>
                      <input type="text" id="role" name="role" class="form-control mb-3 " placeholder="Role" required>


                      <label for="authority" class="text-info font-weight-normal">Authority</label>
                      <!-- Default unchecked -->
                      <div class="custom-control custom-checkbox mb-3">
                          <input type="checkbox" class="custom-control-input" name="authority" id="authority">
                          <label class="custom-control-label" for="authority">  Have coordinating and supervisory privileges</label>
                      </div>



                      <label for="description" class="text-info font-weight-normal">Description</label>
                      <textarea type="text" id="description" name="description" class="form-control mb-3"></textarea>


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
