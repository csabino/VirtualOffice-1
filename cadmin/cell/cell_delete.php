<?php
    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:cells.php");
    }else{
        $cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $cell_id = $cell_id[1];
    }



    $page_title = 'Cell - Delete';
    $visibility = "";
    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");

    $cell = new Cell();


    // Delete
    if (isset($_POST['btnSubmit'])){
        $stmt = $cell->delete_cell($cell_id);
        $visibility = "hidden";

        if ($stmt){
           $errFlag = 0;
           $errmsg = "The Cell has been successfully deleted";

        }else{
           $errFlag = 1;
           $errmsg = "There was an error deleting the Cell.";

        }
    }



    $get_cell = $cell->get_cell_by_id($cell_id);


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
                <h3>Cell - Delete Cell</h3>
            </div>

        </div>
        <!-- end of page header //-->



        <!-- main page area //-->
        <div class="row">
              <?php
                    if(isset($_POST['btnSubmit'])){
                        if ($errFlag==1){
                              echo "<div class='row'><div class='col-xs-12 col-sm-12 col-md-9 col-lg-9  mt-3' >";
                                  echo miniErrorAlert($errmsg);
                              echo "</div></div>";
                        }else if($errFlag==0){
                              echo "<table width='100%'><tr><td><div class='row'><div class='col-sx-12 col-sm-12 col-md-9 col-lg-9 mt-3' >";
                                  echo miniSuccessAlert($errmsg);
                              echo "</div></div></td></tr></table>";

                        }
                    }


               ?>


         <?php
               // check if a record is returned------------------------------------------------------------
               if ($get_cell->rowCount()){

          ?>

              <!-- work area //-->


              <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 mt-3" <?php echo $visibility;?> >
                  <?php
                        $cancel_link = "cell_view.php?en=".mask($cell_id);
                        $delete_link = "cell_delete.php=".mask($cell_id);

                        // check if the cell to be deleted is a parent and is_having_children
                        $is_a_parent = $cell->is_having_children($cell_id);
                        if ($is_a_parent->rowCount()){
                    ?>
                        <div class="alert alert-danger" role="alert">
                              <h4 class="alert-heading">Delete Error</h4>
                              <p class='font-weight-normal'>The Cell cannot be deleted because it is a parent with <?php echo $is_a_parent->rowCount(); ?> circles. </p>
                              <hr>
                              <p class="mb-0">
                                  <?php
                                        echo "<ol>";
                                            foreach($is_a_parent as $iap){
                                                echo "<li>".$iap['name'].' - ('.$iap['short_name'].")";
                                            }
                                        echo "</ol>";
                                   ?>
                              </p>
                        </div>

                  <?php
                        }else{
                          // Show feature to execute delete if the cell is not a parent

                   ?>
                  <!-- Confirm Delete Pane //-->
                  <form name="form_delete" action="<?php $delete_link; ?>" method="post"  >
                      <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading">Confirm Delete</h4>
                            <p class='font-weight-normal'>Do you wish to delete this Cell?</p>
                            <hr>
                            <p class="mb-0">
                                  <a href="<?php echo $cancel_link; ?>" class="btn btn-warning btn-sm btn-rounded color_scheme_opacity" >
                                    <i class="fas fa-undo"></i> Cancel</a>

                                  <button type="submit" name="btnSubmit" class="btn btn-danger btn-sm btn-rounded color_scheme_opacity" >
                                    <i class="far fa-trash-alt"></i> Delete</button>
                            </p>
                      </div>
                  </form><!-- end of form //-->
                  <?php

                              } // end of check for parenthood

                   ?>




                  <!-- end of Confirm Delete //-->

                                <!-- name //-->
                                <div class="row mt-4 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold ">Name</div>
                                    <div class="col-xs-12 col-md-10"><?php echo $cell_name; ?> </div>
                                </div>

                                <!-- short name //-->
                                <div class="row mt-3 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold  ">Short name</div>
                                    <div class="col-xs-12 col-md-10"><?php echo $cell_short_name; ?> </div>
                                </div>

                                <!-- parent //-->
                                <div class="row mt-3 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold ">Parent</div>
                                    <div class="col-xs-12 col-md-10"><?php echo $cell_parent_name; ?> </div>
                                </div>

                                <!-- type //-->
                                <div class="row mt-3 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold ">Type</div>
                                    <div class="col-xs-12 col-md-10"><?php echo $cell_type_name; ?> </div>
                                </div>

                                <!-- description //-->
                                <div class="row mt-3 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold ">Description</div>
                                    <div class="col-xs-12 col-md-10"><?php echo nl2br($cell_description); ?> </div>
                                </div>

                                <!-- date created //-->
                                <div class="row mt-3 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold ">Date Created</div>
                                    <div class="col-xs-12 col-md-10"><?php echo $date_created; ?> </div>
                                </div>

                                <!-- date modified //-->
                                <div class="row mt-3 ml-3">
                                    <div class="col-xs-12 col-md-2 font-weight-bold ">Date Updated</div>
                                    <div class="col-xs-12 col-md-10"><?php echo $date_modified; ?> </div>
                                </div>


                </div>
                <!-- end of work area //-->

            <?php
                }// end of check if record is returned. -----------------------------------------------------
                else{
                      echo "<div class='row' style='margin-top:60px'>"; //row
                          echo "<div class='col-xs-12 col-sm-12' >";
                              echo "The Cell is not found. It appears to have been deleted.<br/>";
                              $btn_cells = "<a href='cells.php'
                                                   class='btn btn-info btn-sm btn-rounded color_scheme_opacity mt-4'
                                                   title='Edit Cell Information'>
                                                   <i class='fas fa-angle-double-left'></i> Back to Cells Page
                                                   </a>";
                              echo $btn_cells;

                          echo "</div>";
                      echo "</div>"; //end of row
                }
             ?>

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
