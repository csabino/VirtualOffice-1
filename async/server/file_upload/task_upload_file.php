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
      $file_type = $_GET['file_type'];
      $source = $_GET['source'];
      $file = $_FILES['file'];


      //$file = round($file/1000);  // calculate file size in Kb, Mb, Gb, Tb

      $fileUtil = new FileUploader();
      $uploadAction = $fileUtil->uploadFile($file_type, $source, $file);

      session_start();
      if ($uploadAction['status']=='success'){
          unset($_SESSION['task_file']);
          $_SESSION['task_file'] = $uploadAction['wp_filename'];
      }else{
          unset($_SESSION['task_file']);
      }

      $result = json_encode($uploadAction);

      echo $result;


  }

 ?>
