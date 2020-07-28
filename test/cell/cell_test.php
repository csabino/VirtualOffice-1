<?php
   $page_title = 'Cells';

   //require_once("cell_config.php");
   require_once("../../config/step2/init_wp.php");
   require_once("../../nav/admin_nav.php");

   $cell = new Cell();
   $get_cells = $cell->get_all_cells();
   $number_of_cells = $get_cells->num_rows;

?>


   <!-- Cells body //-->
   <div class="container">
       <!-- Page header //-->
       <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
               <h3>Cells (<?php echo $number_of_cells; ?>)</h3>
           </div>

       </div>
       <!-- end of page header //-->


       <div class="row">
          <div class="col-xs-12">
                <a href="cell_types.php" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="fas fa-plus" aria-hidden="true"></i> Types</a>
          </div>
       </div>




       <!-- list of cells //-->
       <div  class="row" style="margin-top:-45px;">

           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                 <br/><br/>
                 <a href="cell_types.php" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" > <i class="fas fa-plus" aria-hidden="true"></i> Types</a>
                 <table id="tblData" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                 <thead>
                   <tr>
                     <th class="th-sm">SN

                     </th>
                     <th class="th-sm">Name

                     </th>
                     <th class="th-sm">Parent

                     </th>
                     <th class="th-sm">Type

                     </th>
                     <th class="th-sm">Action

                     </th>

                   </tr>
                 </thead>
                 <tbody id='tblBody'>
                     <?php
                         // get cell data

                         $counter = 1;
                         foreach($get_cells as $row){
                             $cell_id = $row['id'];
                             $cell_name = $row['name'];
                             $cell_parent_id = $row['parent'];
                             $cell_parent_name = '';
                             $cell_type_id = $row['type'];
                             $cell_type_name = '';


                             // get parent cell
                             $get_cell_parent = $cell->get_parent_cell_by_id($cell_parent_id);

                             foreach($get_cell_parent as $gcp){
                                 $cell_parent_name = $gcp['name'];

                             }


                             //get cell type information
                             $get_cell_type = $cell->get_cell_type_by_id($cell_type_id);

                             foreach($get_cell_type as $gct){
                                 $cell_type_name = $gct['name'];
                             }

                             // generate action buttons
                             // Button cell view
                             $mask = mask($cell_id);
                             $cell_view_link = "cell_view.php?en={$mask}";
                             //$explode_arr = explode("-",$cell_view_link);

                             $btn_cell_view = "<a href='{$cell_view_link}'
                                                  class='btn btn-secondary btn-sm btn-rounded color_scheme_opacity'
                                                  title='View Cell Information'>
                                                  <i class='fas fa-glasses' aria-hidden='true'></i>
                                                  </a>";

                             // Button cell edit
                            $mask = mask($cell_id);
                            $cell_edit_link = "cell_edit.php?en={$mask}";
                            $btn_cell_edit = "<a href='{$cell_edit_link}'
                                                 class='btn btn-warning btn-sm btn-rounded color_scheme_opacity'
                                                 title='Edit Cell Information'>
                                                 <i class='far fa-edit'></i>
                                                 </a>";

                             // Button cell delete
                            $mask = mask($cell_id);
                            $cell_delete_link = "cell_delete.php?en={$mask}";
                            $btn_cell_delete = "<a href='{$cell_delete_link}'
                                                 class='btn btn-danger btn-sm btn-rounded color_scheme_opacity'
                                                 title='Delete Cell'>
                                                 <i class='far fa-trash-alt'></i>
                                                 </a>";



                             // display columns data
                             echo "<tr>";
                             echo "<td width='5%'>{$counter}.</td><td>{$cell_name}</td>
                                   <td>{$cell_parent_name}</td><td>{$cell_type_name}</td>
                                   <td align='center'>{$btn_cell_view} {$btn_cell_edit} {$btn_cell_delete}</td>";
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
    <!-- <script>
        $(document).ready(function () {
            $('#tblData').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script> -->
