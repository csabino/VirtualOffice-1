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

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $announcement_id = $_POST['announcement_id'];


    $dataArray = array("announcement_id"=>$announcement_id, "user_id"=>$user_id, "comment_id"=>$comment_id);

    // check that fields are not blank
    if ($comment_id!='' && $user_id!='' && $announcement_id!='')
    {
        $announcement = new Announcement();
        $comment = $announcement->delete_comment($dataArray);
        echo $comment->rowCount();

    }
    // end of check for blank fields











  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])





  Function commentFactory($result){
          $get_comments = $result;
          $comment_pane = '';

          foreach($get_comments as $gc)
          {
            $last_comment_id = $gc['id'];
            $commentId = $gc['id'];
            $title = $gc['title'];
            $firstname = $gc['first_name'];
            $lastname = $gc['last_name'];
            $fullname = $title.' '.$lastname.' '.$firstname;
            $comment = nl2br(FieldSanitizer::outClean($gc['comment']));
            $avatar = '../images/avatar_100.png';

            if ($gc['avatar']!=''){
              $avatar = '../avatars/'.$gc['avatar'];
            }

            $date_posted_raw = new DateTime($gc['date_posted']);
            $date_posted = $date_posted_raw->format('D. jS M. Y');

            $time_posted = $date_posted_raw->format('g:i a');


            $delete_pane = '';
            if ($author_id==$_GET_URL_user_id ){
              $delete_pane = "<div id='delete{$commentId}' class='btn_delete text-danger' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }


        $comment_pane .= "

                <div class='row' id='{$commentId}' >
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left'>
                        <div class='px-2' style='float:left; border:0px solid red;'>
                            <img src='{$avatar}' width='50px' class='img-fluid img-responsive z-depth-1 rounded-circle' />
                        </div>
                        <div style='float:left; border:0px solid black;'>
                              <div>
                                  <span id='user'>{$fullname}</span>&nbsp;&nbsp;
                                  <span id='date_posted'><small>{$date_posted}</small></span>&nbsp;
                                  <span id='time_posted'><small>{$time_posted}</small></span>
                              </div>

                              <div id='comment'>{$comment}</div>
                              <div id='delete{$commentId}' class='btn_delete text-danger' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div>
                            

                    </div>

                </div>
            <hr><!-- end of comment panel //-->
            ";




    }// end of foreach

    //$response = array("comment_pane"=>$comment_pane,"last_comment_id"=>$last_comment_id);
    return $comment_pane;
  } // end of function


?>
