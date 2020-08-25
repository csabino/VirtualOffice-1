<?php

  // get user eligibility
  if (!isset($_GET['en']) || $_GET['en']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'My Tasks';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");






  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>My Tasks </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- list of tasks //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-business-time"></i> Tasks Listing</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php

                        $code1 = mask($_GET_URL_user_id);

                        $create_task_link = "create_task.php?q=".$code1;

                    ?>
                    <a href="<?php echo $create_task_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> New Task</a>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm" >SN</th>
                                    <th class="th-sm" >Task</th>
                                    <th class="th-sm" >Creator</th>
                                    <th class="th-sm" >Date Created</th>
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

                                              $date_created_raw = new DateTime($row['date_created']);
                                              $date_created = $date_created_raw->format('D jS F, Y');
                                              $time_created = $date_created_raw->format('g:i a');


                                              // display column data
                                              $project_update_link = "<a href='circle_project_update_details.php?q=".mask($_GET_URL_cell_id)."&pid=".mask($_GET_URL_project_id)."&ud=".mask($project_updates_id)."'>{$message}</a>";



                                              echo "<tr>";
                                              echo "<td class='text-right px-5'>{$counter}.</td>";
                                              echo "<td width='55%' class='px-2'><strong>{$project_update_link}</strong> ";
                                                echo "<small><div class='row px-0 py-1'> "; // begin of row
                                                echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'> Comments (0) </div> ";
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


      <!-- end of list of tasks //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
