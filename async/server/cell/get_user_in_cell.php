<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/DBInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {
    $user_id = $_POST['user_id'];
    $cell_id = $_POST['cell_id'];

    $cell = new Cell();
    $user_in_cell = $cell->is_user_in_cell($cell_id, $user_id);

    $cell_user_roles = '';
    foreach($user_in_cell as $row){
       $cell_user_roles = $row['roles'];
    }
    $recordCount = $user_in_cell->rowCount();

    $result = array("recordCount"=>$recordCount, "roles"=>$cell_user_roles);
    $result = json_encode($result);

    echo $result;









  }

 ?>
