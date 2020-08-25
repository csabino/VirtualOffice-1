<?php

    //-------------- Abstract -----------------------------------
    require_once("../../../abstract/User.php");
    require_once("../../../abstract/Database.php");

    // -------------- Interface ---------------------------------
    require_once("../../../interface/UserInterface.php");
    require_once("../../../interface/DBInterface.php");
    require_once("../../../interface/CellInterface.php");
    require_once("../../../interface/FileUploaderInterface.php");


    //--------------- Classes -----------------------------------
    require_once("../../../classes/FileUploader.php");
    require_once("../../../classes/StaffUser.php");
    require_once("../../../classes/Cell.php");
    require_once("../../../classes/PDO_QueryExecutor.php");
    require_once("../../../classes/PDODriver.php");


  //header('Content-Type: text/html');

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {
      //$source = $_POST['source'];
      //$file_type = $_POST['file_type'];

      $source = $_POST['source'];
      $file = trim($_POST['file']);
      //echo strlen($file);

      @unlink("../../../uploads/{$source}/documents/".$file);
      @unlink("../../../uploads/{$source}/images/".$file);

      session_start();
      switch($source){
        case 'announcement':
            unset($_SESSION['announcement_file']);
            break;
        case 'projects':
            unset($_SESSION['project_update_file']);
            break;
      }





  }

 ?>
