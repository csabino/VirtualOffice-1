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

    //-------------- Functions ---------------------------------
    require_once("../../../functions/FieldSanitizer.php");


  //header('Content-Type: text/html');

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

      $project_id = $_POST['project_id'];
      $checklist_id = $_POST['checklist_id'];
      $checklist_item = $_POST['checklist_item'];
      $checklist_description = $_POST['checklist_description'];

      if ($project_id!='' && $checklist_item!='' && $checklist_id!=''){
         $dataArray = array("project_id"=>$project_id, "checklist_id"=>$checklist_id, "checklist_item"=>$checklist_item,
         "checklist_description"=>$checklist_description);

         $project = new Project();
         $result = $project->edit_project_checklist($dataArray);

         //echo json_encode($response);
      }
       //echo $result;
       echo $result->rowCount();

  }



  ?>
