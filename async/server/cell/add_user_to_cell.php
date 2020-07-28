<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {
      $user_id = $_POST['user_id'];
      $cell_id = $_POST['cell_id'];
      $roles = $_POST['roles'];

      $dataArray = array("user_id"=>$user_id,"cell_id"=>$cell_id,"roles"=>$roles);

      $cell = new Cell();
      $user_cell = $cell->add_user_to_cell($dataArray);

      $json_user_cell = json_encode($user_cell);
      echo $json_user_cell;
  }

 ?>
