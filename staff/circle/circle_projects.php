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
                    <big><i class="fas fa-business-time"></i> Projects</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php
                        $code1 = mask($_GET_URL_cell_id);
                        $code2 = mask($_GET_URL_user_id );
                        $create_project_link = "circle_create_project.php?en=".$code1."&us=".$code2;

                    ?>
                    <a href="<?php echo $create_project_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> Create Project</a>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm" >SN</th>
                                    <th class="th-sm" >Projects</th>
                                    <th class="th-sm" >Creator</th>
                                    <th class="th-sm" >Date Created</th>
                                </tr>
                            </thead>
                            <tbody id="tblBody">
                                <?php
                                      // project list $counter
                                      $counter = 1;
                                      $project = new Project();
                                      $get_projects = $project->get_projects_by_cell($_GET_URL_cell_id);

                                      $recordFound = $get_projects->rowCount();

                                      if ($recordFound>0){
                                          foreach($get_projects as $row){
                                              $project_id = $row['id'];
                                              $project_title = $row['project_title'];
                                              $creator = $row['user_title'].' '.$row['last_name'].' '.$row['first_name'];
                                              $completed = $row['completed'];
                                              $date_created_raw = new DateTime($row['date_created']);
                                              $date_created = $date_created_raw->format('D jS F, Y');
                                              $time_created = $date_created_raw->format('g:i a');


                                              // display column data
                                              $project_link = "<a href='circle_project_updates.php?q=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id)."&pid=".mask($project_id)."'>{$project_title}</a>";
                                              $project_info_link = "<a title='Setting information about this project' href='circle_project_info.php?q=".mask($_GET_URL_cell_id)."&pid=".mask($project_id)."'><i class='fas fa-cogs'></i> Project Info (0)</a>";
                                              $project_updates_link = "<a title='Latest progress updates on the project' href='circle_project_updates.php?q=".mask($_GET_URL_cell_id)."&pid=".mask($project_id)."'><i class='fas fa-sync'></i> Updates (0)</a>";
                                              $project_tasks_link = "<a title='Assigned tasks to members' href='circle_project_tasks.php?q=".mask($_GET_URL_cell_id)."&pid=".mask($project_id)."'><i class='fas fa-tasks'></i> Tasks (0)</a>";
                                              $project_files_link = "<a title='Files uploaded' href='circle_project_files.php?q=".mask($_GET_URL_cell_id)."&pid=".mask($project_id)."'><i class='far fa-copy'></i> Files (0)</a>";

                                              echo "<tr>";
                                              echo "<td class='text-right px-5'>{$counter}.</td>";

                                              echo "<td width='55%' class='px-2'><strong>{$project_link}</strong> ";
                                                echo "<small><div class='row px-0 py-1'> "; // begin of row
                                                echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'> {$project_info_link} </div> ";
                                                echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'> {$project_updates_link} </div> ";
                                                echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'> {$project_tasks_link} </div> ";
                                                echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'> {$project_files_link} </div>  ";
                                                echo "</div></small>"; // end of row
                                              echo "</td>"; // end of table column


                                              echo "<td width='25%' class='px-2'>";
                                                  echo "<div class='chip' style='background-color:pink;'>";
                                                      echo "<img class='border-1' src='https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg' alt='Author'>{$creator}";
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
