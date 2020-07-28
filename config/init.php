<?php
  // Website configuration without login session

  // Base Url
  require_once("baseurl.php");

  // Functions - Includes directory
  require_once("functions/FieldSanitizer.php");
  require_once("functions/Alerts.php");

  // Interfaces - Interface directory
  require_once("interface/AuthInterface.php");
  require_once("interface/DBInterface.php");

  // Abstract - Abstract directory
  require_once("abstract/Database.php");

  // Class Autoload
  spl_autoload_register('classAutoLoader');

  function classAutoLoader($class){
      $path = "classes/";
      $class = "{$path}{$class}.php";
      include_once($class);
  }

 ?>
