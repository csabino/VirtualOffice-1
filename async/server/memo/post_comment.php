<?php

//-------------- Abstract -----------------------------------
require_once("../../../abstract/User.php");
require_once("../../../abstract/Database.php");

// -------------- Interface ---------------------------------
require_once("../../../interface/UserInterface.php");
require_once("../../../interface/DBInterface.php");
require_once("../../../interface/CellInterface.php");
require_once("../../../interface/MemoInterface.php");

//--------------- Classes -----------------------------------
require_once("../../../classes/StaffUser.php");
require_once("../../../classes/Cell.php");
require_once("../../../classes/PDO_QueryExecutor.php");
require_once("../../../classes/PDODriver.php");
require_once("../../../classes/Memo.php");

//-------------- Functions ---------------------------------
require_once("../../../functions/FieldSanitizer.php");




if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
{

    $comment = FieldSanitizer::inClean($_POST['comment']);
    $user_id = $_POST['user_id'];
    $memo_id = $_POST['memo_id'];
    $last_comment_id = $_POST['last_comment_id'];

    $dataArray = array("memo_id"=>$memo_id, "user_id"=>$user_id, "comment"=>$comment);

    $status = '';
    $output = '';

    //check that fields are not _blank
    if ($comment!='' && $user_id!='' && $memo_id!=''){
        $memo = new Memo();
        $publish = $memo->post_memo_comment($dataArray);
        if ($publish->rowCount())
        {
            //get last memo comment by the user
            $comment = $memo->get_user_last_memo_comment($user_id, $memo_id);
            $output = commentFactory($comment, $user_id);
            $status = 'success';

        }else{
            $status = 'failed';
        }
    }

    $response = array("status"=>$status, "output"=>$output);
    echo json_encode($response);

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
              $delete_pane = "<div id='delete{$commentId}' data-toggle='modal' data-target='#confirmDelete' class='btn_delete text-danger px-2' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }


        $comment_pane .= "

              <div class='row border py-3 z-depth-1 mt-3' style='border-radius:8px;' id='{$commentId}' >
                  <div class='col-xs-12 col-sm-12 col-md-10 col-lg-10 text-left'>
                      <div class='px-2' style='float:left; border:0px solid red;'>
                          <img src='${avatar}' width='50px' class='img-fluid img-responsive z-depth-1 rounded-circle' />
                      </div>
                      <div style='float:left; border:0px solid black;'>
                            <div class='px-2'>
                                <span id='user' class='font-weight-bold' ><small>{$fullname}</small></span>&nbsp;&nbsp;
                                <span id='date_posted'><small>{$date_posted}</small></span>&nbsp;
                                <span id='time_posted'><small>{$time_posted}</small></span>
                            </div>

                            <div class='py-1 px-2' id='comment'>{$comment}</div>
                            {$delete_pane}
                      </div>

                  </div>

              </div>

            ";




    }// end of foreach

    //$response = array("comment_pane"=>$comment_pane,"last_comment_id"=>$last_comment_id);
    return $comment_pane;
  } // end of function


?>
