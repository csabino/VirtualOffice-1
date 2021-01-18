<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/AnnouncementInterface.php");
require_once("../../../interface/ProjectInterface.php");
require_once("../../../interface/GeneralRoomInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
require_once("../../../classes/Announcement.php");
require_once("../../../classes/Project.php");
require_once("../../../classes/GeneralRoom.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $cell_id = $_POST['cell_id'];
    $user_id = $_POST['user_id'];
    $lastPostId = $_POST['last_post_id'];

    $response = '';

    if ($cell_id!='' && $lastPostId!=''){
      $dataArray = array("cell_id"=>$cell_id, "last_post_id"=>$lastPostId);

      $generalRoom = new GeneralRoom();
      $result = $generalRoom->get_new_messages($dataArray);
      $resultCount = $result->rowCount();

      if ($resultCount>0){
        $response = postFactory($result, $user_id);
      }
    }

    echo $response;

  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])





  Function postFactory($result, $_GET_URL_user_id){
          $get_posts = $result;
          $post_pane = '';

          foreach($get_posts as $gp)
          {
            $last_post_id = $gp['id'];
            $postId = $gp['id'];
            $user_id = $gp['user_id'];
            $title = $gp['title'];
            $firstname = $gp['first_name'];
            $lastname = $gp['last_name'];
            $fullname = $title.' '.$lastname.' '.$firstname;
            $message = nl2br(FieldSanitizer::outClean($gp['message']));
            $avatar = '../images/avatar_100.png';

            if ($gp['avatar']!=''){
              $avatar = '../avatars/'.$gp['avatar'];
            }

            $date_posted_raw = new DateTime($gp['date_created']);
            $date_posted = $date_posted_raw->format('D. jS M. Y');

            $time_posted = $date_posted_raw->format('g:i a');


            $delete_pane = '';
            if ($user_id==$_GET_URL_user_id ){
              $delete_pane = "<div id='delete{$postId}' class='btn_delete text-danger' style='cursor:pointer;'>&nbsp;<small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }


        $post_pane .= "

                  <div class='row border-bottom py-3 z-depth-0 mt-3 postpackage' style='border-radius:0px;' id='{$postId}' >
                      <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left'>
                          <div class='px-2' style='float:left; border:0px solid red;'>
                              <img src='{$avatar}' width='50px' class='img-fluid img-responsive z-depth-1 rounded-circle' />
                          </div>
                          <div style='float:left; width:80%; border:0px solid black;'>
                                <div class='px-2'>
                                    <span id='user' class='font-weight-bold' ><small><strong>{$fullname}</strong></small></span>&nbsp;&nbsp;
                                    <span id='date_posted' class=''><small> {$date_posted}</small></span>&nbsp;
                                    <span id='time_posted'><small><i class='far fa-clock'></i> {$time_posted}</small></span>
                                </div>

                                <div class='py-1 px-2' id='comment'> {$message}</div>
                                {$delete_pane}
                          </div>

                      </div>

                  </div>
            <!-- end of post panel //-->
            ";




    }// end of foreach

    //$response = array("comment_pane"=>$comment_pane,"last_comment_id"=>$last_comment_id);
    return $post_pane;
  } // end of function


?>
