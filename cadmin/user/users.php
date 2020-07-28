<?php
    $page_title = 'Users';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");

    $user = new StaffUser();
    $get_users = $user->get_all_users();
    $number_of_users = $get_users->rowCount();

 ?>


    <!-- Cells body //-->
    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Users (<?php echo $number_of_users; ?>)</h3>
            </div>

        </div>
        <!-- end of page header //-->

        <div class="row">
            <!-- Create Cell Button //-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 text-right">
                  <a href="staff.php" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="fas fa-users" aria-hidden="true"></i> Staff</a>
                  <a href="admin.php" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="fas fa-users-cog" aria-hidden="true"></i> Admin</a>

                  <!--<a href="create_admin.php" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="fas fa-user-tie" aria-hidden="true"></i></i> Create Admin</a> //-->
            </div>
            <!-- end of Create Cell Button //-->
        </div>





        <!-- list of cells //-->
        <div  class="row" >


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

                  <table id="tblData" class="table table-responsive table-striped table-bordered table-sm font-weight-light" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="th-sm">SN
                      </th>
                      <th class="th-sm">File No.
                      </th>
                      <th class="th-sm">Full Names
                      </th>
                      <th class="th-sm">Email

                      </th>
                      <th class="th-sm">Position

                      </th>
                      <th class="th-sm">Action

                      </th>

                    </tr>
                  </thead>
                  <tbody id='tblBody'>
                      <?php
                          // get cell data

                          $counter = 1;
                          foreach($get_users as $row){
                              $user_id = $row['id'];
                              $file_no = $row['file_no'];
                              $user_title = $row['title'];
                              $user_firstname = $row['first_name'];
                              $user_lastname =$row['last_name'];
                              $user_othernames = $row['other_names'];
                              $user_email = $row['email'];
                              $user_position = $row['position'];


                              // generate action buttons
                              // Button cell view
                              $mask = mask($user_id);
                              $user_view_link = "user_view.php?q={$mask}";
                              //$explode_arr = explode("-",$cell_view_link);

                              $btn_user_view = "<a href='{$user_view_link}'
                                                   class='btn btn-secondary btn-sm btn-rounded color_scheme_opacity'
                                                   title='View User Information'>
                                                   <i class='fas fa-glasses' aria-hidden='true'></i>
                                                   </a>";

                             // Button cell edit
                             $mask = mask($user_id);
                             $user_edit_link = "user_edit.php?en={$mask}";
                             $btn_user_edit = "<a href='{$user_edit_link}'
                                                  class='btn btn-warning btn-sm btn-rounded color_scheme_opacity'
                                                  title='Edit User Information'>
                                                  <i class='far fa-edit'></i>
                                                  </a>";

                              // Button cell delete
                             $mask = mask($user_id);
                             $user_delete_link = "cell_delete.php?en={$mask}";
                             $btn_user_delete = "<a href='{$user_delete_link}'
                                                  class='btn btn-danger btn-sm btn-rounded color_scheme_opacity'
                                                  title='Delete User'>
                                                  <i class='far fa-trash-alt'></i>
                                                  </a>";



                              // display columns data
                              echo "<tr>";
                              echo "<td width='5%'>{$counter}.</td><td>{$file_no}</td>
                                    <td>{$user_title} {$user_firstname} {$user_lastname}</td>
                                    <td>{$user_email}</td><td>{$user_position}</td>
                                    <td align='center'>{$btn_user_view} {$btn_user_edit} {$btn_user_delete}</td>";
                              echo "</tr>";

                              $counter++;

                          }
                       ?>
                  </tbody>
                </table>


            </div>
        </div>
        <!-- end of list of cells //-->

    </div>
    <!-- end of Cells body //-->






    <br/><br/><br/><br/>
    <?php
        //footer.php
        require('../../includes/footer.php');
     ?>


    <script src="../../lib/js/custom/tblData.js"></script>
