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

    $task_update = FieldSanitizer::inClean($_POST['task_update']);
    $user_id = $_POST['user_id'];
    $task_id = $_POST['task_id'];

    $dataArray = array("task_id"=>$task_id, "user_id"=>$user_id, "task_update"=>$task_update);

    //check that fields are not _blank
    if ($task_update!='' && $user_id!='' && $task_id!=''){
        $task = new Task();
        $publish = $task->post_task_update($dataArray);
        $resultCount = $publish->rowCount();
        $output = '';
        $status = '';

        if ($resultCount > 0){
           //print("Result Count");
           $publishedUpdateId = $task->get_user_task_updates_last_id($user_id);
           //print('Last Published Id '.$publishedUpdateId);
           $get_updates = $task->get_task_updates_by_id($publishedUpdateId);
           //print("Get Updates: ".$get_updates->rowCount());
           $output = commentFactory($get_updates, $user_id);
           $status = 'success';

        }else{
           $status = 'failed';
        }

        $response = array("status"=>$status,"output"=>$output,"lastTaskUpdateId"=>$publishedUpdateId);
        echo json_encode($response);


        //echo $output;


    }

} // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])





  Function commentFactory($result, $user_id){
          //print("In commentFactory");
          $get_updates = $result;
          $comment_pane = '';

          foreach($get_updates as $gu)
          {
            //print("Inside foreach");
            $update_id = $gu['id'];
            $updates = nl2br(FieldSanitizer::outClean($gu['updates']));
            $date_posted_raw = new DateTime($gu['date_posted']);
            $date_posted = $date_posted_raw->format('l jS F, Y');
            $time_posted = $date_posted_raw->format('g:i a');


            $comment_pane .= "
                    <div  id='{$update_id}' class='col-xs-12 col-md-10 col-lg-10 border py-2 px-2 mt-3 z-depth-1' style='margin-left:12px; border-radius:5px; padding: 2px;'>
                        <div class='row'>
                            <div class='col-xs-12 col-md-12 col-lg-12 px-4 py-1'>
                              <small><i class='far fa-calendar-alt'></i> &nbsp;{$date_posted}&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i>{$time_posted}</small>
                            </div>
                            <div class='col-xs-12 col-md-12 col-lg-12 px-4'>
                            {$updates}
                            </div>
                            <div class='col-xs-12 col-md-12 col-lg-12 px-4 text-right'>
                                <a id='del{$update_id}' class='btn-floating btn-sm btn-danger selectDeletePost' data-toggle='modal' data-target='#confirmDelete'>
                                    <i class='far fa-trash-alt'></i>
                                </a>
                             </div>
                        </div>
                    </div>
                ";
          }// end of foreach

    //$response = array("comment_pane"=>$comment_pane,"last_comment_id"=>$last_comment_id);
    //print($comment_pane);
    return $comment_pane;
  } // end of function


?>
