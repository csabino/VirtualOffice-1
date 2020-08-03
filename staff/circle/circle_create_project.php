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





    $page_title = 'Work Circle - Create Project';

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






      <!-- Projects //-->
      <div class="row mt-5">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-business-time"></i> Create Project</big>
              </div>



              <!-- stepper panel //-->
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                      <!-- Stepper widget //-->
                      <ul class="stepper linear horizontal " style="height:560px;">
                            <!-- Step 1 //-->
                            <li class="step active">
                                <div data-step-label="" class="step-title waves-effect waves-dark">Step 1 - Definition</div>
                                <div class="step-new-content">
                                    <div class="row">
                                          <?php
                                                include_once("circle_create_project_definition.php");
                                           ?>
                                    </div>
                                    <div class="step-actions py-8">
                                        <button id="step1_continue" class="waves-effect waves-dark btn btn-sm btn-primary next-step">CONTINUE</button>
                                    </div>
                                </div>
                            </li>
                            <!-- end of step 1 //-->


                            <!-- Step 2 //-->
                            <li class="step">
                                <div class="step-title waves-effect waves-dark">Step 2 - Checklist</div>
                                <div class="step-new-content">
                                    <div class="row">
                                        <?php
                                              include_once("circle_create_project_checklist.php");
                                         ?>
                                    </div>
                                    <div class="step-actions">
                                        <button class="waves-effect waves-dark btn btn-sm btn-primary next-step">CONTINUE</button>
                                        <button id='step2_back' class="waves-effect waves-dark btn btn-sm btn-secondary previous-step">BACK</button>
                                    </div>
                                </div>
                            </li>
                            <!-- end of Step 2 //-->


                            <!-- Step 3 //-->
                            <li class="step">
                                <div class="step-title waves-effect waves-dark">Step 3 - Milestone</div>
                                <div class="step-new-content">
                                  <div class="row">
                                      <?php
                                            include_once("circle_create_project_milestones.php");
                                       ?>
                                  </div>

                                    <div class="step-actions">
                                        <button class="waves-effect waves-dark btn btn-sm btn-primary m-0 mt-4" type="button">SUBMIT</button>
                                    </div>
                                </div>
                            </li>
                      </ul>
                      <!-- end of Stepper widget //-->




              </div><!-- end of stepper panel //-->
      </div>
      <!-- end of Projects //-->



      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type="hidden" name="cell_id" id="cell_id" value="<?php echo $_GET_URL_cell_id ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $_GET_URL_user_id; ?>">

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>


 // Stepper JavaScript
  <script type="text/javascript" src="../../lib/js/addons-pro/stepper.js"></script>

 // Stepper JavaScript - minified
  <script type="text/javascript" src="../../lib/js/addons-pro/stepper.min.js"></script>



  <script src="../../lib/js/custom/circle/project-stepper.js"></script>
  <script src="../../lib/js/custom/circle/from-to-date.js"></script>
  <script src="../../lib/js/custom/circle/stepper-buttons-functions.js"></script>

  <script>

  //-------------------

  $("#btn_create_project").bind("click", function(e){

       var btn_text = $("#btn_create_project").text();
       if (btn_text=='Create Project'){
           //check if  title is filled in
           if ($("#title").val()!=''){
                 create_project();

           }


       }else if(btn_text=='Project Created'){
           if ($("#title").val()!=''){
                 update_project();
           }

       }
  });


  //------------------------------------------------------------------------------------------------------

  // Create Project
  function create_project(){
      var cell_id = $("#cell_id").val();
      var creator = $("#user_id").val();
      var title = $("#title").val();
      var description = $("#description").val();
      var startDate = $("input#startingDate").val();
      var endDate = $("input#endingDate").val();
      var source = 'circle';
      var operation = '';

      alert(endDate);

      $.ajax({
          url: '../../async/server/projects/create_project.php',
          method: "POST",
          data: {cell_id: cell_id, creator: creator, title: title, description: description, startDate: startDate, endDate: endDate, source: source, operation: 'create'},
          dataType: 'json',
          cache: false,
          processdata: false,
          beforeSend: function(){
                console.log("Creating Project");
          },
          success: function(data){
              alert(data);
          }

      });





    }





  </script>
