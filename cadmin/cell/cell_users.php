<?php
    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:cells.php");
    }else{
        $URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $URL_cell_id = $URL_cell_id[1];
    }

    $page_title = 'WorkPlace Cell - Users';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");

    $user = new StaffUser();
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
                <h3>Cell - Users </h3>
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
                        $cell_users_add_side_menu_link = "cell_users_add_remove.php?en=".mask($URL_cell_id);
                        require_once("../../menu/cell-view-side-menu.php");
                   ?>
              </div>
              <!-- end of side bar //-->

              <!-- right work area //-->
              <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 mt-3">
                  <h4>Cell &raquo; <?php echo $cell_name; ?> </h4>
                    <br/>

                    <table id="tblData" class="table table-responsive table-striped table-bordered table-sm font-weight-light" cellspacing="0" width="100%">
                    <thead width="100%">
                      <tr>
                        <th class="th-sm">SN
                        </th>
                        <th class="th-sm">File No.
                        </th>
                        <th class="th-sm">Full Name
                        </th>
                        <th class="th-sm">Avatar
                        </th>
                        <th class="th-sm">Position
                        </th>
                        <th class="th-sm">Role
                        </th>
                        <th class="th-sm">Action
                        </th>
                      </tr>
                    </thead>
                    <tbody id='tblBody'>
                        <?php
                            // get cell data

                            $get_cell_users = $cell->cell_users($URL_cell_id);


                            $counter = 1;
                            foreach($get_cell_users as $row){
                                $cell_user_id = $row['cell_user_id'];
                                $cell_id = $row['cell_id'];
                                $user_id = $row['user_id'];
                                $file_no = $row['file_no'];
                                $user_title = $row['title'];
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $other_names = $row['other_names'];
                                $user_position = $row['position'];
                                $avatar = $row['avatar'];
                                $user_roles = $row['roles'];

                                // get roles title from role array ($user_roles)
                                if ($user_roles!=''){
                                      $user_roles_info = $user->get_user_roles_by_array_id($user_roles);
                                    
                                        if ($user_roles_info->rowCount()){
                                            $user_roles = '';
                                            foreach($user_roles_info as $urinfo){
                                                $user_roles .= "<li>".$urinfo['role']."</li>";
                                            }
                                        }
                                        $user_roles = "{$user_roles}";
                                }

                                //end of get roles

                                $avatar = ($avatar=='')? '../../images/avatars/avatar-2.jpg' : '../../images/avatars/'.$avatar;

                                $avatar = "<img src='{$avatar}' class='img-fluid rounded-circle z-depth-2'
                                  alt='My Avatar' width='80px' >";


                                // generate action buttons
                                // Button cell view
                                $mask = mask($user_id);
                                $user_view_link = "user_view.php?q={$mask}";
                                //$explode_arr = explode("-",$cell_view_link);

                                $btn_remove_user = "<button
                                                     class='btn btn-secondary btn-sm btn-rounded color_scheme_opacity'
                                                     title='Remove User'>
                                                     <i class='fas fa-glasses' aria-hidden='true'></i> Remove
                                                     </button>";



                                echo "<tr width='100%'>";
                                echo "<td width='1%'>{$counter}.</td><td>{$file_no}</td>
                                      <td><a title='View Staff Profile' href='../user/{$user_view_link}'>{$user_title} {$first_name} {$last_name}</a></td>
                                      <td class='text-center'>{$avatar}</td><td>{$user_position}</td>
                                      <td align='center'>{$user_roles}</td><td align='center'>{$btn_remove_user}</td>";
                                echo "</tr>";

                                  $counter++;



                            }
                         ?>
                    </tbody>
                  </table>















              </div>
              <!-- end of right work area //-->

        </div>
        <!-- end of main page area //-->







    </div><!-- end of container //-->
    <!-- end of Cells body //-->







    <?php
        //footer.php
        require('../../includes/footer.php');
     ?>


     <script src="../../lib/js/custom/search_tbl.js"></script>
     <script src="../../lib/js/custom/tblData.js"></script>
