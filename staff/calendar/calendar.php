<?php

  // get user eligibility
  if (!isset($_GET['en']) || $_GET['en']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'Calendar';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");






  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Calendar </h3>
          </div>
      </div>
      <!-- end of page header //-->

      <!-- body of calendar //-->

      <div class="row mt-3 mb-5">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <iframe src="https://calendar.google.com/calendar/embed?src=c_jtp66b9u03mtgd0b16hafeqlms%40group.calendar.google.com&ctz=Africa%2FLagos"
              style="border: 0" width="900" height="500" frameborder="0" scrolling="no"></iframe>
          </div>

      </div>

      <br/><br/>

  </div>



















  <?php

      //footer.php
      require('../../includes/footer.php');
   ?>
