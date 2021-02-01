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
                                  $task_list = $task->get_my_tasks_listing($_GET_URL_user_id);

                                  $recordFound = $task_list->rowCount();

                                  if ($recordFound > 0){
                                      // foreach
                                      foreach($task_list as $tlst){
                                          $task_id = $tlst['id'];
                                          $title = FieldSanitizer::outClean($tlst['subject']);
                                          $creator_id = $tlst['creator'];
                                          $creator = $tlst['title'].' '.$tlst['first_name'].' '.$tlst['last_name'];
                                          $creator_avatar = '..\..\images\avatardefault100.png';
                                          if ($tlst['avatar']!=''){
                                              $creator_avatar = '../avatars/'.$tlst['avatar'];
                                          }

                                          $file_type = $tlst['file_type'];
                                          $file = $tlst['file'];

                                          $file_attachment = '';
                                         if ($file_type!=''){
                                           $file_attachment = "<small><i class='fas fa-paperclip'></i> ".ucfirst($file_type)."</small>";
                                         }

                                          $project_name = FieldSanitizer::outClean($tlst['project_name']);
                                          $project_cell_id = '';

                                          $task_updates_link = '';


                                          $task_href = "task_updates.php?q=".mask($task_id)."&us=".mask($_GET_URL_user_id);
                                          $task_updates_link = "<a class='text-info font-weight-bold' href='{$task_href}'>{$title}</a>";



                                          $status = $tlst['status'];

                                            // set $status
                                            if ($status=='Completed'){
                                               $status = "<span class='badge badge-pill badge-success'>Completed</span>";
                                            }else{
                                               $status = "<span class='badge badge-pill badge-warning'>In progress</span>";
                                            }
                                            // end of $status

                                          $date_created_raw = new DateTime($tlst['date_created']);
                                          $date_created = $date_created_raw->format('D. jS M., Y');
                                          $time_created = $date_created_raw->format('g:i a');

                                          // Edit link info
                                          $edit_href = 'edit_task.php?q='.mask($_GET_URL_user_id)."&t=".mask($task_id);
                                          $edit_link = "<a class='text-info' href='{$edit_href}'><i class='far fa-edit'></i> Edit</a>";

                                          // Delete link info
                                          $delete_href = 'task_delete.php?q='.mask($_GET_URL_user_id)."&t=".mask($task_id);
                                          $delete_link = "<a id='del{$task_id}' class='text-danger sel_delete_task' href='{$delete_href}' data-toggle='modal' data-target='#confirmDelete'><i class='far fa-trash-alt'></i> Delete</a>";
                                          $set_status = "<a class='text-info' href='task_set_status.php?q=".mask($task_id)."&us=".mask($_GET_URL_user_id)."'>Set Status</a>";

                                          //----------- get task_updates_count for this $task
                                          $get_updates = $task->get_task_updates_count_by_taskid($task_id);
                                          $get_updates_recordset = $get_updates->fetch(PDO::FETCH_ASSOC);
                                          $get_updates_count = $get_updates_recordset['task_updates_count'];
                                          //----------- end of get task_update_count

                                          //--------------- Progress bar //-------------------------
                                          $progress = ($tlst['progress']=='') ? 0 : $tlst['progress'];


                                          $class = 'progress-bar';

                                             if ($progress==0){
                                               $class = 'progress-bar';
                                             }else if ($progress>0 && $progress<25){
                                               $class = 'progress-bar bg-danger';
                                             }else if ($progress>=25 && $progress<50){
                                               $class = 'progress-bar bg-warning';
                                             }else if ($progress>=50 && $progress<75){
                                               $class = 'progress-bar bg-primary';
                                             }else if ($progress>=75){
                                               $class = 'progress-bar bg-success';
                                             }



                                          echo "<tr>";
                                          echo "<td class='text-center px-1' width='1px' >{$counter}.</td>";
                                          echo "<td width='40%' class='px-2'><strong>{$task_updates_link} {$file_attachment}</strong>";
                                               echo "<div class='row px-0 py-1'>";
                                                  echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'><small><i class='far fa-comment-alt'></i> Updates ({$get_updates_count})</small></div>";
                                                  echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$status}</div>";
                                                  echo "<div class='col-xs-4 col-sm-4 col-md-6 col-lg-6'>";
                                                  ?>
                                                  <!-- Progress Bar //-->
                                                  <div class="progress md-progress" style="height:20px">
                                                      <div class="<?php echo $class; ?>" role="progressbar" style="width:<?php echo $progress; ?>%; height: 20px" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                                          <?php echo $progress.'%'; ?>
                                                      </div>
                                                  </div>
                                                  <!-- end of Progress Bar //-->


                                                  <?php
                                                  echo "</div>";
                                               echo "</div>";

                                               // check if the creator/author is the same as the viewer

                                              if ($creator_id==$_GET_URL_user_id){

                                                   echo "<small><div class='row px-0 py-1'> "; // begin of rows
                                                      echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$edit_link}</div>";
                                                      echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$delete_link}</div>";
                                                      echo "<div class='col-xs-4 col-sm-4 col-md-3 col-lg-3'>{$set_status}</div>";
                                                   echo "</div></small>";
                                              }
                                              // end of check to see


                                          echo "</td>";
                                          echo "<td width='20%' class='px-2'>";
                                               echo "<div class='chip' style='background-color:pink;'>";
                                               echo "<img class='border-1' src='{$creator_avatar}' width='100px' alt='Author'>{$creator}";
                                               echo "<div>";
                                          echo "</td>";
                                          echo "<td width='20%' class='px-2'>{$project_name}</td>";
                                          echo "<td width='15%' class='px-2'> <i class='far fa-calendar'></i> {$date_created}
                                                <div class='py-1'> <small> <i class='far fa-clock'></i> {$time_created}  </small></div> </td>";


                                          echo "</tr>";

                                          $counter++;

                                      } // end of foreach
                                  }


                               ?> <!-- end of task list //-->

                            </tbody>
                      </table>
