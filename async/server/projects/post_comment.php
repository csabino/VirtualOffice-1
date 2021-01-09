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

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
require_once("../../../classes/Announcement.php");
require_once("../../../classes/Project.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");
require_once("../../../functions/Encrypt.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

    $comment = FieldSanitizer::inClean($_POST['comment']);
    $user_id = $_POST['user_id'];
    $project_update_id = $_POST['project_update_id'];
    $last_comment_id = $_POST['last_comment_id'];

    $dataArray = array("user_id"=>$user_id, "project_update_id"=>$project_update_id, "comment"=>$comment);

    // check that fields are not blank
    if ($comment!='' && $user_id!='' && $project_update_id!=''){
      $project = new Project();
      $result = $project->projects_updates_comments($dataArray);

      // if post is successfully saved, retrieve new posts and display it on page

      if ($result->rowCount())
      {
          $count = 5;
          $start = $last_comment_id;
          $output = $project->get_projects_updates_comments_range($project_update_id, $start, $count);

          if ($output->rowCount())
          {
              $comment_pane = commentFactory($output, $user_id);
              echo $comment_pane;

          }
      }

    }












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
            $author_id = $gc['author'];
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
            if ($author_id==$user_id){
              $delete_pane = "<div id='delete{$commentId}' class='btn_select_delete text-danger' data-toggle='modal' data-target='#confirmDelete' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
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
