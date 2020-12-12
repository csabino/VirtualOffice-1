<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/TaskInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
require_once("../../../classes/Task.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
{


    $user_id = $_POST['user_id'];
    $post_id = $_POST['post_id'];
    $task_id = $_POST['task_id'];

    $dataArray = array("task_id"=>$task_id, "user_id"=>$user_id, "post_id"=>$post_id);

    //check that fields are not _blank
    if ($task_id!='' && $user_id!='' && $post_id!=''){
        $task = new Task();
        $delete = $task->delete_task_update($dataArray);


        $deleteCount = $delete->rowCount();
        $output = '';
        $status = '';

        if ($deleteCount > 0){
           $status = 'success';

        }else{
           $status = 'failed';
        }

        $response = array("status"=>$status);
        echo json_encode($response);


        //echo $output;


    }

} // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])






?>
