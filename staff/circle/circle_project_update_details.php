<?php

    // get circle and user eligibility by circle idea
    if (!isset($_GET['q']) || $_GET['q']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['us']) || $_GET['us']==''){
          header("location: work_circle.php");
    }


    if (!isset($_GET['pid']) || $_GET['pid']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['ud']) || $_GET['ud']==''){
          header("location: work_circle.php");
    }


    $_GET_URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_cell_id = $_GET_URL_cell_id[1];

    $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
    $_GET_URL_user_id = $_GET_URL_user_id[1];


    $_GET_URL_project_id = explode("-",htmlspecialchars(strip_tags($_GET['pid'])));
    $_GET_URL_project_id = $_GET_URL_project_id[1];


    $_GET_URL_project_update_id = explode("-",htmlspecialchars(strip_tags($_GET['ud'])));
    $_GET_URL_project_update_id = $_GET_URL_project_update_id[1];









    $page_title = 'Work Circle - Projects';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");



    $circle = new Circle();
    $my_circle = $circle->get_circle_user_info($_GET_URL_cell_id, $_SESSION['loggedIn_profile_user_id']);
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



      <!-- main page area //-->
      <div class="row border-bottom">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1 mb-4 font-weight-bold' >
                  <?php  echo $circle_name.$circle_short_name; ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab' >
                  <?php
                        $general_link = "circle_general_room.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>General Room</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active'>
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



      <!-- list of projects //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-business-time"></i> Project Updates</big>
                    <?php
                          $project = new Project();
                          $get_project = $project->get_project_by_id($_GET_URL_project_id);
                          $project_title = '';
                          foreach($get_project as $gp){
                              $project_title = $gp['project_title'];
                          }
                          echo "<div class='py-2'><span style='color:#1c2331'>".$project_title.'</span></div>';

                    ?>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php
                        $code1 = mask($_GET_URL_cell_id);
                        $code2 = mask($_GET_URL_user_id);
                        $code3 = mask($_GET_URL_project_id);
                        $post_project_create_link = "circle_project_create_update.php?q=".$code1."&us=".$code2."&pid=".$code3;
                        $post_project_updates_link = "circle_project_updates.php?q=".$code1."&us=".$code2."&pid=".$code3;
                    ?>
                    <a href="<?php echo $post_project_updates_link; ?>" class="btn btn-sm btn-success btn-rounded"> <i class="fas fa-chevron-left"></i> &nbsp;Project Updates</a>

                    <a href="<?php echo $post_project_create_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> &nbsp;Create Update</a>

              </div>

      </div>

      <!--     //-->
      <div class-"row mt-5">

          <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 border" style="background-color:#f1f1f1;">
                <?php
                    $project = new Project();
                    $get_projects_update = $project->get_projects_updates_by_id($_GET_URL_project_update_id);


                    $message = '';
                    $source = '';
                    $file_type = '';
                    $file = '';
                    $date_created = '';
                    $author_id = '';
                    $author_avatar = '../../images/user_avatar.png';
                    $author_fullname = '';

                    // ------------------   Get Update Details ----------------------
                    foreach($get_projects_update as $gpu){
                      $message = $gpu['message'];
                      $author_id = $gpu['user_id'];
                    }

                    //--------------------- Get User Info ---------------------------
                    $user = new StaffUser();
                    $get_author = $user->getUserById($author_id);
                    foreach($get_author as $gu)
                    {
                       $author_avatar = $gu['avatar'];
                       $author_fullname = $gu['title'].' '.$gu['last_name'].' '.$gu['first_name'];
                       $date_created = new DateTime($gu['date_created']);
                       $date_created =  $date_created->format('D jS F, Y');
                    }

                    if ($author_avatar!=''){
                      $author_avatar = "../avatars/".$author_avatar;
                    }




                    //---------------------------------------------------------------

                ?>

                <div class="text-center py-1" style="float:left;width:60px;">
                    <img src='<?php echo $author_avatar; ?>' width='70%' class='img-fluid img-responsive z-depth-1 rounded-circle'>
                </div>
                <div class="py-1" id="project_updates_details_header" >
                    <?php
                        echo "<div class='text-info font-weight-normal' >{$author_fullname}</div>";
                        echo "<div style='margin-bottom:15px;font-size:13px;'>{$date_created}</div>";
                        echo "<div>{$message}</div>";

                    ?>

                </div>

          </div>
      </div>




      <!-- end of main area //-->

      <!-- comment area //-->
      <div class="row py-2">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-right">
              <div class="form-group blue-border-focus">
                  <textarea class="form-control" id="comment" rows="4" placeholder="Comment..."></textarea>
              </div>
          </div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left align-middle">
              <button id="btn_send_comment" class="btn btn-sm btn-primary align-middle">Send</button>
          </div>

      </div>
      <!-- end of comment area //-->


      <!--  Comment listing //-->
      <!-- comment listing //-->
      <div class="row">
          <?php
              $project = new Project();
              $get_comments = $project->get_projects_updates_comments($_GET_URL_project_update_id);
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
            $author_id = $gc['author'];
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
              $delete_pane = "<div id='delete{$commentId}' class='btn_select_delete text-danger' data-toggle='modal' data-target='#confirmDelete'
               style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }

            $user_fullname = $title.' '.$lastname.' '.$firstname;
            $user_fullname_link = "<a href='../../staff/profile/user_profile.php?q=".mask($author_id)."'>{$user_fullname}</a>";

      ?>

                <div class="row" id="<?php echo $commentId; ?>" >
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <div class='px-2' style="float:left; border:0px solid red; width:7%;">
                            <img src="<?php echo $avatar; ?>" width="50px" class="img-fluid img-responsive z-depth-1 rounded-circle" />
                        </div>
                        <div style="float:left; border:0px solid black; width:93%;">
                              <div>
                                  <span id='user' class='font-weight-bold'><?php echo "{$user_fullname_link}"; ?></span>&nbsp;&nbsp;
                                  <span id='date_posted'><small><?php echo $date_posted;  ?></small></span>&nbsp;
                                  <span id="time_posted"><small><?php echo $time_posted; ?></small></span>
                              </div>

                              <div class='py-2' id='comment'> <?php echo $comment; ?> </div>
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









      <!--  end of comment listing //-->


  </div> <!-- end of container //-->


<input type="hidden" id="selected_del_comment_id"/>
<input type="hidden" id="project_update_id" value="<?php echo $_GET_URL_project_update_id; ?>" >
<input type="hidden" id="user_id" value="<?php echo $_GET_URL_user_id; ?>" >
<input type="hidden" id="last_comment_id" value="<?php echo $last_comment_id; ?>" >
<input type="hidden" id="total_comments" value="" >

<br/><br/><br/>

<!----------------------------- Modal --------------------------------------->
<!--------------------------------------------------------------------------->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you really wish to delete this record? <br/>
        <small>Note: This action is not reversible.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="button" id="btn_delete" class="btn btn-danger" data-dismiss="modal"><i class="far fa-trash-alt"></i> Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- End of Modal //-->


<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

 <script src="../../lib/js/custom/tblData.js"></script>
 <script src="../../async/client/project/post_comment.js"></script>/
