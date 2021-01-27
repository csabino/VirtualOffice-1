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





    $page_title = 'Work Circle | Files';

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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_projects.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Projects</a>";
                  ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active'>
                  <?php
                        $general_link = "circle_files.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Files</a>";
                  ?>
            </div>

      </div>


      <!-- end of main area //-->

      <!-- Tab //-->
      <nav class='mt-4'>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-announcement-tab" data-toggle="tab" href="#nav-announcement" role="tab"
            aria-controls="nav-home" aria-selected="true">Announcements</a>
          <a class="nav-item nav-link" id="nav-project-tab" data-toggle="tab" href="#nav-project" role="tab"
            aria-controls="nav-project" aria-selected="false">Project Updates</a>

        </div>
      </nav>

      <div class="tab-content" id="nav-tabContent"> <!-- Tab Content //-->

        <!-- Announcement Tab //-->
        <div class="tab-pane fade show active" id="nav-announcement" role="tabpanel" aria-labelledby="nav-announcement-tab">
            <!--  Announcement Files //-->
            <table id='tblData' class='table table-responsive table-striped table-bordered table-sm' cellspacing="0" width="100%">
                  <thead>
                        <tr>
                            <th class="th-sm">SN</th>
                            <th class="th-sm">Title</th>
                            <th class="th-sm">File</th>
                            <th class="th-sm">Date Created</th>
                        </tr>
                  </thead>
                  <tbody id="tblBody">
                    <?php
                        // get Announcement Files
                        $counter = 1;
                        $announcements = new Announcement();
                        $get_announcements = $announcements->getFiles($_GET_URL_cell_id);

                        $recordFound = $get_announcements->rowCount();

                        if ($recordFound > 0){
                            while ($row = $get_announcements->fetch(PDO::FETCH_ASSOC))
                            {
                                $announcement_id = $row['id'];
                                $title = $row['title'];
                                $author_id = $row['author'];
                                $author_title = FieldSanitizer::outClean($row['user_title']);
                                $file_type = $row['file_type'];
                                $file = $row['file'];
                                $author_first_name = FieldSanitizer::outClean($row['first_name']);
                                $author_last_name = FieldSanitizer::outClean($row['last_name']);
                                $author = $author_title.' '.$author_last_name.' '.substr($author_first_name,0,1).'.';
                                $author_profile_url = '../../staff/profile/user_profile.php?q='.mask($author_id);
                                $author_link = "<a class='text-info' href='{$author_profile_url}'>{$author}</a>";
                                $avatar = '../../images/user_avatar.png';

                                if ($row['avatar']!=''){
                                   $avatar = '../../staff/avatars/'.$row['avatar'];
                                }

                                $date_created_raw = new DateTime($row['date_created']);
                                $date_created = $date_created_raw->format('l jS F, Y');
                                $time_created = $date_created_raw->format('g:i a');

                                $title_link = "<a class='customlink' href='circle_announcement_details.php?q=".mask($announcement_id)."&en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id)."'>{$title}</a>
                                              <br/><small>Published by {$author_link}</small>";

                                // ---- File location and size
                                if ($file!=''){
                                   if ($file_type=='document'){
                                     $file_size = filesize("../../uploads/announcements/documents/${file}");
                                     if ($file_size<1000000){
                                        $file_size = round(($file_size/1024),2);
                                        $file_size = $file_size.' KB';
                                     } else{
                                        $file_size = round(($file_size/1024/1024),2);
                                        $file_size = $file_size.' MB';
                                     }

                                     $file_url = "<a target='_blank' class='text-info' href='../../uploads/announcements/documents/${file}'>${file}</a><div><small><i class='far fa-file-alt'></i> {$file_type} Attachment (${file_size})</small></div>";
                                   }else{
                                     $file_size = filesize("../../uploads/announcements/images/${file}");
                                     if ($file_size<1000000){
                                        $file_size = round(($file_size/1024),2);
                                        $file_size = $file_size.' KB';
                                     } else{
                                        $file_size = round(($file_size/1024/1024),2);
                                        $file_size = $file_size.' MB';
                                     }
                                     $file_url = "<a target='_blank' class='text-info' href='../../uploads/announcements/images/${file}'>{$file}</a><div><small><i class='far fa-file-image'></i> ${file_type} Attachment (${file_size})</small></div>";
                                   }

                                 }
                                // ----- end of file location and size



                                // ------------------   display columns with data -----------------------------------------------------
                                echo "<tr>";
                                echo "<td width='5%' class='text-right px-5'>{$counter}.</td>";
                                echo "<td width='40%' class='px-2'>{$title_link}</td>";
                                echo "<td width='25%' class='px-2'>{$file_url}</td>";
                                echo "<td><i class='far fa-calendar'></i> {$date_created} <div class='py-1'> <small> <i class='far fa-clock'></i> {$time_created}  </small></div></td>";




                                echo "</tr>";
                                //------------------- end of column data display ------------------------------------------------------
                                $counter++;
                        } // end of while loop
                      } // end of if ($counter > 0)


                    ?>

                  </tbody>
            </table>


            <!--  End of Announcement FIles //-->
        </div> <!-- End of Announcement Tab //-->

        <!-- Project Updates Content //-->
        <div class="tab-pane fade" id="nav-project" role="tabpanel" aria-labelledby="nav-project-tab">
                  <table id='tblData2' class="table table-responsive table-striped table-bordered table-sm" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th class="th-sm" >SN</th>
                              <th class="th-sm" >Title</th>
                              <th class="th-sm" >File</th>
                              <th class="th-sm" >Date Posted</th>
                          </tr>
                      </thead>
                      <tbody id="tblBody">
                          <?php
                                // get Project Updates file
                                $counter = 1;
                                $project =  new Project();
                                $get_projects = $project->get_project_updates_files_by_cell($_GET_URL_cell_id);

                                $recordFound = $get_projects->rowCount();

                                $user = new StaffUser();

                                // if statement if record is found
                                if ($recordFound > 0){
                                   while ($row = $get_projects->fetch(PDO::FETCH_ASSOC))
                                   {
                                      $update_id = $row['id'];
                                      $project_id = $row['project_id'];
                                      $message = $row['message'];
                                      $file_type = $row['file_type'];
                                      $file = $row['file'];
                                      $author_id = $row['user_id'];

                                      $get_author = $user->getUserById($author_id);
                                      foreach($get_author as $ga)
                                      {
                                         $author_avatar = $ga['avatar'];
                                         $author_fullname = $ga['title'].' '.$ga['last_name'].' '.$ga['first_name'];

                                         $author_profile_url = '../../staff/profile/user_profile.php?q='.mask($author_id);
                                         $author_profile_url = "<a class='text-info' href='{$author_profile_url}'>{$author_fullname}</a>";
                                      }


                                      $date_created_raw  = new DateTime($row['date_created']);
                                      $date_created = $date_created_raw->format('l jS F, Y');
                                      $time_created = $date_created_raw->format('g:i a');


                                      if (strlen($message)>120)
                                      {
                                          $message = substr($message,0,100)."...";
                                      }



                                      $project_update_link = "<a class='text-info' href='circle_project_update_details.php?q=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id)."&pid=".mask($project_id)."&ud=".mask($update_id)."'>{$message}</a>
                                                              <br/><small>Posted by {$author_profile_url}</small>";

                                      // ---- File location and size
                                if ($file!=''){
                                   if ($file_type=='document'){
                                     $file_size = filesize("../../uploads/projects/documents/${file}");
                                     if ($file_size<1000000){
                                        $file_size = round(($file_size/1024),2);
                                        $file_size = $file_size.' KB';
                                     } else{
                                        $file_size = round(($file_size/1024/1024),2);
                                        $file_size = $file_size.' MB';
                                     }

                                     $file_url = "<a target='_blank' class='text-info' href='../../uploads/projects/documents/${file}'>${file}</a><div><small><i class='far fa-file-alt'></i> {$file_type} Attachment (${file_size})</small></div>";
                                   }else{
                                     $file_size = filesize("../../uploads/projects/images/${file}");
                                     if ($file_size<1000000){
                                        $file_size = round(($file_size/1024),2);
                                        $file_size = $file_size.' KB';
                                     } else{
                                        $file_size = round(($file_size/1024/1024),2);
                                        $file_size = $file_size.' MB';
                                     }
                                     $file_url = "<a target='_blank' class='text-info' href='../../uploads/projects/images/${file}'>{$file}</a><div><small><i class='far fa-file-image'></i> ${file_type} Attachment (${file_size})</small></div>";
                                   }

                                 }
                                // ----- end of file location and size

                                      echo "<tr>";
                                      echo "<td width='5%' class='text-right px-5 '>{$counter}.</td>";
                                      echo "<td width='40%' class='px-2 font-weight-bold'>{$project_update_link}</td>";
                                      echo "<td width='25%' class='px-2'>{$file_url}</td>";
                                      echo "<td><i class='far fa-calendar'></i> {$date_created} <div class='py-1'> <small> <i class='far fa-clock'></i> {$time_created}  </small></div></td>";
                                      echo "</tr>";

                                      $counter++;

                                   } // end of while loop
                                } // end of if ($recordFound > 0)


                          ?>
                      <tbody>
                  </table>

        </div><!-- end of Project Updates Tab Content //-->

      </div><!-- end of Tab //-->




  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
 <script src="../../lib/js/custom/tblData.js"></script>
 <script src="../../lib/js/custom/tblData2.js"></script>
