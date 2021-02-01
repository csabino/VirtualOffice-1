<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/AnnouncementInterface.php");
require_once("../../../interface/TaskInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
require_once("../../../classes/Announcement.php");
require_once("../../../classes/Task.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {
    session_start();
    echo $_SESSION['task_file'];
    @unlink("../../../uploads/tasks/documents/{$_SESSION['task_file']}");
    @unlink("../../../uploads/tasks/images/{$_SESSION['task_file']}");
    unset($_SESSION['task_file']);











  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])


?>
