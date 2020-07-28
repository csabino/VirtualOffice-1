<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {
    $user = new StaffUser();
    $file_no = $_POST['fileno'];
    $get_user = $user->get_user_by_fileno($file_no);

      $user_id = '';
      $file_no = '';
      $title = '';
      $first_name = '';
      $last_name = '';
      $other_names = '';
      $position = '';
      $grade_level = '';
      $avatar = '';
      $date_created = '';
      $date_modified = '';
      $deleted = '';

      foreach($get_user as $row){
          $user_id = $row['id'];
          $file_no = $row['file_no'];
          $title = $row['title'];
          $first_name = $row['first_name'];
          $last_name = $row['last_name'];
          $other_names = $row['other_names'];
          $position = $row['position'];
          $grade_level = $row['grade_level'];
          $avatar = $row['avatar'];
          $date_created = $row['date_created'];
          $date_modified = $row['date_modified'];
          $deleted = $row['deleted'];
      }

      $recordno = $get_user->rowCount();
      $result = array("recordno"=>$recordno, "user_id"=>$user_id, "file_no"=>$file_no, "title"=>$title, "first_name"=>$first_name,
                "last_name"=>$last_name, "other_names"=>$other_names, "position"=>$position, "grade_level"=>$grade_level, "avatar"=>$avatar,
                "date_created"=>$date_created, "date_modified"=>$date_modified, "deleted"=>$deleted);

      $result = json_encode($result);
      echo $result;




  }

 ?>
