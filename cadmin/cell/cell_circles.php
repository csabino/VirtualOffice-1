<?php
    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:cells.php");
    }else{
        $URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $URL_cell_id = $URL_cell_id[1];



    }

    $page_title = 'WorkPlace Cell - Circles';

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
                <h3>Cell - Circles </h3>
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
                    <div class='font-weight-bold mb-3'>Circles</div>
                    <ul>
                            <?php
                                   $children =  $cell->is_having_children($URL_cell_id);
                                  if ($children->rowCount())
                                  {
                                      // Cell has circles
                                          foreach($children as $c){
                                             $opt_link = "cell_view.php?en=".mask($c['id']);
                                             echo "<li class='mb-2'><a href='{$opt_link}'>".$c['name']."</a></li>";
                                             grandchild($cell,$c['id']);

                                          }
                                  }else{
                                          echo "<div class='mt-2'>No Circle has been created for this Cell.</div>";
                                  }


                                  function grandchild($cell, $parent){
                                      $have_children = $cell->is_having_children($parent);
                                      if ($have_children->rowCount()){
                                          echo "<ul>";
                                                foreach($have_children as $hc){
                                                    $opt_link = "cell_view.php?en=".mask($hc['id']);
                                                    echo "<li class='mb-2'><a href='{$opt_link}'>".$hc['name']."</a></li>";
                                                }
                                          echo "</ul>";
                                      }
                                  }





                            ?>
                    </ul>




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
