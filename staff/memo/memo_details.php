<?php

  // get user eligibility
  if (!isset($_GET['q']) || $_GET['q']==''){
        header("location: ../my_dashboard.php");
  }

  // get user eligibility
  if (!isset($_GET['m']) || $_GET['m']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_memo_id = explode("-",htmlspecialchars(strip_tags($_GET['m'])));
  $_GET_URL_memo_id = $_GET_URL_memo_id[1];

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'Memo Details';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");






  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Memo Details </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- Task Information //-->
      <div class="row mt-5 px-1">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="far fa-newspaper"></i> Memo Details</big>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
                    <?php

                        $code1 = mask($_GET_URL_user_id);

                        $memos_link = "memos.php?q=".$code1;

                    ?>
                    <a href="<?php echo $memos_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-chevron-left"></i>&nbsp; Memos</a>
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
              </div>

              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 border" style="padding:0px;">
                  <?php
                      $memo = new Memo();
                      $get_memo = $memo->get_memo_by_id($_GET_URL_memo_id);

                      foreach($get_memo as $gm){
                        $memo_id = $gm['id'];
                        $title = FieldSanitizer::outClean($gm['subject']);
                        $remark = nl2br(FieldSanitizer::outClean($gm['remark']));
                        $first_name = FieldSanitizer::outClean($gm['first_name']);
                        $last_name = FieldSanitizer::outClean($gm['last_name']);
                        $author = $gm['title'].' '.$first_name.' '.$last_name;
                        $file_type = FieldSanitizer::outClean($gm['file_type']);
                        $file = FieldSanitizer::outClean($gm['file']);
                        $date_created_raw = new DateTime($gm['date_created']);
                        $date_created = $date_created_raw->format('l jS F, Y');
                        $time_created = $date_created_raw->format('g:i a');
                      }

                      $share_ref = "memo_share.php?q=".mask($memo_id)."&us=".mask($_GET_URL_user_id);
                      $share_link = "<small><a style='color:#666666;' title='Share this Memo with Others' href='{$share_ref}'><i class='fas fa-share-alt'></i> Share</a></small>";

                  ?>

                  <div class="py-2 px-2" id="announcement_header" style="background-color:#f1f1f1;">
                        <?php
                            echo "<div class='font-weight-bold'>".$title."</div>";
                            echo "<div><small><i class='far fa-user'></i> ".$author."&nbsp;&nbsp;&nbsp;<i class='far fa-calendar-alt'></i> "
                            .$date_created."&nbsp;&nbsp;&nbsp;<i class='far fa-clock'></i> ".$time_created."</small></div>";
                        ?>
                  </div>
                  <div class="px-2 py-2">

                      <?php
                            if ($file!=''){
                               if ($file_type=='document'){
                                 $file_size = filesize("../../uploads/memos/documents/${file}");
                                 if ($file_size<1000000){
                                    $file_size = round(($file_size/1024),2);
                                    $file_size = $file_size.' KB';
                                 } else{
                                    $file_size = round(($file_size/1024/1024),2);
                                    $file_size = $file_size.' MB';
                                 }

                                 $file_url = "<a target='_blank' href='../../uploads/memos/documents/${file}'>${file_type} Attachment (${file_size})</a>";
                               }else{
                                 $file_size = filesize("../../uploads/memos/images/${file}");
                                 if ($file_size<1000000){
                                    $file_size = round(($file_size/1024),2);
                                    $file_size = $file_size.' KB';
                                 } else{
                                    $file_size = round(($file_size/1024/1024),2);
                                    $file_size = $file_size.' MB';
                                 }
                                 $file_url = "<a target='_blank' href='../../uploads/memos/images/${file}'>${file_type} Attachment (${file_size})</a>";
                               }




                               echo "<small><i class='fas fa-paperclip'></i> $file_url </small>";
                            }

                       ?>
                  </div>
                  <div class='mt-1 mb-2 px-2' id='memo_body'>
                      <?php
                              echo ($remark);
                       ?>
                  </div>
                  <div class='px-2 mb-4'>
                      <?php
                              echo ($share_link);
                       ?>
                  </div>


              </div>
      </div>


      <!-- end of Task Information //-->

      <!-- update area //-->
      <div class="row py-2">
          <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-right">
              <div class="form-group blue-border-focus">
                  <textarea class="form-control" id="comment" row="3" placeholder="Comment ..."></textarea>
              </div>
          </div>
          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-left align-middle">
              <button id="btn_post_comment" class="btn btn-sm btn-primary align-middle">Post</button>
          </div>

      </div>
      <!-- end of update area //-->

      <!-- end of main area //-->
      <!-- comment listing //-->
      <div class="row">
          <?php

              $get_memo_comments = $memo->get_memo_comments($_GET_URL_memo_id);
              $total_comments = $get_memo_comments->rowCount();
          ?>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3">
              <strong>Comments (<span id='total_comments'><?php echo $total_comments; ?></span>)</strong>
          </div>
      </div>


      <!-- comment panal //-->
      <div id="comment-panel" class='py-2'>

      <?php
          $last_comment_id = 0;

          foreach($get_memo_comments as $gmc)
          {
            $commentId = $gmc['id'];
            $title = $gmc['title'];
            $firstname = $gmc['first_name'];
            $lastname = $gmc['last_name'];
            $author_id = $gmc['user_id'];
            $comment = nl2br(FieldSanitizer::outClean($gmc['comment']));
            $avatar = '../images/avatar_100.png';

            if ($gmc['avatar']!=''){
              $avatar = '../avatars/'.$gmc['avatar'];
            }

            $date_posted_raw = new DateTime($gmc['date_posted']);
            $date_posted = $date_posted_raw->format('D. jS M. Y');

            $time_posted = $date_posted_raw->format('g:i a');

            //generate delete link if comment is by same user
            $delete_pane = '';
            if ($author_id==$_GET_URL_user_id ){
              $delete_pane = "<div id='delete{$commentId}' class='btn_delete text-danger' style='cursor:pointer;'><small> <i class='fas fa-times text-danger'></i> Delete</small></div> ";
            }



      ?>

                <div class="row border py-3 z-depth-1 mt-3" style='border-radius:8px;' id="<?php echo $commentId; ?>" >
                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 text-left">
                        <div class='px-2' style="float:left; border:0px solid red;">
                            <img src="<?php echo $avatar; ?>" width="50px" class="img-fluid img-responsive z-depth-1 rounded-circle" />
                        </div>
                        <div style="float:left; border:0px solid black;">
                              <div>
                                  <span id='user'><?php echo $title.' '.$lastname.' '.$firstname; ?></span>&nbsp;&nbsp;
                                  <span id='date_posted'><small><?php echo $date_posted;  ?></small></span>&nbsp;
                                  <span id="time_posted"><small><?php echo $time_posted; ?></small></span>
                              </div>

                              <div id='comment'> <?php echo $comment; ?> </div>
                              <?php echo $delete_pane; ?>
                        </div>

                    </div>

                </div>




            <!-- end of comment listing //-->
      <?php

          }

       ?>
      </div> <!-- end of comment panel //-->

      <!-- end of comment panel //-->





  </div> <!-- end of container //-->

<br/><br/><br/>
<input type="hidden" id='user_id' value="<?php echo $_GET_URL_user_id; ?>" >
<input type="hidden" id="memo_id" value="<?php echo $_GET_URL_memo_id;  ?>" >

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
  <script src="../../async/client/memo/post_comment.js"></script>
