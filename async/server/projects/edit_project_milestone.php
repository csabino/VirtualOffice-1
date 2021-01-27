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
      $milestone_id = $_POST['milestone_id'];
      $milestone_title = $_POST['milestone_title'];
      $milestone_description = $_POST['milestone_description'];
      $milestone_date = $_POST['milestone_date'];



      if ($project_id!='' && $milestone_title!='' && $milestone_id!=''){
         $dataArray = array("project_id"=>$project_id, "milestone_id"=>$milestone_id, "milestone_title"=>$milestone_title,
         "milestone_description"=>$milestone_description,"milestone_date"=>$milestone_date);

         //var_dump($dataArray);

         $project = new Project();
         $result = $project->edit_project_milestone($dataArray);

         //echo json_encode($response);
      }
       //echo $result;
       echo $result->rowCount();

  }



  ?>
