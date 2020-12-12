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
require_once("../../../functions/Encrypt.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $comment = FieldSanitizer::inClean($_POST['comment']);
    $user_id = $_POST['user_id'];
    $announcement_id = $_POST['announcement_id'];
    $last_comment_id = $_POST['last_comment_id'];

    $dataArray = array("announcement_id"=>$announcement_id, "user_id"=>$user_id, "comment"=>$comment);

    // check that fields are not blank
    if ($comment!='' && $user_id!='' && $announcement_id!='')
    {
        $announcement = new Announcement();
        $comment = $announcement->post_comment($dataArray);

        // if post is successfully saved, retrieve new posts and display it on page
        if ($comment->rowCount())
        {
           //print("Comment is well saved");
           $count = 5;
           $start = $last_comment_id;
           $result = $announcement->get_comments_range($announcement_id, $start, $count);

           if ($result->rowCount())
           {
                $comment_pane = commentFactory($result, $user_id);
                //var_dump(json_encode($comment_pane));
                echo $comment_pane;

           }else{

           }

        }
    }
    // end of check for blank fields











  } // end of if isset($_SERVER['HTTP_X_REQUESTED_WITH'])





  Function commentFactory($result, $user_id){
          $get_comments = $result;
          $comment_pane = '';

          foreach($get_comments as $gc)
          {
            $last_comment_id = $gc['id'];
            $commentId = $gc['id'];
            $title = $gc['title'];
            $firstname = $gc['first_name'];
            $lastname = $gc['last_name'];
            $author_id = $gc['user_id'];
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
            if ($author_id==$user_id ){
              $delete_pane = "<div id='delete{$commentId}' class='btn_delete text-danger' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }

            $user_fullname_link = "<a href='../../staff/profile/user_profile.php?q=".mask($author_id)."'>{$fullname}</a>";

        $comment_pane .= "

                <div class='row' id='{$commentId}' >
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left'>
                        <div class='px-2' style='float:left; border:0px solid red; width:7%;'>
                            <img src='{$avatar}' width='50px' class='img-fluid img-responsive z-depth-1 rounded-circle' />
                        </div>
                        <div style='float:left; border:0px solid black; width:93%;'>
                              <div>
                                  <span id='user' class='font-weight-bold'>{$user_fullname_link}</span>&nbsp;&nbsp;
                                  <span id='date_posted'><small>{$date_posted}</small></span>&nbsp;
                                  <span id='time_posted'><small>{$time_posted}</small></span>
                              </div>

                              <div class='py-2' id='comment'>{$comment}</div>
                              {$delete_pane}
                        </div>

                    </div>

                </div>
            <hr><!-- end of comment panel //-->
            ";




    }// end of foreach

    //$response = array("comment_pane"=>$comment_pane,"last_comment_id"=>$last_comment_id);
    return $comment_pane;
  } // end of function


?>
