<?php
    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:cells.php");
    }else{
        $URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $URL_cell_id = $URL_cell_id[1];



    }

    $page_title = 'Cell';



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
                <h3>Cell &raquo; <small><?php echo $cell_name; ?></small> </h3>
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
                  <h4>General Information</h4>
                  <?php
                          // Button cell edit
                          $mask = mask($cell_id);
                          $cell_edit_link = "cell_edit.php?en={$mask}";
                          $btn_cell_edit = "<a href='{$cell_edit_link}'
                                               class='btn btn-warning btn-sm btn-rounded color_scheme_opacity'
                                               title='Edit Cell Information'>
                                               <i class='far fa-edit'></i> Edit
                                               </a>";

                           // Button cell delete
                          $mask = mask($cell_id);
                          $cell_delete_link = "cell_delete.php?en={$mask}";
                          $btn_cell_delete = "<a href='{$cell_delete_link}'
                                               class='btn btn-danger btn-sm btn-rounded color_scheme_opacity'
                                               title='Delete Cell'>
                                               <i class='far fa-trash-alt'></i> Delete
                                               </a>";

                          echo $btn_cell_edit;
                          echo $btn_cell_delete;
                    ?>

                    <!-- name //-->
                    <div class="row mt-4 py-2" style="background-color:#f6f6f6;">
                        <div class="col-xs-12 col-md-2 font-weight-bold ">Name</div>
                        <div class="col-xs-12 col-md-10"><?php echo $cell_name; ?> </div>
                    </div>

                    <!-- short name //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-2 font-weight-bold  ">Short name</div>
                        <div class="col-xs-12 col-md-10 font-weight-light"><?php echo $cell_short_name; ?> </div>
                    </div>

                    <!-- parent //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-2 font-weight-bold ">Parent</div>
                        <div class="col-xs-12 col-md-10 font-weight-light"><?php echo $cell_parent_name; ?> </div>
                    </div>

                    <!-- type //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-2 font-weight-bold ">Type</div>
                        <div class="col-xs-12 col-md-10"><?php echo $cell_type_name; ?> </div>
                    </div>

                    <!-- description //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-2 font-weight-bold ">Description</div>
                        <div class="col-xs-12 col-md-10 font-weight-light"><?php echo nl2br($cell_description); ?> </div>
                    </div>

                    <!-- date created //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-2 font-weight-bold ">Date Created</div>
                        <div class="col-xs-12 col-md-10"><?php echo $date_created; ?> </div>
                    </div>

                    <!-- date modified //-->
                    <div class="row mt-3">
                        <div class="col-xs-12 col-md-2 font-weight-bold ">Date Updated</div>
                        <div class="col-xs-12 col-md-10"><?php echo $date_modified; ?> </div>
                    </div>


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
