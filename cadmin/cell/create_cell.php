<?php
    $page_title = 'Create Cell';

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
        $name = FieldSanitizer::inClean($_POST['cell_name']);
        $short_name = FieldSanitizer::inClean($_POST['cell_short_name']);
        $parent = FieldSanitizer::inClean($_POST['cell_parent']);
        $type = FieldSanitizer::inClean($_POST['cell_type']);
        $description = FieldSanitizer::inClean($_POST['cell_description']);

        if ($name=='' || $type==''){
            $errFlag = 1;
            $errmsg = "Cell name and type are required.";

        }else{

            // check if cell already exist
            $cell_exist = $cell->is_cell_exist($name);
            if ($cell_exist->rowCount()==0)
            {
                  // collect data into dataArray
                  $dataArray = array("name"=>$name, "short_name"=>$short_name, "parent"=>$parent, "type"=>$type, "description"=>$description);
                  $cell_creator = $cell->create_cell($dataArray);

                  //check if cell_creation was successful
                  if ($cell_creator->rowCount()){
                      $errFlag = 0;
                      $errmsg = "The Cell <strong>'".$name."'</strong> has been successfully created.";
                  }else{
                      $errFlag = 1;
                      $errmsg = "An error occurred creating the Cell <strong>'".$name."'.</strong>";
                  }


            }else{
                  $errFlag = 1;
                  $errmsg = "The Cell <strong>'".$name."'</strong> already exist, and cannot be duplicated.";
            }




        }

    }

 ?>


    <div class="container">
        <!-- Page header //-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
                <h3>Create Cell</h3>
            </div>

        </div>
        <!-- end of page header //-->





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
                  <form class="border border-light p-4 " style="border-radius:5px;"
                    name="create_cell" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                    method="post">

                      <label for="textInput" class="text-info font-weight-normal">Name</label>
                      <input type="text" id="cell_name" name="cell_name" class="form-control mb-3 " placeholder="Cell name" required>



                      <label for="textInput" class="text-info font-weight-normal">Short Name</label>
                      <input type="text" id="cell_short_name" name="cell_short_name" class="form-control mb-3 " placeholder="Cell short name">


                      <?php
                          $get_cells =  $cell->get_all_cells();

                       ?>
                      <label for="select" class="text-info font-weight-normal">Parent</label>
                      <select class="browser-default custom-select mb-3" id="cell_parent" name="cell_parent" >
                          <option value="" selected=""></option>
                          <?php
                                if ($get_cells->num_rows){
                                    foreach($get_cells as $row){
                                        // cell variable info
                                        $cell_id = $row['id'];
                                        $cell_name = $row['name'];


                                        // get cell type information from cell types table
                                        $get_cell_type = $cell->get_cell_type_by_id($row['type']);

                                        $cell_type_name = '';

                                        foreach($get_cell_type as $gct){
                                            $cell_type_name = $gct['name'];
                                        }


                                        echo "<option value='{$cell_id}'>{$cell_name} - ({$cell_type_name})</option>";
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
                          <option value="" selected=""></option>
                          <?php
                                if ($get_cell_types->rowCount()){
                                      foreach($get_cell_types as $row){
                                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                                      }
                                }

                           ?>
                      </select>

                      <label for="description" class="text-info font-weight-normal">Description</label>
                      <textarea id="cell_description"  name="cell_description" class="form-control mb-2" placeholder="Description"></textarea>

                      <button id="btnSubmit" name="btnSubmit" class="btn btn-info btn-sm btn-rounded" type="submit"> Create</button>
                  </form>
                  <!-- end of form o create cell //-->


        </div><!-- end of form to create cell //-->

    </div>

    <br/><br/>

 <?php
     //footer.php
     require('../../includes/footer.php');
  ?>
