<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/AnnouncementInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
require_once("../../../classes/Announcement.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $comment = $_POST['comment'];
    $user_id = $_POST['user_id'];
    $announcement_id = $_POST['announcement_id'];

    $dataArray = array("announcement_id"=>$announcement_id, "user_id"=>$user_id, "comment"=>$comment);

    // check that fields are not blank
    if ($comment!='' && $user_id!='' && $announcement_id!='')
    {
        $announcement = new Announcement();
        $comment = $announcement->post_comment($dataArray);
        echo $comment;
    }
    // end of check for blank fields











  }


?>
