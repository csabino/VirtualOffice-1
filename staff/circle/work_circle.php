<?php

    $page_title = 'Work Circle';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");






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
      <div class="row">

            <?php
                
                $circle = new Circle();
                $my_circle = $circle->get_user_circle($_SESSION['loggedIn_profile_user_id']);
                //echo $my_circle->rowCount();
                foreach($my_circle as $mc){

            ?>


                  <div class="col-xs-11 col-sm-11 col-md-5 col-lg-5" style='padding:15px;'>
                        <?php
                              $color = color();
                              $style="font-size:30px;border-radius:120px;background-color:{$color};width:65px;padding:10px;";
                        ?>
                        <label class='text-center font-weight-bold' style="<?php echo $style; ?>">
                              <?php
                                  echo substr($mc['circle_name'], 0, 1);
                              ?>
                        </label>
                        <label class='ml-2'>
                        <?php

                              $circle_href = "circle_general_room.php?en=".mask($mc['cell_id'])."&us=".mask($_SESSION['ulogin_userid']);
                              $circle_general_room_link = "<a style='color:black;' href='{$circle_href}'>".$mc['circle_name']."</a>";
                              echo $circle_general_room_link;
                         ?>
                       </label>
                  </div>
            <?php
                }
            ?>
      </div>
      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
