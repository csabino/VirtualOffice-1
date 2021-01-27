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
                    <big><i class='fas fa-cogs'></i> Project Information & Settings</big>
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
                        $post_project_updates_link = "circle_projects.php?en=".$code1."&us=".$code2;

                    ?>
                    <a href="<?php echo $post_project_updates_link; ?>" class="btn btn-sm btn-success btn-rounded"> <i class="fas fa-chevron-left"></i> &nbsp;Project Updates</a>
                    <a href="<?php echo $post_project_create_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i> &nbsp;Create Update</a>
              </div>

              <!-- inside pane //-->
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


              <!--- Start of Accordion //-->

              <!--Accordion wrapper-->
              <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                <!-- Accordion card -->
                <div class="card">

                  <!-- Card header -->
                  <div class="card-header" role="tab" id="headingOne1">
                    <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
                      aria-controls="collapseOne1">
                      <h5 class="mb-0">
                        Project Definition <i class="fas fa-angle-down rotate-icon"></i>
                      </h5>
                    </a>
                  </div>

                  <!-- Card body -->
                  <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
                    data-parent="#accordionEx">
                    <div class="card-body">
                      <!-- Project Definition Code //-->
                      <?php
                          $project = new Project();
                          $getProjectDef = $project->getProjectDefinitionByProjectId($_GET_URL_project_id);

                          foreach($getProjectDef as $gpf){
                              $project_id = $gpf['id'];
                              $project_title = FieldSanitizer::outClean($gpf['title']);
                              $description = FieldSanitizer::outClean($gpf['description']);
                              $start_date = $gpf['start_date'];
                              $end_date = $gpf['end_date'];
                              $completed =  $gpf['completed'];
                              //$progress = $gpf['progress'];
                              $creator = $gpf['creator'];
                          }

                          // project completion indicator
                          if ($completed!=1){
                             $isCompleted = 'Not Completed';
                             $isCompleted = "<span class='badge badge-pill badge-danger'>{$isCompleted}</span>";
                          }else{
                             $isCompleted = 'Completed';
                             $isCompleted = "<span class='badge badge-pill badge-success'>{$isCompleted}</span>";
                          }


                          // project progress indicator
                          $percent_progress = $project->get_project_progress_indicator($project_id);
                          $progress = $percent_progress;

                          // progress indicator css class
                          $class = 'progress-bar';

                          if ($progress==0){
                            $class = 'progress-bar';
                          } else if ($progress>0 && $progress<5){
                            $class = 'progress-bar bg-danger';
                          } else if ($progress>=5 && $progress<25){
                            $class = 'progress-bar bg-warning';
                          } else if ($progress>=25 && $progress<50){
                            $class = 'progress-bar bg-info';
                          } else if ($progress>=50 && $progress<75){
                              $class = 'progress-bar bg-primary';
                          } else if ($progress>=75){
                            $class = 'progress-bar bg-success';
                          }


                      ?>
                      <!-- edit button //-->
                      <?php
                            if ($creator==$_GET_URL_user_id){
                       ?>
                          <div class='row'>
                              <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end'>
                                  <button class='btn btn-primary btn-sm btn-rounded'> <i class="far fa-edit"></i> Edit</button>
                              </div>
                          </div>
                      <?php
                            } // end of if check on user
                       ?>
                      <!-- end of edit button /->

                      <!-- Project Title Row //-->
                      <div class='row'>
                          <div class='col-xs-12 col-sm-12 col-md-2 md-lg-2 font-weight-bold'>
                              Title
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-10 md-lg-10'>
                              <?php echo $project_title; ?>
                          </div>
                      </div>
                      <!-- end of Project Title Row //-->

                      <!-- Project Description Row //-->
                      <div class='row mt-3'>
                          <div class='col-xs-12 col-sm-12 col-md-2 md-lg-2 font-weight-bold'>
                              Description
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-10 md-lg-10'>
                              <?php echo $description; ?>
                          </div>
                      </div>
                      <!-- end of Project Description Row //-->

                      <!-- Project Start Date Row //-->
                      <div class='row mt-3'>
                          <div class='col-xs-12 col-sm-12 col-md-2 md-lg-2 font-weight-bold'>
                              Start Date
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-10 md-lg-10'>
                              <?php echo $start_date; ?>
                          </div>
                      </div>
                      <!-- end of Project Start Date Row //-->

                      <!-- Project End Date Row //-->
                      <div class='row mt-3'>
                          <div class='col-xs-12 col-sm-12 col-md-2 md-lg-2 font-weight-bold'>
                              End Date
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-10 md-lg-10'>
                              <?php echo $end_date; ?>
                          </div>
                      </div>
                      <!-- end of Project End Date Row //-->

                      <!-- Project Completion Row //-->
                      <div class='row mt-3'>
                          <div class='col-xs-12 col-sm-12 col-md-2 md-lg-2 font-weight-bold'>
                              Completion
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-10 md-lg-10'>
                              <?php echo $isCompleted; ?>
                          </div>
                      </div>
                      <!-- end of Project Completion Row //-->


                      <!-- Project Progress Row //-->
                      <div class='row mt-3'>
                          <div class='col-xs-12 col-sm-12 col-md-2 md-lg-2 font-weight-bold'>
                              Progression
                          </div>
                          <div class='col-xs-12 col-sm-12 col-md-10 md-lg-10'>
                            <!-- Progress Bar //-->
                            <div class="progress md-progress" style="height: 20px">
                                <div class="<?php echo $class; ?>" role="progressbar" style="width:<?php echo $progress; ?>%; height: 20px" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100">
                                    <?php echo $progress.'%'; ?>
                                </div>
                            </div>
                            <!-- end of Progress Bar //-->
                          </div>
                      </div>
                      <!-- end of Project Progress Row //-->




                    </div>
                  </div>

                </div>
                <!-- Accordion card -->

                <!-- Accordion card -->
                <div class="card">

                  <!-- Card header -->
                  <div class="card-header" role="tab" id="headingTwo2">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
                      aria-expanded="false" aria-controls="collapseTwo2">
                      <h5 class="mb-0">
                        Checklist <i class="fas fa-angle-down rotate-icon"></i>
                      </h5>
                    </a>
                  </div>

                  <!-- Card body -->
                  <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
                    data-parent="#accordionEx">
                    <div class="card-body">
                      <!-- edit button //-->
                      <?php
                            if ($creator==$_GET_URL_user_id){
                              $checklist_edit_link = "checklist_edit.php?q=".mask($_GET_URL_cell_id)
                                                     ."&us=".mask($_GET_URL_user_id)."&pid=".mask($_GET_URL_project_id);
                       ?>
                          <div class='row'>
                              <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end'>
                                  <a href='<?php echo $checklist_edit_link; ?>' class='btn btn-primary btn-sm btn-rounded'> <i class="far fa-edit"></i> Edit</a>
                              </div>
                          </div>
                      <?php
                            } // end of if check on user
                       ?>
                      <!-- end of edit button /-->

                      <ul style='list-style-type:none;'>
                        <?php
                          $get_checklist = $project->get_project_checklist_by_project_id($_GET_URL_project_id);

                          foreach($get_checklist as $gc){
                              $checklist_id = $gc['id'];
                              $creator_id = $gc['user_id'];
                              $item = FieldSanitizer::outClean($gc['item']);
                              $description = FieldSanitizer::outClean($gc['description']);
                              $executed = $gc['executed'];


                              // set checklist check icon
                              $checklist_checkboxIcon = '';
                              if ($executed==1){
                                $checklist_checkboxIcon = "<i class='far fa-check-square fa-1x green-text pr-3'></i>";
                              }else{
                                $checklist_checkboxIcon = "<i class='far fa-square fa-1x green-text pr-3'></i>";
                              }


                              $li_id = 'chkLst'.$checklist_id;
                              $icon_id = 'delChkLst'.$checklist_id;

                        ?>
                        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                          <li title='<?php echo $description; ?>' id='<?php echo $li_id; ?>' style='cursor:pointer;padding:3px;'>
                                         <!-- <i class='far fa-square fa-1x green-text pr-3'></i> //-->
                                         <?php echo $checklist_checkboxIcon; ?>
                                         <?php echo $item; ?> &nbsp;</li>
                        </div>
                        <?php

                          } // end of foreach
                        ?>
                      </ul>



                    </div>
                  </div>

                </div>
                <!-- Accordion card -->

                <!-- Accordion card -->
                <div class="card">

                  <!-- Card header -->
                  <div class="card-header" role="tab" id="headingThree3">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
                      aria-expanded="false" aria-controls="collapseThree3">
                      <h5 class="mb-0">
                        Milestones <i class="fas fa-angle-down rotate-icon"></i>
                      </h5>
                    </a>
                  </div>

                  <!-- Card body -->
                  <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
                    data-parent="#accordionEx">
                    <div class="card-body">
                       <!-- Project Milestone Code //-->
                       <!-- edit button //-->
                       <?php
                             if ($creator==$_GET_URL_user_id){
                               $milestone_edit_link = "milestone_edit.php?q=".mask($_GET_URL_cell_id)
                                                      ."&us=".mask($_GET_URL_user_id)."&pid=".mask($_GET_URL_project_id);

                        ?>
                           <div class='row'>
                               <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-end'>
                                   <a href='<?php echo $milestone_edit_link; ?>' class='btn btn-primary btn-sm btn-rounded'> <i class="far fa-edit"></i> Edit</a>
                               </div>
                           </div>
                       <?php
                             } // end of if check on user
                        ?>
                       <!-- end of edit button /->

                       <!-- Timeline -->
                        <div class="row">
                          <div class="col-md-12">
                            <div class="timeline-main">
                              <!-- Timeline Wrapper -->
                              <ul class="stepper stepper-vertical timeline timeline-simple pl-0">

                       <?php
                          $get_milestones = $project->get_project_milestone_by_project_id($_GET_URL_project_id);

                          foreach($get_milestones as $gm){
                            $milestone_id = $gm['id'];
                            $creator_id = $gm['user_id'];
                            $milestone_title = FieldSanitizer::outClean($gm['title']);
                            $description = FieldSanitizer::outClean($gm['description']);
                            $milestone_date = $gm['milestone_date'];


                        ?>


                                 <li>
                                   <!--Section Title -->
                                   <a href="#!">
                                     <span class="circle grey"><i class="far fa-clock" aria-hidden="true"></i> </span>
                                   </a>

                                   <!-- Section Description -->
                                   <div class="step-content mr-xl-3 p-4 hoverable">
                                     <h4 class="font-weight-bold"><?php echo $milestone_title; ?></h4>
                                     <h3 class="font-weight-bold"><p class="text-muted mt-3"><i class="far fa-clock" aria-hidden="true"></i> <?php echo $milestone_date; ?></p></h3>
                                     <p class="mb-0"><?php echo $description ;?></p>
                                   </div>
                                 </li>








                       <?php
                          }

                       ?>
                             </ul>
                             <!-- Timeline Wrapper -->

                           </div>
                         </div>
                       </div>
                       <!-- Timeline -->

                       <!-- end of Project Milestone Code //-->
                    </div>
                  </div>

                </div>
                <!-- Accordion card -->

              </div>
              <!-- Accordion wrapper -->



              <!-- end of Accordion //-->



              </div><!-- end of inside pane //-->
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
