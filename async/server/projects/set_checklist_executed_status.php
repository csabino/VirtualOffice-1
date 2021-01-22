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

      $checklist_id = $_POST['checklist_id'];
      $action = $_POST['action'];

      echo $action;

  }



  ?>
