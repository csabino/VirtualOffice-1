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


    $_GET_URL_cell_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
    $_GET_URL_cell_id = $_GET_URL_cell_id[1];

    $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
    $_GET_URL_user_id = $_GET_URL_user_id[1];

    $_GET_URL_project_id = explode("-",htmlspecialchars(strip_tags($_GET['pid'])));
    $_GET_URL_project_id = $_GET_URL_project_id[1];

    





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
                    <big><i class="fas fa-tasks"></i> Project Tasks</big>
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
                        $project_create_task_link = "circle_project_create_task.php?q=".$code1."&us=".$code2."&pid=".$code3;
                        $projects_link = "circle_projects.php?en=".$code1."&us=".$code2;

                    ?>
                    <a href="<?php echo $projects_link; ?>" class="btn btn-sm btn-success btn-rounded"> <i class="fas fa-chevron-left"></i> &nbsp;Projects</a>
                    <a href="<?php echo $project_create_task_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> &nbsp;Create Task</a>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm" >SN</th>
                                    <th class="th-sm" >Task</th>
                                    <th class="th-sm" >Creator</th>
                                    <th class="th-sm" >Date Posted</th>
                                </tr>
                            </thead>
                            <tbody id="tblBody">
                                <?php
                                      // project list $counter
                                      $counter = 1;
                                      $project = new Project();
                                      $get_projects_updates = $project->get_projects_updates_by_project($_GET_URL_project_id);

                                      $recordFound = $get_projects_updates->rowCount();
                                      $user = new StaffUser();

                                      if ($recordFound>0){
                                          foreach($get_projects_updates as $row){
                                              $project_updates_id = $row['id'];

                                              $message = nl2br(FieldSanitizer::outClean($row['message']));


                                              if (strlen($message)>120){
                                                  $message = substr($message,0,120)."...";
                                              }


                                              $sender_id = $row['user_id'];
                                              $user_info = $user->get_user_by_id($sender_id);
                                              $sender = '';
                                                foreach ($user_info as $uif) {
                                                    $sender = $uif['title'].' '.$uif['last_name'].' '.$uif['first_name'];
                                                }

                                              $file_type = '';

                                              if ($row['file_type']!=''){
                                                $file_type = '<i class="fas fa-paperclip"></i> '.$row['file_type'];
                                              }

                                              $date_created_raw = new DateTime($row['date_created']);
                                              $date_created = $date_created_raw->format('D jS F, Y');
                                              $time_created = $date_created_raw->format('g:i a');


                                              // display column data
                                              $project_update_link = "<a class='text-info' href='circle_project_update_details.php?q=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id)."&pid=".mask($_GET_URL_project_id)."&ud=".mask($project_updates_id)."'>{$message}</a>";



                                              echo "<tr>";
                                              echo "<td class='text-right px-5'>{$counter}.</td>";
                                              echo "<td width='55%' class='px-2'><strong>{$project_update_link}</strong> ";
                                                echo "<small><div class='row px-0 py-1'> "; // begin of row
                                                echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'> <i class='far fa-comment-dots'></i>  Comments (0) </div>
                                                      <div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'><i class='far fa-eye'></i> Views (0) </div>
                                                      <div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$file_type} </div> ";
                                                echo "</div></small>"; // end of row
                                              echo "</td>"; // end of table column


                                              echo "<td width='25%' class='px-2'>";
                                                  echo "<div class='chip' style='background-color:pink;'>";
                                                      echo "<img class='border-1' src='https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg' alt='Author'>{$sender}";
                                                  echo "<div>";
                                              echo "</td>";

                                              echo "<td width='26%' class='px-2'> <i class='far fa-calendar'></i> {$date_created} <div class='py-1'> <small> <i class='far fa-clock'></i> {$time_created}  </small></div> </td>";

                                              $counter++;
                                          } // end of foreach
                                      } // end of if statement

                                ?>

                            </tbody>
                      </table>



              </div>
      </div>


      <!-- end of list projects //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>

 <script src="../../lib/js/custom/tblData.js"></script>
