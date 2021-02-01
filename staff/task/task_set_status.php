<?php

  // get user eligibility
  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: ../my_dashboard.php");
  }

  // get user eligibility
  if (!isset($_GET['us']) || $_GET['us']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_task_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_task_id = $_GET_URL_task_id[1];

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['us'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'Task Updates';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");


    $last_taskupdate_id = '';



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
      <!-- Task Information //-->
      <div class="row mt-5 px-1">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-cogs"></i> Task Status</big>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <?php

                        $code1 = mask($_GET_URL_user_id);

                        $tasks_list_link = "tasks.php?en=".$code1;
                        $create_task_link = "create_task.php?q=".$code1;

                    ?>
                    <a href="<?php echo $tasks_list_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-chevron-left"></i>&nbsp; Tasks List</a>
                    <!-- <a href="<?php echo $create_task_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i>&nbsp; New Task</a> //-->
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
              </div>

              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 border" style="padding:0px;">
                  <?php
                      $task = new Task();
                      $get_task = $task->get_task_by_id($_GET_URL_task_id);

                      foreach($get_task as $gt){
                        $task_id = $gt['id'];
                        $title = FieldSanitizer::outClean($gt['subject']);
                        $description = nl2br(FieldSanitizer::outClean($gt['description']));
                        $file_type = $gt['file_type'];
                        $file = $gt['file'];
                        $first_name = FieldSanitizer::outClean($gt['first_name']);
                        $last_name = FieldSanitizer::outClean($gt['last_name']);
                        $creator = $gt['title'].' '.$first_name.' '.$last_name;
                        $project_name = FieldSanitizer::outClean($gt['project_name']);
                        $status = FieldSanitizer::outClean($gt['status']);
                        $progress = $gt['progress'];
                        $date_created_raw = new DateTime($gt['date_created']);
                        $date_created = $date_created_raw->format('l jS F, Y');
                        $time_created = $date_created_raw->format('g:i a');
                      }

                      // set status
                      //echo "<br/><br/>".$status;
                      $status = ($status=="") ? "In progress" : $status;

                      //echo "<br/><br/>".$status;

                      $is_status_checked = '';
                      if ($status=="Completed")
                      {
                          $is_status_checked = "checked";
                      }else{
                          $is_status_checked = "";
                      }


                      // pass zero to progress if it is null or empty
                      $progress = ($progress=="") ? 0 : $progress;






                  ?>



                  <div class="py-2 px-2" id="announcement_header" style="background-color:#f1f1f1;">
                        <?php
                            echo "<div class='font-weight-bold'>".$title."</div>";
                            echo "<div><small><i class='far fa-user'></i> ".$creator."&nbsp;&nbsp;&nbsp;<i class='far fa-calendar-alt'></i> "
                            .$date_created."&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i> ".$time_created."</small></div>";
                        ?>
                  </div>

                  <div class="px-2 py-3 mb-2">
                      <div id='update_status_message'></div>
                      <form>
                          <!-- Status //-->
                            <div class="form-group col-xs-12 col-sm-12 col-md-6">
                              <label for="status"><strong>Status</strong></label>
                              <!-- Material checked -->
                                  <div class="switch">
                                      <label>
                                        <span id='progress'>Task in progress</span>
                                        <input type="checkbox" id='chk_status' <?php echo $is_status_checked; ?> >
                                        <span class="lever" id='status_lever'></span> <span id='completed'>Task completed</span>
                                      </label>
                                  </div>
                                <!-- Material //-->
                            </div>
                          <!-- end of status //-->

                          <!-- Progress //-->
                            <div class="form-group col-xs-12 col-sm-12 col-md-12">
                              <label for="status"><strong>Progress</strong></label>
                                <div class="d-flex justify-content-left my-2">
                                      <div class="w-75">
                                        <input type="range" class="custom-range" id="customRange11" min="0" max="100" value="<?php echo $progress; ?>">
                                      </div>
                                      <span class="font-weight-bold text-primary ml-2 valueSpan2"></span><span class='font-weight-bold text-primary'>% Done</span>
                                </div>
                            </div>
                          <!-- end of progress //-->


                          <!-- update button //-->
                          <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-left align-middle">
                              <button id="btn_update" class="btn btn-sm btn-primary align-middle rounded">Update Status</button>
                          </div>
                          <!-- end of button //-->


                      </form>

                  </div>


              </div>
      </div>


      <!-- end of Task Information //-->



   <!-- end of main area //-->



  </div> <!-- end of container //-->

<br/><br/><br/><br/>
<input type="hidden" id='user_id' value="<?php echo $_GET_URL_user_id; ?>" >
<input type="hidden" id="task_id" value="<?php echo $_GET_URL_task_id;  ?>" >
<input type="hidden" id="progress_value" value="<?php echo $progress; ?>" >
<input type="hidden" id="status_value" value="<?php echo $status; ?>" >


<br/><br/><br/><br/>



<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
  <script src="../../async/client/task/post_update.js"></script>
  <!--<script src="../../async/client/task/delete_update.js"></script> //-->
  <script src="../../async/client/task/set_task_status.js"></script>
