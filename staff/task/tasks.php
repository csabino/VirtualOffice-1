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
                    <a href="<?php echo $create_task_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i>&nbsp; New Task</a>
              </div>

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <table id='tblData' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="th-sm" >SN</th>
                                    <th class="th-sm" >Task</th>
                                    <th class="th-sm" >Creator</th>
                                    <th class="th-sm" >Project</th>
                                    <th class="th-sm" >Date Created</th>
                                </tr>
                            </thead>
                            <tbody id="tblBody">
                              <!--task list //-->
                              <?php
                                  $counter = 1;
                                  $project = new Project();
                                  $task = new Task();
                                  $task_list = $task->get_tasks_listing($_GET_URL_user_id);

                                  $recordFound = $task_list->rowCount();

                                  if ($recordFound > 0){
                                      // foreach
                                      foreach($task_list as $tlst){
                                          $task_id = $tlst['id'];
                                          $title = $tlst['subject'];
                                          $creator = $tlst['title'].' '.$tlst['first_name'].' '.$tlst['last_name'];
                                          $project_name = $tlst['project_name'];
                                          $project_cell_id = '';

                                          $task_updates_link = '';

                                          // if project_id is not blank, get project title as name from project
                                          if ($tlst['project_id']!=''){
                                               $get_project_name = $project->get_project_by_id($tlst['project_id']);
                                               foreach($get_project_name as $gpn){
                                                  $project_name = FieldSanitizer::outClean($gpn['title']);
                                                  $project_cell_id = ($gpn['cell_id']);
                                               }
                                               $task_href = "circle_project_task_updates.php?q=".mask($task_id)."&us=".mask($_GET_URL_user_id)."&cid=".mask($project_cell_id)."&pid=".mask($tlst['project_id']);
                                               $task_updates_link= "<a href='{$task_href}' class='font-weight-bold'>{$title}</a>";
                                          }else{
                                               $task_href = "task_updates.php?q=".mask($task_id)."&us=".mask($_GET_URL_user_id);
                                               $task_updates_link = "<a href='{$task_href}'>{$title}</a>";
                                          }
                                          // end of if project_id

                                          $status = $tlst['status'];

                                          $date_created_raw = new DateTime($tlst['date_created']);
                                          $date_created = $date_created_raw->format('D. jS M., Y');
                                          $time_created = $date_created_raw->format('g:i a');

                                          // Edit link info
                                          $edit_href = 'task_edit.php?q='.mask($_GET_URL_user_id)."&t=".mask($task_id);
                                          $edit_link = "<a class='text-info' href='{$edit_href}'><i class='far fa-edit'></i> Edit</a>";

                                          // Delete link info
                                          $delete_href = 'task_delete.php?q='.mask($_GET_URL_user_id)."&t=".mask($task_id);
                                          $delete_link = "<a class='text-danger' href='{$delete_href}'><i class='far fa-trash-alt'></i> Delete</a>";



                                          echo "<tr>";
                                          echo "<td class='text-right px-1' width='1px' >{$counter}.</td>";
                                          echo "<td width='40%' class='px-2'><strong>{$task_updates_link}</strong>";
                                               echo "<small><div class='row px-0 py-1'> "; // begin of rows
                                                  echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$edit_link}</div>";
                                                  echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$delete_link}</div>";
                                                  echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$status}</div>";
                                               echo "</div></small>";
                                          echo "</td>";
                                          echo "<td width='20%' class='px-2'>";
                                               echo "<div class='chip' style='background-color:pink;'>";
                                               echo "<img class='border-1' src='https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg' alt='Author'>{$creator}";
                                               echo "<div>";
                                          echo "</td>";
                                          echo "<td width='20%' class='px-2'>{$project_name}</td>";
                                          echo "<td width='15%' class='px-2'> <i class='far fa-calendar'></i> {$date_created}
                                                <div class='py-1'> <small> <i class='far fa-clock'></i> {$time_created}  </small></div> </td>";


                                          echo "</tr>";



                                      } // end of foreach
                                  }


                               ?> <!-- end of task list //-->

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
  <script src="../../lib/js/custom/tblData.js"></script>
