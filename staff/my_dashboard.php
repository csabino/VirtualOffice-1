<?php

    $page_title = 'My Dashboard';

    require_once("../core/wp_config.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");

    $user = new StaffUser();



    if (isset($_SESSION['loggedIn_profile_user_id'])){




        //echo "Other times -".$_SESSION['loggedIn_profile_avatar'];
        //echo $_SESSION['ulogin_id'];
        //echo $_SESSION['ulogin_userid'];


    }else{
        // get user profile information
        //echo "first launch";
        //echo $_SESSION['ulogin_userid'];
        //echo "<br/>";
        $user_profile = $user->get_user_by_id($_SESSION['ulogin_userid']);
        $user_title; $first_name; $last_name; $other_names;
        foreach($user_profile as $up){
            $_SESSION['loggedIn_profile_title'] = $up['title'];
            $_SESSION['loggedIn_profile_firstname'] = $up['first_name'];
            $_SESSION['loggedIn_profile_lastname'] = $up['last_name'];
            $_SESSION['loggedIn_profile_other_names'] = $up['other_names'];
            $_SESSION['loggedIn_profile_avatar'] = $up['avatar'];
        }
        $_SESSION['loggedIn_profile_user_id'] = $_SESSION['ulogin_userid'];
        $_SESSION['loggedIn_profile_file_no'] =   $_SESSION['ulogin_fileno'];
    }






    // Declare Auth class and execute methods
    $auth = new Auth();
    $already_logged_in = $auth->is_firstLogin($_SESSION['ulogin_userid'])->rowCount();
    if ($already_logged_in==0){
        // Retrieve Platform-wide Welcome message
        $notice_board =  new NoticeBoard();
        $onboard_result = $notice_board->onBoarding();

        // Check if there is an onboarding message to present to users
        if ($onboard_result->rowCount()){
              $onboarding_cell = '';
              $onboarding_subject = '';
              $onboarding_message = '';
              $onboarding_sender = '';
              $onboarding_date_created = '';

              //iterating through NoticeBoard for Last OnBoarding
              foreach($onboard_result as $row){
                  $onboarding_cell = $row['cell'];
                  $onboarding_subject = $row['subject'];
                  $onboarding_message = FieldSanitizer::outClean($row['message']);
                  $onboarding_sender = $row['sender'];
                  $onboarding_sender_position = $row['sender_position'];

                  //Get User Details
                  $user = new StaffUser();
                  $onboard_sender = $user->getUserById($onboarding_sender);

                  $onboarding_sender_title = '';
                  $onboarding_sender_fname = '';
                  $onboarding_sender_lname = '';
                  $onboarding_sender_onames = '';
                  $onboarding_sender_avatar = '';

                  foreach ($onboard_sender as $row){
                      $onboarding_sender_title = $row['title'];
                      $onboarding_sender_fname = $row['first_name'];
                      $onboarding_sender_lname = $row['last_name'];
                      $onboarding_sender_onames = $row['other_names'];
                      $onboarding_sender_avatar = $row['avatar'];
                  }
                  // End of User Details




                  include("../functions/OnBoarding.php");
              } // end of iterating through NoticeBoard for Last OnBoarding

        } // end of Check of there is an onboarding message to present to users


    } // end of already-logged in


  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>My Dashboard </h3>
              <?php
                  //date_default_timezone_set('Africa/Lagos');
                  //$tokyo = new DateTimeZone('Asia/Tokyo');
                  $nigeria = new DateTimeZone('Africa/Lagos');
                  $now = new DateTime('now', $nigeria);
                  $time = $now->format('g:i A');
                  $hour = $now->format('g');
                  $meridiem = $now->format('A');
                  //echo $time;

                  $salutation = '';
                  if ($meridiem=='AM'){
                      $salutation = "Good Morning, ";
                  }else{
                      if ($hour==12 || $hour<4){
                          $salutation = "Good Afternoon, ";
                      }else{
                          $salutation = "Good Evening, ";
                      }
                  }
                  echo "<span class='font-weight-light'>".$salutation.' '.$_SESSION['loggedIn_profile_title'].' '.$_SESSION['loggedIn_profile_firstname'].' '.$_SESSION['loggedIn_profile_lastname']."</span>";
              ?>
          </div>

      </div>
      <!-- end of page header //-->

      <!-- notification bar //-->
      <div class="row mt-3">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="alert alert-success" role="alert">
                    <h5 class="alert-heading">Notifications</h5>

                    <!--
                        <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
                        <hr>
                        <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
                    //-->
            </div>
          </div>
      </div>
      <!-- end of notification bar //-->

      <!-- Feature containers //-->
      <div class="row d-flex justify-content-center">

          <!--  My Circle  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->

                  <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>
                       <a href="<?php echo $baseUrl.'staff/circle/work_circle.php'; ?>">
                         <h4><i class="fas fa-users"></i><br/>My Circles</h4>
                       </a>
                  </div>

              <!-- end of container //-->

          </div>
          <!--  end of My Circle //-->


          <!--  Memo  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>
                    <a href="<?php echo $baseUrl.'staff/memo/memos.php?en='.mask($_SESSION['ulogin_userid']); ?>">
                      <h4><i class="far fa-file-alt"></i><br/>Memos</h4>
                    </a>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Memo //-->


          <!--  Projects  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>
                   <a href="<?php echo $baseUrl.'staff/circle/work_circle.php'; ?>">
                      <h4><i class="fas fa-project-diagram"></i><br/>Projects</h4>
                   </a>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Projects //-->

          <!--  Tasks  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>
                   <a href="<?php echo $baseUrl.'staff/task/tasks.php?en='.mask($_SESSION['ulogin_userid']); ?>">
                      <h4><i class="fas fa-list-ol"></i><br/>Tasks</h4>
                   </a>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Tasks //-->

          <!--  Meeting  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>
                   <a href="<?php echo $baseUrl.'staff/meeting/meetings.php?en='.mask($_SESSION['ulogin_userid']); ?>">
                      <h4><i class="fas fa-video"></i><br/>Meetings</h4>
                   </a>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Meeting //-->


          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>

                   <h4><i class="far fa-comments"></i><br/>Discussions</h4>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->


          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>
                   <a href="<?php echo $baseUrl.'staff/circle/work_circle.php'; ?>">
                      <h4><i class="fas fa-bullhorn"></i><br/>Announcements</h4>
                   </a>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->


          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>

                   <h4><i class="far fa-clipboard"></i><br/>Reports</h4>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->


          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>

                   <h4><i class="far fa-sticky-note"></i><br/>Notes</h4>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->


          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>

                   <h4><i class="far fa-copy"></i><br/>Files</h4>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->


          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>

                   <h4><i class="far fa-envelope"></i><br/>Messages</h4>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->

          <!--  Discussions  //-->
          <div class="col-x-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center mt-2 mb-2">
              <!-- container //-->
              <div class='border text-center rounded z-depth-3' style='width:90%;padding:20px;'>

                   <h4><i class="fas fa-user-friends"></i><br/>Co-workers</h4>
              </div>
              <!-- end of container //-->

          </div>
          <!--  end of Discussions //-->





      </div>
      <!-- end of Feature containers //-->




  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='is_firstLogin' value="<?php echo $already_logged_in; ?>" />
<?php

    //footer.php
    require('../includes/footer.php');
 ?>
 <script>
      $(document).ready(function(){
          var user_already_logged_in = $("#is_firstLogin").val();
          if (user_already_logged_in==0){
              $("#ModalOnBoarding").modal();
          }
      });


      // popovers Initialization
      // popovers Initialization
      $(function () {
        $('[data-toggle="popover"]').popover()
      })

      // Data Picker Initialization
      $('.datepicker').datepicker();
 </script>
