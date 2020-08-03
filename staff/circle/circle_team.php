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





    $page_title = 'Work Circle - Team';

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

//----------------------------------------------------------------------------------------------------------------------

 // Get team of this circle
 $circle_team = $circle->get_circle_team_members($_GET_URL_cell_id);

 $team_size =  $circle_team->rowCount();






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

      <!-- navigation links //-->

      <div class="row border-bottom">
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 mb-4 font-weight-bold' >
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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active'>
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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_files.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Files</a>";
                  ?>
            </div>

      </div>
      <!-- end of navigation links //-->

      <!-- team display //-->

      <div class="row mt-5">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-users"></i> Team Members (<?php echo $team_size ?>)</big>
              </div>


              <?php

                  if ($team_size>0)
                  {

                          foreach($circle_team as $row)
                          {
                              $member_title = $row['title'];
                              $member_first_name = $row['first_name'];
                              $member_last_name = $row['last_name'];
                              $member_fullname = $member_title.' '.$member_last_name.' '.substr($member_first_name,0,1).'.';
                              $position = $row['position'];

                              $gradient = gradient();



              ?>
                    <!--Grid column-->
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4 mb-4">
                            <!-- Card //-->
                            <div class="card testimonial-card">
                                <!-- Background  color //-->
                                <div class="card-up <?php echo $gradient; ?>"></div>
                                <!--Avatar-->
                                <div class="avatar mx-auto"><img src="../../images/generic_avatar.jpg" class="rounded-circle img-responsive" alt="Example photo"></div>

                                <div class="card-body">
                                    <!--Name-->
                                    <h4 class="card-title mt-1"><?php echo $member_fullname; ?></h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><?php echo $position; ?> </p>
                                </div>

                            </div>

                            <!--Card-->

                        </div>
                    <!-- end of Grid column //-->
              <?php
                          } // end of foreach loop

                    } // end of team_size
                    else{
                        echo "No team member has been added to this Circle";
                    }

              ?>


      </div><!-- end of row //-->


      <!-- end of team display //-->






      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
