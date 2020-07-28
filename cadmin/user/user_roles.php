<?php
    $page_title = 'User Roles';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");

    $user = new StaffUser();
    $get_roles = $user->get_user_roles();
    $number_of_roles = $get_roles->rowCount();

 ?>


    <!-- Cells body //-->
    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Roles (<?php echo $number_of_roles; ?>)</h3>
            </div>

        </div>
        <!-- end of page header //-->

        <div class="row">
            <!-- Create Cell Button //-->
            <?php
                  $create_user_role_link = "create_user_role.php?ut=".mask("s");
             ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 text-right">
                  <a href="<?php echo $create_user_role_link; ?>" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="far fa-user" aria-hidden="true"></i> Create Role</a>

            </div>
            <!-- end of Create Cell Button //-->
        </div>





        <!-- list of cells //-->
        <div  class="row" >


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

                  <table id="tblData" class="table table-striped table-bordered table-sm font-weight-light" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="th-sm">SN

                      </th>
                      <th class="th-sm">Role

                      </th>
                      <th class="th-sm">Authority

                      </th>
                      <th class="th-sm">Description

                      </th>
                      <th class="th-sm">Action

                      </th>

                    </tr>
                  </thead>
                  <tbody id='tblBody'>
                      <?php
                          // get cell data

                          $counter = 1;
                          foreach($get_roles as $row){
                              $role_id = $row['id'];
                              $role = $row['role'];
                              $authority = $row['authority'];

                              $authority_status = ($authority==1) ? 'checked': 'unchecked';

                              $description = $row['description'];

                              $role_date_created = $row['date_created'];
                              $role_date_modified = $row['date_modified'];


                              // generate action buttons
                              // Button cell view
                              $mask = mask($role_id);
                              $user_role_view_link = "user_role_view.php?en={$mask}";
                              //$explode_arr = explode("-",$cell_view_link);

                              $btn_user_role_view = "<a href='{$user_role_view_link}'
                                                   class='btn btn-secondary btn-sm btn-rounded color_scheme_opacity'
                                                   title='View Role Information'>
                                                   <i class='fas fa-glasses' aria-hidden='true'></i>
                                                   </a>";

                             // Button cell edit
                             $mask = mask($role_id);
                             $user_role_edit_link = "user_role_edit.php?en={$mask}";
                             $btn_user_role_edit = "<a href='{$user_role_edit_link}'
                                                  class='btn btn-warning btn-sm btn-rounded color_scheme_opacity'
                                                  title='Edit Role Information'>
                                                  <i class='far fa-edit'></i>
                                                  </a>";

                              // Button cell delete
                             $mask = mask($role_id);
                             $user_role_delete_link = "user_role_delete.php?en={$mask}";
                             $btn_user_role_delete = "<a href='{$user_role_delete_link}'
                                                  class='btn btn-danger btn-sm btn-rounded color_scheme_opacity'
                                                  title='Delete Role'>
                                                  <i class='far fa-trash-alt'></i>
                                                  </a>";



                              // display columns data
                              echo "<tr>";
                              echo "<td width='5%'>{$counter}.</td><td>{$role}</td>
                              <th scope='row'>
                                    <!-- Authority checkbox -->
                                    <div class='custom-control custom-checkbox text-center'>
                                      <input type='checkbox' class='custom-control-input' id='authority' disabled {$authority_status}>
                                      <label class='custom-control-label text-center' for='authority'> &nbsp;</label>
                                    </div>
                              </th>
                              <td>{$description}</td>
                                    <td align='center'>{$btn_user_role_view} {$btn_user_role_edit} {$btn_user_role_delete}</td>";
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







    <?php
        //footer.php
        require('../../includes/footer.php');
     ?>


    <script src="../../lib/js/custom/tblData.js"></script>
