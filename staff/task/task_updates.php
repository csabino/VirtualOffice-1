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
                    <big><i class="fas fa-business-time"></i> Task Updates</big>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <?php

                        $code1 = mask($_GET_URL_user_id);

                        $tasks_list_link = "tasks.php?en=".$code1;
                        $create_task_link = "create_task.php?q=".$code1;

                    ?>
                    <a href="<?php echo $tasks_list_link; ?>" class="btn btn-sm btn-warning btn-rounded"> <i class="fas fa-chevron-left"></i>&nbsp; Tasks List</a>
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
                        $file_type = $gt['file_type'];
                        $file = $gt['file'];
                        $first_name = FieldSanitizer::outClean($gt['first_name']);
                        $last_name = FieldSanitizer::outClean($gt['last_name']);
                        $creator = $gt['title'].' '.$first_name.' '.$last_name;
                        $project_name = FieldSanitizer::outClean($gt['project_name']);
                        $status = FieldSanitizer::outClean($gt['status']);
                        $date_created_raw = new DateTime($gt['date_created']);
                        $date_created = $date_created_raw->format('l jS F, Y');
                        $time_created = $date_created_raw->format('g:i a');
                      }


                      //----------- file type  -------------------------------------
                      $file_url = '';
                      if ($file!=''){
                         if ($file_type=='document'){
                           $file_size = filesize("../../uploads/tasks/documents/${file}");
                           if ($file_size<1000000){
                              $file_size = round(($file_size/1024),2);
                              $file_size = $file_size.' KB';
                           } else{
                              $file_size = round(($file_size/1024/1024),2);
                              $file_size = $file_size.' MB';
                           }

                           $file_url = "<div class='mb-2'><small><a target='_blank' href='../../uploads/tasks/documents/${file}'><i class='fas fa-paperclip'></i> ".ucfirst($file_type)." Attachment (${file_size})</a></small></div>";
                         }else{
                           $file_size = filesize("../../uploads/tasks/images/${file}");
                           if ($file_size<1000000){
                              $file_size = round(($file_size/1024),2);
                              $file_size = $file_size.' KB';
                           } else{
                              $file_size = round(($file_size/1024/1024),2);
                              $file_size = $file_size.' MB';
                           }
                           $file_url = "<div class='mb-2'><small><a target='_blank' href='../../uploads/tasks/images/${file}'><i class='fas fa-paperclip'></i> ".ucfirst($file_type)." Attachment (${file_size})</a></small></div>";
                         }
                       }
                     // ---------- end of file type   -----------------------------




                  ?>



                  <div class="py-2 px-2" id="announcement_header" style="background-color:#f1f1f1;">
                        <?php
                            echo "<div class='font-weight-bold'>".$title."</div>";
                            echo "<div><small><i class='far fa-user'></i> ".$creator."&nbsp;&nbsp;&nbsp;<i class='far fa-calendar-alt'></i> "
                            .$date_created."&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i> ".$time_created."</small></div>";
                        ?>
                  </div>

                  <div class="px-2 py-2 mb-2">

                      <?php
                            echo $file_url;
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

              $get_updates = $task->get_task_updates_by_taskid($_GET_URL_task_id);
              $total_updates = $get_updates->rowCount();
          ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-3">
              <span><strong><big>Updates</big> (<span id='total_updates'><?php echo $total_updates; ?></span>)</strong></span>
          </div>
      </div>

      <div class="row py-2" id="row_post_pane">
          <?php
          if ($total_updates>0){
            foreach($get_updates as $gu){
              $update_id = $gu['id'];
              if ($last_taskupdate_id==''){
                  $last_taskupdate_id = $update_id;
              }

              $updates = nl2br(FieldSanitizer::outClean($gu['updates']));
              $date_posted_raw = new DateTime($gu['date_posted']);
              $date_posted = $date_posted_raw->format('l jS F, Y');
              $time_posted = $date_posted_raw->format('g:i a');

              echo "<div id='{$update_id}' class='col-xs-12 col-md-10 col-lg-10 border py-2 px-2 mt-3 z-depth-1' style='margin-left:12px; border-radius:5px; padding: 2px;'>";
                echo "<div class='row' >";
                    echo "<div class='col-xs-12 col-md-12 col-lg-12 px-4 py-1'>";
                        echo "<small><i class='far fa-calendar-alt'></i> &nbsp;{$date_posted}&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i>{$time_posted}</small>";
                    echo "</div>";
                    echo "<div class='col-xs-12 col-md-12 col-lg-12 px-4'>";
                        echo $updates;
                    echo "</div>";
                    echo "<div class='col-xs-12 col-md-12 col-lg-12 px-4 text-right'>
                        <a id='del{$update_id}' class='btn-floating btn-sm btn-danger selectDeletePost' data-toggle='modal' data-target='#confirmDelete'>
                            <i class='far fa-trash-alt'></i>
                        </a>
                     </div>";
                echo "</div>";
              echo "</div>";

            }
          }



          ?>
      </div>


  </div> <!-- end of container //-->

<br/><br/><br/><br/>
<input type="hidden" id='user_id' value="<?php echo $_GET_URL_user_id; ?>" >
<input type="hidden" id="task_id" value="<?php echo $_GET_URL_task_id;  ?>" >
<input type="hidden" id="last_taskupdate_id" value="<?php echo $last_taskupdate_id;  ?>" >
<input type="hidden" id="confirm_delete_post_id" value="">

<br/><br/><br/><br/>
<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        Do you wish to delete this post? <br/><small>Note: This action is not reversible.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="button" class="btn btn-danger"  data-dismiss="modal" id='delete_task_update'> <i class='far fa-trash-alt'></i> Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- end of Confirm Delete Modal -->


<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
  <script src="../../async/client/task/post_update.js"></script>
  <script src="../../async/client/task/delete_update.js"></script>
