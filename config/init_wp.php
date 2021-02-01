<?php
  // Work place logged in configuration

  //$absolute_path =  realpath("../../core/wp_config.php");
  // Base Url
  require_once("../baseurl.php");

  // Authorization acces
  require_once("../includes/is_login_auth.php");

  // Functions - Include Directory
  require_once("../functions/FieldSanitizer.php");
  require_once("../functions/Alerts.php");
  require_once("../functions/Encrypt.php");
  require_once("../functions/Colors.php");
  require_once("../functions/Gradients.php");



  // Abstract - Abstract Directory
  require_once("../abstract/Database.php");
  require_once("../abstract/User.php");


  // Interface - Interface Directory
  require_once("../interface/AuthInterface.php");
  require_once("../interface/DBInterface.php");
  require_once("../interface/NoticeBoardInterface.php");
  require_once("../interface/UserInterface.php");
  require_once("../interface/CellInterface.php");
  require_once("../interface/CircleInterface.php");
  require_once("../interface/FileUploaderInterface.php");
  require_once("../interface/AnnouncementInterface.php");
  require_once("../interface/ProjectInterface.php");
  require_once("../interface/TaskInterface.php");
  require_once("../interface/MemoInterface.php");
  require_once("../interface/ContactInterface.php");
  require_once("../interface/MeetingInterface.php");
  require_once("../interface/GeneralRoomInterface.php");
  require_once("../interface/MailInterface.php");






  // Logged-In Header
  require_once("../includes/logged_in_header.php");


  // Class Autoload
  spl_autoload_register('classAutoLoader');


  function classAutoLoader($class){
      $path = "../classes/";
      $class = "{$path}{$class}.php";
      include_once($class);
  }

 ?>
