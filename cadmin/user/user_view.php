<?php
    if (!isset($_GET['q']) || $_GET['q']==''){
        header("location:users.php");
    }else{
        $URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])) );
        $URL_user_id = $URL_user_id[1];
    }

    $page_title = 'User';



    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");

    $user = new StaffUser();
    $get_user = $user->get_user_by_id($URL_user_id);

    //get User information
    $user_id = '';
    $title = '';
    $first_name = '';
    $last_name = '';
    $other_names = '';
    $position = '';
    $avatar = '';
    $email = '';
    $role = '';
    $user_category = '';
    $dob = '';
    $designation = '';
    $grade_level = '';
    $phone = '';
    $about = '';
    $date_created = '';
    $date_modified = '';

      // Retrieve and assign data to variable
  foreach($get_user as $row){
      $user_id = $row['id'];
      $title = $row['title'];
      $first_name =$row['first_name'];
      $last_name = $row['last_name'];
      $other_names = $row['other_names'];
      $position = $row['position'];
      $avatar = $row['avatar'];
      $email = $row['email'];
      $role = $row['role'];
      $user_category = $row['user_category'];
      $dob = $row['dob'];
      $designation = $row['designation'];
      $grade_level = $row['grade_level'];
      $phone = $row['phone'];
      $about = $row['about'];
      $date_created = new DateTime($row['date_created']);
      $date_created = $date_created->format('l jS F, Y');
      $date_modified = new DateTime($row['date_modified']);
      $date_modified = $date_modified->format('l jS F, Y');
    }
      // end of retrieval


 ?>


    <!-- Cells body //-->
    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>User &raquo; <small><?php echo $title.' '.$first_name.' '.$last_name.' '.$other_names ?></small> </h3>
            </div>

        </div>
        <!-- end of page header //-->

        <!-- main page area //-->
        <div class="row">
              <!-- side bar //-->
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <?php
                        //side menu links
                        //$cell_general_info_side_menu_link = "cell_view.php?en=".mask($URL_cell_id);
                        //$cell_circles_side_menu_link = "cell_circles.php?en=".mask($URL_cell_id);
                        require_once("../../menu/user-view-side-menu.php");
                   ?>
              </div>
              <!-- end of side bar //-->
              <!-- center work area //-->
              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 mt-3 push-md-3-right">
                  <h4>Profile Info</h4>
                  <?php
                          // Button cell edit
                          $mask = mask($user_id);
                          $user_edit_link = "user_edit.php?en={$mask}";
                          $btn_user_edit = "<a href='{$user_edit_link}'
                                               class='btn btn-warning btn-sm btn-rounded color_scheme_opacity'
                                               title='Edit Cell Information'>
                                               <i class='far fa-edit'></i> Edit
                                               </a>";

                           // Button cell delete
                          $mask = mask($user_id);
                          $user_delete_link = "cell_delete.php?en={$mask}";
                          $btn_user_delete = "<a href='{$user_delete_link}'
                                               class='btn btn-danger btn-sm btn-rounded color_scheme_opacity'
                                               title='Delete Cell'>
                                               <i class='far fa-trash-alt'></i> Delete
                                               </a>";

                           // Button cell block
                          $mask = mask($user_id);
                          $user_block_link = "user_delete.php?en={$mask}";
                          $btn_user_block = "<a href='{$user_block_link}'
                                               class='btn btn-secondary btn-sm btn-rounded color_scheme_opacity'
                                               title='Delete Cell'>
                                               <i class='fas fa-ban'></i> Block
                                               </a>";

                          echo $btn_user_edit;
                          echo $btn_user_delete;
                          echo $btn_user_block;
                    ?>

                    <!-- full name //-->
                    <div class="row mt-4">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Full name</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo "{$title} {$first_name} {$last_name} {$other_names}"; ?> </div>
                    </div>

                    <!-- position //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold  ">Position</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo $position; ?> </div>
                    </div>

                    <!-- parent //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Email</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo $email; ?> </div>
                    </div>

                    <!-- type //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Role</div>
                        <div class="col-xs-12 col-md-9"><?php echo $role; ?> </div>
                    </div>

                    <!-- user category //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">User Category</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo nl2br($user_category); ?> </div>
                    </div>

                    <!-- grade level //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Grade level</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo nl2br($grade_level); ?> </div>
                    </div>


                    <!-- phone //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Phone</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo nl2br($phone); ?> </div>
                    </div>


                    <!-- About //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">About</div>
                        <div class="col-xs-12 col-md-9 font-weight-light"><?php echo nl2br($about); ?> </div>
                    </div>


                    <!-- date created //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Date Created</div>
                        <div class="col-xs-12 col-md-9"><?php echo $date_created; ?> </div>
                    </div>

                    <!-- date modified //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-3 font-weight-bold ">Date Updated</div>
                        <div class="col-xs-12 col-md-9"><?php echo $date_modified; ?> </div>
                    </div>


              </div>
              <!-- end of center column area //-->


              <!-- right column //-->
              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 pull-md-7-right text-center">
                    <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(1).jpg" alt="IMG of Avatars"
                      class="img-fluid z-depth-1-half rounded-circle">
              </div>

              <!-- end of right column //-->
        </div>
        <!-- end of main page area //-->







    </div><!-- end of container //-->
    <!-- end of Cells body //-->






    <br/><br/><br/><br/>
    <?php
        //footer.php
        require('../../includes/footer.php');
     ?>


     <script src="../../lib/js/custom/search_tbl.js"></script>
