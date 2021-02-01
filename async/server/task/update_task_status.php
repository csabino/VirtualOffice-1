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

    $status = $_POST['status'];
    $progress = $_POST['progress'];
    $task_id = $_POST['task_id'];

    $dataArray = array("task_id"=>$task_id, "status"=>$status, "progress"=>$progress);

    $response = '';
    $result = 0;

    if ($status!='' && $progress!='' && $task_id!='')
    {
        $task = new Task();
        $result = $task->set_task_status($dataArray);

        if ($result->rowCount()){
            $response = array("status"=>"success");
        }else{
            $response = array("status"=>"failed");
        }
    }


    echo json_encode($response);
    //echo $result->rowCount();





} // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])
