<?php
    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:cells.php");
    }else{
        $URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $URL_cell_id = $URL_cell_id[1];
    }

    $page_title = ' Add/Remove User';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");


    $cell = new Cell();
    $get_cell = $cell->get_cell_by_id($URL_cell_id);

    //get Cell information
    $cell_id = '';
    $cell_name = '';
    $cell_short_name = '';
    $cell_parent_id = '';
    $cell_parent_name = '';
    $cell_type_id = '';
    $cell_type_name = '';
    $cell_description = '';
    $cell_date_created = '';
    $cell_date_modified = '';

    foreach($get_cell as $row){
        $cell_id = $row['id'];
        $cell_name = $row['name'];
        $cell_short_name = $row['short_name'];
        $cell_parent_id = $row['parent'];
        $cell_type_id = $row['type'];

        // get cell parent
        $get_cell_parent = $cell->get_parent_cell_by_id($cell_parent_id);
        foreach($get_cell_parent as $gcp){
            $cell_parent_name = $gcp['name'];
        }

        // get cell type
        $get_cell_type = $cell->get_cell_type_by_id($cell_type_id);
        foreach($get_cell_type as $gct){
            $cell_type_name = $gct['name'];
        }

        // cell description
        $cell_description = FieldSanitizer::outClean($row['description']);

        // date created
        $date_created = new DateTime($row['date_created']);
        $date_created = $date_created->format('l jS F, Y');

        // date date_modified
        $date_modified = new DateTime($row['date_modified']);
        $date_modified = $date_modified->format('l jS F, Y');


    }//end of get_Cell as row





 ?>


    <!-- Cells body //-->
    <div class="container">

        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Cell - Add/Remove User </h3>
            </div>

        </div>
        <!-- end of page header //-->

        <!-- main page area //-->
        <div class="row">

              <!-- side bar //-->
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                  <?php
                  //side menu links
                        $cell_general_info_side_menu_link = "cell_view.php?en=".mask($URL_cell_id);
                        $cell_circles_side_menu_link = "cell_circles.php?en=".mask($URL_cell_id);
                        $cell_users_side_menu_link = "cell_users.php?en=".mask($URL_cell_id);
                        $cell_users_add_side_menu_link = "cell_users_add.php?en=".mask($URL_cell_id);
                        require_once("../../menu/cell-view-side-menu.php");
                   ?>
              </div>
              <!-- end of side bar //-->

              <!-- right work area //-->
              <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 mt-3">
                  <h4>Cell &raquo; <?php echo $cell_name; ?> </h4>
                    <br/>

                    <!-- notification pane //-->
                      <div id='success-add-notification-pane' style='display:none;' >
                            <?php  miniSuccessAlert('The User has been successfully added to the Cell.'); ?>
                      </div>
                      <div id='success-remove-notification-pane' style='display:none;' >
                            <?php  miniSuccessAlert('The User has been successfully removed from the Cell.'); ?>
                      </div>
                      <div id='error-add-notification-pane' style='display:none;' >
                            <?php  miniErrorAlert('An error occurred adding the User to the Cell.'); ?>
                      </div>
                      <div id='error-remove-notification-pane' style='display:none;' >
                            <?php  miniErrorAlert('An error occurred removing the User from the Cell.'); ?>
                      </div>
                    <!-- end of notification pane //-->


                    <!-- form to add user to cell //-->

                    <!-- search form //-->
                    <form class="border border-light p-4 " style="border-radius:5px;"
                      name="cell user add" >

                        <label for="textInput" class="text-info font-weight-normal">Search User</label>
                        <input type="text" id="user_file_no" name="user_file_no" class="form-control mb-0 " placeholder="Staff File No." required>
                        <button id="btn_fetch_user" class="btn btn-info btn-sm btn-rounded" type="button"> <i class="fas fa-search"></i> fetch User</button>

                    </form>
                    <!-- end of search //-->

                    <br/>
                    <!-- div to add user to cell //-->
                    <form class='border border-light p-4' id='output_pane' style="border-radius:5px;display:none;">
                          <div id='spinner' class='spinner text-center' style="display:none;">
                              <?php
                                    include("../../functions/BigBlueSpinner.php");
                               ?>
                          </div>

                          <div class="col-xs-2" id='avatar-pane'><!-- avatar //--></div>

                          <div class="col-xs-10"  id='info-pane'>
                              <div style='font-weight:bold;' id='fullname'></div>
                              <div id='position'></div>
                          </div>

                          <div class="col-xs-12" id="error-pane"></div>

                          <!-- Role //-->
                          <?php
                                $user = new StaffUser();
                                $user_roles = $user->get_user_roles();
                          ?>
                          <div class='mt-3 hidden' id='role-pane' style='display:none;'>

                              <label for="role" class="text-info font-weight-normal" id='lbl_role'  >Role</label>
                              <select class="browser-default custom-select mb-0" id="cbl_role" name="role"  >
                                  <option value="" selected=""></option>
                                  <?php
                                       foreach($user_roles as $row){
                                            $role_id = $row['id'];
                                            $role = $row['role'];
                                            echo "<option value='{$role_id}'>{$role}</option>";
                                       }
                                  ?>
                              </select>
                              <button id="btn_add_role" class="btn btn-info btn-sm btn-rounded" type="button"> <i class="fas fa-plus"></i> Add role</button>
                              <input type='hidden' id='role_array_list' value=""/>

                          </div>
                          <!-- end of Role //-->
                          <div  id='role-array' class='mt-4'></div>

                          <input type='hidden' id='selected_user_id' value=''/>
                          <input type='hidden' id='current_cell_id' value='<?php echo $cell_id; ?>'/>

                    </form>

                    <!-- //-->


                    <!-- Add Button column //-->
                    <div id='button-pane' class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 ml-2'></div>
                    <!-- end of add button column//-->







              </div>
              <!-- end of right work area //-->

        </div>
        <!-- end of main page area //-->







    </div><!-- end of container //-->
    <!-- end of Cells body //-->




    <script >
          var user_record_found = 'testing';
    </script>

     <br/><br/><br/><br/>
     <?php
        //footer.php
        require('../../includes/footer.php');
     ?>


     <script src="../../lib/js/custom/search_tbl.js"></script>
     <script src="../../lib/js/custom/tblData.js"></script>

     <!--<script src="../../async/client/cell/cell_users_add.js"></script> //-->

     <script src="../../async/client/cell/find_user_by_fileno.js"></script>
     <script src="../../async/client/cell/add_user_role.js"></script>
     <script src="../../async/client/cell/remove_user_role.js"></script>
     <script src="../../async/client/cell/cell_user_buttons.js"></script>
     <script src="../../async/client/cell/cell_user_button_actions.js"></script>
