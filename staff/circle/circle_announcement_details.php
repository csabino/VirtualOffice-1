<?php

    // get circle and user eligibility by circle idea
    if (!isset($_GET['q']) || $_GET['q']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['en']) || $_GET['en']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['us']) || $_GET['us']==''){
          header("location: work_circle.php");
    }

    $_GET_URL_announcement_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_announcement_id = $_GET_URL_announcement_id[1];


    $_GET_URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
    $_GET_URL_cell_id = $_GET_URL_cell_id[1];

    $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
    $_GET_URL_user_id = $_GET_URL_user_id[1];









    $page_title = 'Work Circle - Announcement Details';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");




    $circle = new Circle();
    $my_circle = $circle->get_circle_user_info($_GET_URL_cell_id, $_SESSION['loggedIn_profile_user_id']);

    //echo $my_circle->rowCount();
    if (!$my_circle->rowCount()){
        $title = 'Unauthorised User Access';
        $msg = "Sorry, you do not have the required privilege to access the services on this page.";
        $footer = "<hr/><a href='work_circle.php'>Find your Work Circle</a>";
        errorAlert($title=$title,$message=$msg,$footer=$footer);
        exit;
    }

    $circle_id = '';
    $circle_name = '';
    $circle_short_name = '';

    foreach($my_circle as $row){
        $circle_id = $row['circle_id'];
        $circle_name = $row['circle_name'];
        $circle_short_name = $row['short_name'];

        if ($circle_short_name!=''){ $circle_short_name = " (". $circle_short_name.")";  }

    }


//-----------------------------------------------------------------------------------------------------------------
// Postback function

  $errFlag = 0;
  $flagMsg = '';

  if (isset($_POST['btnSubmit'])){

      $title = FieldSanitizer::inClean($_POST['title']);
      $message = FieldSanitizer::inClean($_POST['message']);
      $file = '';

      // check if file upload type is checked
      if (!isset($_POST['file_upload_type'])){

          $file_upload_type = '';

      }else{

         $file_upload_type = $_POST['file_upload_type'];
           // check if file has been uploaded
           if (isset($_SESSION['announcement_file'])){
              $file = $_SESSION['announcement_file'];
           } // end of check for file upload

      } // end of check file upload type



      // check if all require fields are filled
      if ($title!='' && $message!=''){
          // create data array and populate data
          $dataArray = array("cell"=>$_GET_URL_cell_id, "author"=>$_GET_URL_user_id,
                        "title"=>$title, "message"=>$message,"file_upload_type"=>$file_upload_type,
                        "file"=>$file);


          // call class and methods
          $announcement = new Announcement();
          $result = $announcement->new_announcement($dataArray);

          if ($result){
              $errFlag = 0;
              $flagMsg = 'The <strong>Announcement</strong> has been successfully created and posted.';
          }else{
              $errFlag = 1;
              $flagMsg = 'There was a problem creating the <strong>Announcement</strong>. <br/>Please try again or contact the Administrator.';
          }

      }else{
              $errFlag = 1;
              $flagMsg = "The <strong>Title</strong> and <strong>Message</strong> are required to create an <strong>Announcement</strong>";
      }

  }// end of postback
//---------------------------------------------------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------------------------------


  // check if user get authority in cell
  $has_authority = false;

  // get user role in cells
  $cell = new Cell();
  $circle = new Circle();

  //$user_cell_roles = $cell->get_user_roles_in_cell($_GET_URL_cell_id, $_GET_URL_user_id);
  $cell_user_roles = $circle->user_has_authority($_GET_URL_cell_id, $_GET_URL_user_id);
  //echo $cell_user_roles->rowCount();


  //echo ($user_cell_roles->rowCount());

  if ($cell_user_roles->rowCount()){ $has_authority = true;}

//   $roles = '';
//   foreach($user_cell_roles as $row){
//       $roles = $row['roles'];
//   }
//   $roles = explode(',', $roles);
// // Snippet to display the roles of the user in Circle
//   foreach($roles as $role){
//
//  }
//---------------------------------------------------------------------------------------------------------------------------



  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Work Circle </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- sub menu  //-->
      <div class="row border-bottom">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 mb-4 font-weight-bold' >
                  <?php  echo $circle_name.$circle_short_name; ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab' >
                  <?php
                        $general_link = "circle_general_room.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>General Room</a>";
                  ?>

            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active'>
                  <?php
                        $general_link = "circle_announcements.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Announcements</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_team.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Team</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3  ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_projects.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Projects</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_files.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Files</a>";
                  ?>
            </div>

      </div>
      <!-- end of sub menu //-->


      <!-- main body area //-->
      <!-- Announcement Details //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-bullhorn"></i> Announcement</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <?php
                    if ($has_authority) {
                      $create_announcement_link = "circle_create_announcement.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                ?>
                    <a href="<?php echo $create_announcement_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> Compose Announcement</a>
                <?php
                    }
                ?>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 border" style="padding:0px;">
                  <?php
                        $announcement = new Announcement();
                        $get_announcement = $announcement->get_announcement_by_id($_GET_URL_announcement_id);
                        foreach($get_announcement as $row){
                            $author_title = $row['title'];
                            $author_firstname = FieldSanitizer::outClean($row['first_name']);
                            $author_lastname = FieldSanitizer::outClean($row['last_name']);
                            $author_avatar = $row['avatar'];
                            $subject = FieldSanitizer::outClean($row['subject']);
                            $message = FieldSanitizer::outClean($row['message']);
                            $file_type = FieldSanitizer::outClean($row['file_type']);
                            $file = FieldSanitizer::outClean($row['file']);
                            $date_created_raw = new DateTime($row['date_created']);
                            $date_created = $date_created_raw->format('l jS F, Y');
                            $time_created = $date_created_raw->format('g:i a');
                        }


                   ?>
                  <div class="py-2 px-2" id="announcement_header" style="background-color:#f1f1f1;">
                      <?php
                            echo "<div class='font-weight-bold'>".$subject."</div>";
                            echo "<div><small><i class='far fa-user'></i> ".$author_title.' '.$author_lastname.' '.$author_firstname
                            ." &nbsp;&nbsp;&nbsp; <i class='far fa-calendar-alt'></i> ".$date_created." &nbsp;&nbsp;&nbsp; <i class='far fa-clock'></i> ".$time_created."</small></div>"
                       ?>
                  </div>
                  <div class="px-2 py-2">
                        <?php
                            if ($file!=''){
                               if ($file_type=='document'){
                                 $file_size = filesize("../../uploads/announcements/documents/${file}");
                                 if ($file_size<1000000){
                                    $file_size = round(($file_size/1024),2);
                                    $file_size = $file_size.' KB';
                                 } else{
                                    $file_size = round(($file_size/1024/1024),2);
                                    $file_size = $file_size.' MB';
                                 }

                                 $file_url = "<a target='_blank' href='../../uploads/announcements/documents/${file}'>${file_type} Attachment (${file_size})</a>";
                               }else{
                                 $file_size = filesize("../../uploads/announcements/images/${file}");
                                 if ($file_size<1000000){
                                    $file_size = round(($file_size/1024),2);
                                    $file_size = $file_size.' KB';
                                 } else{
                                    $file_size = round(($file_size/1024/1024),2);
                                    $file_size = $file_size.' MB';
                                 }
                                 $file_url = "<a target='_blank' href='../../uploads/announcements/images/${file}'>${file_type} Attachment (${file_size})</a>";
                               }




                               echo "<small><i class='fas fa-paperclip'></i> $file_url </small>";
                            }
                         ?>
                  </div>
                  <div class='py-5 px-2' id="announcement_body">
                      <?php

                          echo nl2br($message);
                      ?>
                  </div>




              </div>
      </div>
      <!-- end of announcements//-->

      <!-- comment area //-->
      <div class="row py-2">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-right">
              <div class="form-group blue-border-focus">
                  <textarea class="form-control" id="comment" row="3" placeholder="Have your say..."></textarea>
              </div>
          </div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left align-middle">
              <button id="btn_send_comment" class="btn btn-sm btn-primary align-middle">Send</button>
          </div>

      </div>
      <!-- end of comment area //-->


      <!-- comment listing //-->
      <div class="row">
          <?php
              $announcement = new Announcement();
              $get_comments = $announcement->get_comments($_GET_URL_announcement_id);
              $total_comments = $get_comments->rowCount();
          ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-3">
              <strong>Comments (<span id='total_comments'><?php echo $total_comments; ?></span>)</strong>
          </div>
      </div>

      <div id="comment-panel" class='py-2'>

      <?php
          $last_comment_id = 0;

          foreach($get_comments as $gc)
          {

            if ($last_comment_id==''){
              $last_comment_id = $gc['id'];
            }

            $commentId = $gc['id'];
            $title = $gc['title'];
            $firstname = $gc['first_name'];
            $lastname = $gc['last_name'];
            $author_id = $gc['user_id'];
            $comment = nl2br(FieldSanitizer::outClean($gc['comment']));
            $avatar = '../images/avatar_100.png';

            if ($gc['avatar']!=''){
              $avatar = '../avatars/'.$gc['avatar'];
            }

            $date_posted_raw = new DateTime($gc['date_posted']);
            $date_posted = $date_posted_raw->format('D. jS M. Y');

            $time_posted = $date_posted_raw->format('g:i a');

            //generate delete link if comment is by same user
            $delete_pane = '';
            if ($author_id==$_GET_URL_user_id ){
              $delete_pane = "<div id='delete{$commentId}' class='btn_delete text-danger' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }



      ?>

                <div class="row" id="<?php echo $commentId; ?>" >
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <div class='px-2' style="float:left; border:0px solid red;">
                            <img src="<?php echo $avatar; ?>" width="50px" class="img-fluid img-responsive z-depth-1 rounded-circle" />
                        </div>
                        <div style="float:left; border:0px solid black;">
                              <div>
                                  <span id='user'><?php echo $title.' '.$lastname.' '.$firstname; ?></span>&nbsp;&nbsp;
                                  <span id='date_posted'><small><?php echo $date_posted;  ?></small></span>&nbsp;
                                  <span id="time_posted"><small><?php echo $time_posted; ?></small></span>
                              </div>

                              <div id='comment'> <?php echo $comment; ?> </div>
                              <?php echo $delete_pane; ?>
                        </div>

                    </div>

                </div>


            <hr>

            <!-- end of comment listing //-->
      <?php

          }

       ?>
      </div> <!-- end of comment panel //-->






      <!-- end of main body area //-->


  </div> <!-- end of container //-->






  <input type='hidden' name='announcement_id' id="announcement_id" value="<?php echo $_GET_URL_announcement_id; ?>"  />
  <input type='hidden' name='user_id' id="user_id" value="<?php echo $_GET_URL_user_id; ?>"  />
  <input type='hidden' name='last_comment_id' id='last_comment_id' value="<?php echo $last_comment_id; ?>" />
<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>


<script src="../../async/client/announcement/upload_file.js"></script>

<script src="../../async/client/announcement/post_comment.js"></script>
