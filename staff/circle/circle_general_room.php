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





    $page_title = 'Work Circle - General Room';

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
            <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-2 mb-4 font-weight-bold' >
                  <?php  echo $circle_name.$circle_short_name; ?>
            </div>
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab_active' >
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
            <div class='col-xs-12 col-sm-12 col-md-2 col-lg-2 mt-3 ml-2 sub_menu_tab'>
                  <?php
                        $general_link = "circle_files.php?en=".mask($_GET_URL_cell_id)."&us=".mask($_GET_URL_user_id);
                        echo "<a href='{$general_link}'>Files</a>";
                  ?>
            </div>

      </div>



      <!-- team display //-->

      <div class="row mt-5">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-3 text-info font-weight-bold" >
                    <big><i class="far fa-building"></i> General Room </big>
              </div>

              <!-- General Discussion  //-->
              <div id="post_window" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-4" style="height:350px; overflow:auto; border-bottom:2px solid #33b5e5;padding-bottom:2px;">
                  <?php
                      $lastPostId = 0;
                      $room = new GeneralRoom();
                      $post = $room->getPostsByCell($_GET_URL_cell_id);

                      foreach($post as $p){
                        $postId = $p['id'];
                        $user_id = $p['user_id'];
                        $title = $p['title'];
                        $lastname = $p['last_name'];
                        $firstname = $p['first_name'];
                        $message = nl2br(FieldSanitizer::outClean($p['message']));

                        $date_posted_raw = new DateTime($p['date_created']);
                        $date_posted = $date_posted_raw->format('D. jS M. Y');

                        $time_posted = $date_posted_raw->format('g:i a');

                        $avatar = '../images/avatar_100.png';

                        if ($p['avatar']!=''){
                          $avatar = '../avatars/'.$p['avatar'];
                        }

                        //generate delete link if comment is by same user
                        $delete_pane = '';
                        if ($user_id==$_GET_URL_user_id ){
                          $delete_pane = "<div id='delete{$postId}' data-toggle='modal' data-target='#confirmDelete' class='btn_delete text-danger px-2' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
                        }

                        //get $lastPostId
                        $lastPostId = $postId;


                  ?>

                                  <div class="row border-bottom py-3 z-depth-0 mt-3 postpackage" style='border-radius:0px;' id="<?php echo $postId; ?>" >
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                          <div class='px-2' style="float:left; border:0px solid red;">
                                              <img src="<?php echo $avatar; ?>" width="50px" class="img-fluid img-responsive z-depth-1 rounded-circle" />
                                          </div>
                                          <div style="float:left; width:80%; border:0px solid black;">
                                                <div class='px-2'>
                                                    <span id='user' class='font-weight-bold' ><small><strong><?php echo $title.' '.$lastname.' '.$firstname; ?></strong></small></span>&nbsp;&nbsp;
                                                    <span id='date_posted' class=''><small><?php echo $date_posted;  ?></small></span>&nbsp;
                                                    <span id="time_posted"><small><i class="far fa-clock"></i> <?php echo $time_posted; ?></small></span>
                                                </div>

                                                <div class='py-1 px-2' id='comment'> <?php echo $message; ?> </div>
                                                <?php echo $delete_pane; ?>
                                          </div>

                                      </div>

                                  </div>


                  <?php
                      }
                  ?>
              </div>
              <!-- end of General Discussions //-->


              <!-- Send post //-->
              <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                      <div class="form-group shadow-textarea">
                          <textarea id='post' class="form-control z-depth-1" rows="4" placeholder="Say something..." maxlength="200"></textarea>

                      </div>
                      <div class="text-right " id="lbl_character_size"><small>Remaining Characters : 160</small></div>

              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 py-3">
                   <button id='btnPost' class="btn btn-lg btn-blue"> Post</button>
              </div>

              <!-- end of post //-->


      </div>
      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type='hidden' id='cell_id' value="<?php echo $_GET_URL_cell_id; ?>" />
<input type="hidden" id='user_id' value="<?php echo $_GET_URL_user_id; ?>" />
<input type="hidden" id='last_post_id' value='<?php echo $lastPostId; ?>' />

<br/><br/><br/>
<?php

    //footer.php
    require('../../includes/footer.php');
 ?>


<script>


    $(document).ready(function(){

    setInterval(function(){
      getPostUpdate();
    }, 15000);
// --------------------------------- Scroll to bottom of DIC ---------------------------------------------------------------------
    scrollBottomOfMessagePane();


//---------------------------------- Post TextArea Key down-----------------------------------------------------------------------

          $("#post").on("keydown", function(e){
                if (this.value.length > 200){
                   return false;
                }

                $("#lbl_character_size").html("<small>Remaining characters : " + (200 - this.value.length) + "</small>");
          });
//--------------------------------- End of Post TextArea --------------------------------------------------------------------------

//------------------------------ BtnPost -------------------------------------------------------------------------------------

          $("#btnPost").on("click", function(){

              // Disable btnPost
              $(this).prop("disabled", true);


              // collect values into variables
              var cell_id = $("#cell_id").val();
              var user_id = $("#user_id").val();
              var post = $("#post").val();

              // clear post
              $("#post").val("");

              if (post!='' && cell_id!='' && user_id!=''){
                  $.ajax({
                    url: '../../async/server/general_room/post_message.php',
                    method: "POST",
                    data: {cell_id: cell_id, user_id: user_id, post: post},
                    dataType: 'html',
                    cache: false,
                    processdata: false,
                    beforeSend: function(){},
                    success: function(data){
                       if (data!=''){
                         getPostUpdate();
                       }
                    }
                  });
              }


              $(this).prop("disabled", false);

          }); // btnPost click


//--------------------------- getPostUpdate -----------------------------------------------------

   function getPostUpdate(){
       console.log("Inside get update");

       var cell_id = $("#cell_id").val();
       var user_id = $("#user_id").val();
       var lastPostId = $("#last_post_id").val();

       $.ajax({
           url: '../../async/server/general_room/get_new_messages.php',
           method: "POST",
           data: {cell_id: cell_id, last_post_id: lastPostId, user_id: user_id},
           dataType: 'html',
           cache: false,
           processdata: false,
           beforeSend: function(){},
           success: function(data){
             if (data!=''){
                 // Append data to post view pane
                 $("#post_window").append(data);

                 // update latest post id
                 var last_post_id = $(".postpackage:last").attr("id");
                 $("#last_post_id").val(last_post_id);

                 // scrollBottomMessage
                 scrollBottomOfMessagePane();

             }
           }
       });

   }

//--------------------------- End of getPostUpdate ------------------------------------------------


//-------------------------------------------------------------------------------------------------






//--------------------------------------------------------------------------------------------------


//----------------------------- Scroll Bottom function -------------------------------------------
  function scrollBottomOfMessagePane()
	{
		   $("#post_window").animate({"scrollTop": $("#post_window")[0].scrollHeight}, "slow");
	}

 //-----------------------------------------------------------------------------------------------

    });  // end of document ready


</script>
