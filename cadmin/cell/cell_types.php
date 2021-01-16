 <?php
    $page_title = 'Cell Types';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");

    $cell = new Cell();
    $get_types = $cell->get_cell_types();
    $number_of_types = $get_types->rowCount();

 ?>


    <!-- Cells body //-->
    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Cell Types (<?php echo $number_of_types; ?>)</h3>
            </div>

        </div>
        <!-- end of page header //-->


        <!-- add Cell and Search row //-->
        <div class="row">
            <!-- Create Cell Type Button //-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1 text-right">
                  <a href="create_cell.php" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="fas fa-plus" aria-hidden="true"></i> Create Type</a>

            </div>
            <!-- end of Create Cell Button //-->
        </div>
        <!-- end of add cell and search for row //-->




        <!-- list of cells //-->
        <div  class="row" >


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <table id="tblData" class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th class="th-sm">SN

                      </th>
                      <th class="th-sm">Name

                      </th>
                      <th class="th-sm">Description

                      </th>
                      <th class="th-sm">Date Created

                      </th>
                      <th class="th-sm">Action

                      </th>

                    </tr>
                  </thead>
                  <tbody id='tblBody'>
                      <?php
                          // get cell data

                          $counter = 1;
                          foreach($get_types as $row){
                              $type_id = $row['id'];
                              $type_name = $row['name'];
                              $type_description = $row['description'];
                              $type_date_created = new DateTime($row['date_created']);
                              $type_date_created = $type_date_created->format('l jS F, Y');
                              $type_date_modified= $row['date_modified'];



                              // generate action buttons
                              // Button cell view
                              $mask = mask($type_id);
                              $type_view_link = "cell_type_view.php?en={$mask}";
                              //$explode_arr = explode("-",$cell_view_link);

                              $btn_type_view = "<a href='{$type_view_link}'
                                                   class='btn btn-secondary btn-sm btn-rounded color_scheme_opacity'
                                                   title='View Type Information'>
                                                   <i class='fas fa-glasses' aria-hidden='true'></i>
                                                   </a>";

                              // Button cell edit
                             $mask = mask($type_id);
                             $type_edit_link = "cell_type_edit.php?en={$mask}";
                             $btn_type_edit = "<a href='{$type_edit_link}'
                                                  class='btn btn-warning btn-sm btn-rounded color_scheme_opacity'
                                                  title='Edit Type Information'>
                                                  <i class='far fa-edit'></i>
                                                  </a>";

                              // Button cell delete
                             $mask = mask($type_id);
                             $type_delete_link = "cell_type_delete.php?en={$mask}";
                             $btn_type_delete = "<a href='{$type_delete_link}'
                                                  class='btn btn-danger btn-sm btn-rounded color_scheme_opacity'
                                                  title='Delete Type'>
                                                  <i class='far fa-trash-alt'></i>
                                                  </a>";



                              // display columns data
                              echo "<tr>";
                              echo "<td width='5%'>{$counter}.</td><td width='25%'>{$type_name}</td>
                                    <td width='30%'>{$type_description}</td><td width='20%'>{$type_date_created}</td>
                                    <td align='center' width='20%'>{$btn_type_view} {$btn_type_edit} {$btn_type_delete}</td>";
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
     <!-- <script>
         $(document).ready(function () {
             $('#tblData').DataTable();
             $('.dataTables_length').addClass('bs-select');
         });
     </script> -->
