<?php

    // get circle and user eligibility by circle idea
    if (!isset($_GET['en']) || $_GET['en']==''){
          header("location: work_circle.php");
    }

    if (!isset($_GET['us']) || $_GET['us']==''){
          header("location: work_circle.php");
    }


    $_GET_URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
    $_GET_URL_cell_id = $_GET_URL_cell_id[1];

    $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
    $_GET_URL_user_id = $_GET_URL_user_id[1];





    $page_title = 'Work Circle -  Announcement Details';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");

//--------------------------------------------------------------------------------------------------------------------

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
//-----------------------------------------------------------------------------------------------------------------

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
//   }






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

      <!-- circle navigation bar //-->

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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
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

      <!-- circle navigation bar //-->

      <!-- Announcements //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-bullhorn"></i> Announcements</big>
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
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm" >SN</th>
                                    <th class="th-sm" >Announcements</th>
                                    <th class="th-sm" >Author</th>
                                    <th class="th-sm" >Date Posted</th>
                                </tr>
                            </thead>
                            <tbody id="tblBody">
                                    <?php
                                          // get Announcements
                                          $counter = 1;
                                          $announcements = new Announcement();
                                          $get_announcements = $announcements->get_announcements($_GET_URL_cell_id);

                                          $recordFound = $get_announcements->rowCount();

                                          if ($recordFound>0){
                                              foreach($get_announcements as $row){
                                                  $announcement_id = $row['id'];
                                                  $title = FieldSanitizer::outClean($row['title']);
                                                  $author_id = $row['author'];
                                                  $author_title = FieldSanitizer::outClean($row['user_title']);
                                                  $author_first_name = FieldSanitizer::outClean($row['first_name']);
                                                  $author_last_name = FieldSanitizer::outClean($row['last_name']);
                                                  $author = $author_title.' '.$author_last_name.' '.substr($author_first_name,0,1).'.';

                                                  $avatar = '../../images/user_avatar.png';

                                                  if ($row['avatar']!=''){
                                                    $avatar = '../../staff/avatars/'.$row['avatar'];
                                                  }

                                                  $date_created_raw = new DateTime($row['date_created']);
                                                  $date_created = $date_created_raw->format('l jS F, Y');
                                                  $time_created = $date_created_raw->format('g:i a');

                                                  $title_link = "<a class='customlink' href='circle_announcement_details.php?q=".mask($announcement_id)."&en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id)."'>{$title}</a>";

                                                  $get_comment_count = $announcements->comment_count($announcement_id);
                                                  $comment_count = 0;

                                                  foreach($get_comment_count as $cc){
                                                      $comment_count = $cc['comment_number'];
                                                  }

                                                  $views = 0;
                                                  $get_announcement_views = $announcements->get_announcement_views($announcement_id);
                                                  foreach($get_announcement_views as $gav){
                                                      $views = $gav['views'];
                                                  }



                                                  // display columns data
                                                  echo "<tr>";
                                                  echo "<td class='text-right px-5'>{$counter}.</td>";

                                                  echo "<td width='55%' class='px-2'>{$title_link} <div class='py-1'><small> <span><i class='far fa-eye'></i> Views({$views})</span> &nbsp;&nbsp; <i class='far fa-comment-dots'></i> Comments({$comment_count})";
                                                  echo "</small></div></td>";

                                                  echo "<td width='25%' class='px-2'>";
                                                      echo "<div class='chip' style='background-color:pink;'>";
                                                          echo "<a href='../profile/user_profile.php?q=".mask($author_id)."'><img class='border-1' src='{$avatar}' alt='Author'>{$author}</a>";
                                                      echo "<div>";
                                                  echo "</td>";

                                                  echo "<td width='26%' class='px-2'> <i class='far fa-calendar'></i> {$date_created} <div class='py-1'> <small> <i class='far fa-clock'></i> {$time_created}  </small></div> </td>";



                                                  $counter++;
                                              } // end of foreach
                                          } // end of is statement

                                     ?>


                            </tbody>
                      </table>



              </div>
      </div>
      <!-- end of announcements//-->





      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

 <script src="../../lib/js/custom/tblData.js"></script>
