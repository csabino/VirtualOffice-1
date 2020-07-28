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
    $roles = $_POST['roles'];
    $get_user_roles = $user->get_user_roles_by_array_id($roles);

    $user_roles = [];

    foreach($get_user_roles as $row){
       $role_id = trim($row['id']);
       $role = trim($row['role']);

       $user_roles[$role_id] = $role;
    }

    $user_roles = json_encode($user_roles);
    echo $user_roles;

  }

 ?>
