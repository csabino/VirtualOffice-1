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

      $dataArray = array("cell_id"=>$cell_id, "creator"=>$creator, "title"=>$title,
      "description"=>$description,"start_date"=>$start_date,"end_date"=>$end_date,
      "source"=>$source, "operation"=>$operation);

      if ($operation=='create'){

          $project = new Project();
          $create_project = $project->new_project($dataArray);
          //$result = $create_project->rowCount();
          echo $create_project;
      }










  }



  ?>
