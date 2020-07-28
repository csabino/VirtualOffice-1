<?php
    if (!isset($_GET['en']) || $_GET['en']==''){
        header("location:cells.php");
    }else{
        $URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])) );
        $URL_cell_id = $URL_cell_id[1];


    }

    $page_title = 'Cell - Edit Information';

    //require_once("cell_config.php");
    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/admin_nav.php");


    // create cell object
    $cell = new Cell();

    // create and initialize err params...
    $errFlag = 0;
    $errmsg = '';

    // PostBack
    if (isset($_POST['btnSubmit'])){
        $id = FieldSanitizer::outClean($URL_cell_id);
        $name = FieldSanitizer::inClean($_POST['cell_name']);
        $short_name = FieldSanitizer::inClean($_POST['cell_short_name']);
        $parent = FieldSanitizer::inClean($_POST['cell_parent']);
        $type = FieldSanitizer::inClean($_POST['cell_type']);
        $description = FieldSanitizer::inClean($_POST['cell_description']);

        //check for blank fields
        if ($name=='' || $type==''){
            $errFlag = 1;
            $errmsg = "Cell name and type are required.";

        }else{

                  // collect data into dataArray
                  $dataArray = array("id"=>$id, "name"=>$name, "short_name"=>$short_name, "parent"=>$parent, "type"=>$type, "description"=>$description);
                  $cell_update = $cell->update_cell($dataArray);

                  //check if cell_creation was successful
                  if ($cell_update->rowCount()){
                      $errFlag = 0;
                      $errmsg = "The Cell <strong>'{$name}'</strong> has been successfully updated.";
                  }else{
                      $errFlag = 1;
                      $errmsg = "An error occurred updating the Cell <strong>'{$name}'</strong>";
                  }

        } // end of check for blank fields

    } // end of PostBack


    // retrieve cell Information
    $get_cell_info = $cell->get_cell_by_id($URL_cell_id);

    $cell_name = '';
    $cell_short_name = '';
    $cell_parent_id = '';
    $cell_type_id = '';
    $cell_description = '';
    $cell_date_created = '';
    $cell_date_modified = '';

    foreach($get_cell_info as $gci){
        $cell_name = FieldSanitizer::outClean($gci['name']);
        $cell_short_name = FieldSanitizer::outClean($gci['short_name']);
        $cell_parent_id = FieldSanitizer::outClean($gci['parent']);
        $cell_type_id = FieldSanitizer::outClean($gci['type']);
        $cell_description = FieldSanitizer::outClean($gci['description']);
        $cell_date_created = new DateTime($gci['date_created']);
        $cell_date_created = $cell_date_created->format('l jS F, Y');
        $cell_date_modified = new DateTime($gci['date_modified']);
        $cell_date_modified = $cell_date_modified->format('l jS F, Y');
    }
 ?>


    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Cell - Edit Information</h3>
            </div>

        </div>
        <!-- end of page header //-->


        <!-- row //-->
        <div class="row">

        <!-- form pane //-->
        <div class="form mt-2 col-xs-12 col-sm-12 col-md-8 col-lg-8">

                  <!-- display feedback //-->
                  <?php
                        if (isset($_POST['btnSubmit'])){
                            if ($errFlag==1){
                                miniErrorAlert($errmsg);
                            }else{
                                $msg = $errmsg;
                                miniSuccessAlert($msg);
                            }
                        }


                   ?>

                  <!-- form to create cell //-->
                  <?php
                        $form_action_link = "cell_edit.php?en=".mask($URL_cell_id);

                   ?>
                  <form class="border border-light p-4 " style="border-radius:5px;"
                    name="create_cell" action="<?php echo $form_action_link; ?>"
                    method="post">

                      <label for="textInput" class="text-info font-weight-normal">Name</label>
                      <input type="text" id="cell_name" name="cell_name" class="form-control mb-3 "
                      placeholder="Cell name" value="<?php echo $cell_name; ?>" required>



                      <label for="textInput" class="text-info font-weight-normal">Short Name</label>
                      <input type="text" id="cell_short_name" name="cell_short_name" class="form-control mb-3 "
                      placeholder="Cell short name" value="<?php echo $cell_short_name; ?>" >


                      <?php
                          $get_cells =  $cell->get_all_cells();

                       ?>
                      <label for="select" class="text-info font-weight-normal">Parent</label>
                      <select class="browser-default custom-select mb-3" id="cell_parent" name="cell_parent" >
                          <option value=""></option>
                          <?php
                                if ($get_cells->num_rows){
                                    foreach($get_cells as $row){



                                        // cell variable info
                                        $opt_cell_id = $row['id'];
                                        $opt_cell_name = $row['name'];


                                        // check the parent and select the default one
                                        if ($cell_parent_id==$opt_cell_id){
                                            $selected = 'selected';
                                        }else{
                                            $selected = '';
                                        }


                                        // get cell type information from cell types table
                                        $get_cell_type = $cell->get_cell_type_by_id($row['type']);

                                        $cell_type_name = '';

                                        foreach($get_cell_type as $gct){

                                            $cell_type_name = $gct['name'];
                                        }


                                        echo "<option value='{$opt_cell_id}'  {$selected}>{$opt_cell_name} - ({$cell_type_name})</option>";
                                    }
                                }
                           ?>
                      </select>


                      <?php
                          // Get cell cell_types
                          $get_cell_types =  $cell->get_cell_types();

                       ?>
                      <label for="select" class="text-info font-weight-normal">Type</label>
                      <select class="browser-default custom-select mb-3" id="cell_type" name="cell_type" required>
                          <option value="" ></option>
                          <?php
                                $selected = "";
                                if ($get_cell_types->rowCount()){
                                      foreach($get_cell_types as $row){
                                        if ($cell_type_id==$row['id']){
                                            $selected = "selected";
                                        }else{
                                            $selected = "";
                                        }
                                        echo "<option value='".$row['id']."' {$selected}>".$row['name']."</option>";
                                      }
                                }

                           ?>
                      </select>

                      <label for="description" class="text-info font-weight-normal">Description</label>
                      <textarea id="cell_description"  name="cell_description" class="form-control mb-2" placeholder="Description"><?php echo $cell_description; ?></textarea>

                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Update</button>
                  </form>
                  <!-- end of form o create cell //-->


        </div><!-- end of form to create cell //-->
        <!-- end of form //-->

        <!-- right pane //-->
        <?php

              $cell_view_page = "cell_view.php?en=".mask($URL_cell_id);
         ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 mt-4">
              <a href="<?php echo $cell_view_page; ?>" class="btn btn-primary btn-sm btn-rounded color_scheme_opacity" >
                  <i class="fas fa-angle-double-left"></i> Back to Cell Page
              </a>

              <div class="mt-4">
                  <strong>Created -</strong> <?php echo "{$cell_date_created}"; ?>
              </div>

              <div class="mt-4">
                  <strong>Updated -</strong> <?php echo "{$cell_date_modified}"; ?>
              </div>

        </div>
        <!-- end of right pane //-->

      </div><!-- end of row //-->

    </div>

    <br/><br/><br/><br/>

 <?php
     //footer.php
     require('../../includes/footer.php');
  ?>
