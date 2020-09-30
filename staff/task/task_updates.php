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
                    <big><i class="fas fa-business-time"></i> Task Updates</big>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <?php

                        $code1 = mask($_GET_URL_user_id);

                        $create_task_link = "create_task.php?q=".$code1;

                    ?>
                    <a href="<?php echo $create_task_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i>&nbsp; New Task</a>
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
                        $first_name = FieldSanitizer::outClean($gt['first_name']);
                        $last_name = FieldSanitizer::outClean($gt['last_name']);
                        $creator = $gt['title'].' '.$first_name.' '.$last_name;
                        $project_name = FieldSanitizer::outClean($gt['project_name']);
                        $status = FieldSanitizer::outClean($gt['status']);
                        $date_created_raw = new DateTime($gt['date_created']);
                        $date_created = $date_created_raw->format('l jS F, Y');
                        $time_created = $date_created_raw->format('g:i a');
                      }


                  ?>

                  <div class="py-2 px-2" id="announcement_header" style="background-color:#f1f1f1;">
                        <?php
                            echo "<div class='font-weight-bold'>".$title."</div>";
                            echo "<div><small><i class='far fa-user'></i> ".$creator."&nbsp;&nbsp;&nbsp;<i class='far fa-calendar-alt'></i> "
                            .$date_created."&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i> ".$time_created."</small></div>";
                        ?>
                  </div>
                  <div class="px-2 py-4">

                      <?php
                            echo ($description);
                       ?>
                  </div>


              </div>
      </div>


      <!-- end of Task Information //-->

      <!-- update area //-->
      <div class="row py-2">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-right">
              <div class="form-group blue-border-focus">
                  <textarea class="form-control" id="task_update" row="3" placeholder="Task Update..."></textarea>
              </div>
          </div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left align-middle">
              <button id="btn_post_update" class="btn btn-sm btn-primary align-middle">Post</button>
          </div>

      </div>
      <!-- end of update area //-->

      <!-- end of main area //-->
      <!-- comment listing //-->
      <div class="row">
          <?php

              $get_updates = $task->get_task_updates_by_id($_GET_URL_task_id);
              $total_updates = $get_updates->rowCount();
          ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-3">
              <strong>Updates (<span id='total_updates'><?php echo $total_updates; ?></span>)</strong>
          </div>
      </div>

      <div class="row py-2">
          <?php
          if ($total_updates>0){
            foreach($get_updates as $gu){
              $update_id = $gu['id'];
              $updates = nl2br(FieldSanitizer::outClean($gu['updates']));
              $date_posted_raw = new DateTime($gu['date_posted']);
              $date_posted = $date_posted_raw->format('l jS F, Y');
              $time_posted = $date_posted_raw->format('g:i a');

              echo "<div class='col-xs-12 col-md-10 col-lg-10 border py-2 px-2 mt-3 z-depth-1' style='margin-left:12px; border-radius:5px; padding: 2px;'>";
                echo "<div class='row'>";
                    echo "<div class='col-xs-12 col-md-12 col-lg-12 px-3'>";
                        echo "<small><i class='far fa-calendar-alt'></i> &nbsp;{$date_posted}&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i>{$time_posted}</small>";
                    echo "</div>";
                    echo "<div class='col-xs-12 col-md-12 col-lg-12'>";
                        echo $updates;
                    echo "</div>";
                echo "</div>";
              echo "</div>";

            }
          }



          ?>
      </div>


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type="text" id='user_id' value="<?php echo $_GET_URL_user_id; ?>" >
<input type="text" id="task_id" value="<?php echo $_GET_URL_task_id;  ?>" >

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
  <script src="../../async/client/task/post_update.js"></script>
