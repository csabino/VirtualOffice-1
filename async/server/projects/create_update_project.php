<?php

    //-------------- Abstract -----------------------------------
    require_once("../../../abstract/User.php");
    require_once("../../../abstract/Database.php");

    // -------------- Interface ---------------------------------
    require_once("../../../interface/UserInterface.php");
    require_once("../../../interface/DBInterface.php");
    require_once("../../../interface/CellInterface.php");
    require_once("../../../interface/FileUploaderInterface.php");
    require_once("../../../interface/ProjectInterface.php");


    //--------------- Classes -----------------------------------
    require_once("../../../classes/FileUploader.php");
    require_once("../../../classes/StaffUser.php");
    require_once("../../../classes/Cell.php");
    require_once("../../../classes/Project.php");
    require_once("../../../classes/PDO_QueryExecutor.php");
    require_once("../../../classes/PDODriver.php");


  //header('Content-Type: text/html');

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

      $cell_id = $_POST['cell_id'];
      $creator = $_POST['creator'];
      $title = $_POST['title'];
      $description = $_POST['description'];
      $start_date = $_POST['startDate'];
      $end_date = $_POST['endDate'];
      $source = $_POST['source'];
      $operation = $_POST['operation'];
      $new_project_id = $_POST['new_project_id'];

      $dataArray = array("cell_id"=>$cell_id, "creator"=>$creator, "title"=>$title,
      "description"=>$description,"start_date"=>$start_date,"end_date"=>$end_date,
      "source"=>$source, "operation"=>$operation, "new_project_id"=>$new_project_id);

      $project = new Project();

      if ($operation=='create'){

          $create_project = $project->new_project($dataArray);
          echo json_encode($create_project);

      } else if( $operation=='update'){
            if ($new_project_id!='' && $title!=''){
                $update_project = $project->update_project($dataArray);

            }else{

            }

      }










  }



  ?>
