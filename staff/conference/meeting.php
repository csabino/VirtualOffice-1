<?php

  // get user eligibility
  if (!isset($_GET['en']) || $_GET['en']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'Memos';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");






  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Meeting </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- list of tasks //-->
      <div class="row mt-5">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <form id="createRoom">
                  <input id="sessionInput" />
                  <button type="submit">Create it</button>
              </form>
          </div>
      </div>

      <div id="roomLink" style="font-size:18px;color:#F00;"></div>
      <video id="localVideo" width="180" style="margin-top:15px;"></video>
      <div id="remotes"></div>


      <!-- end of list of tasks //-->

      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
<script src="https://sandbox.simplewebrtc.com:443"></script>
<script src="ps-webrtc-simplewebrtc.js"></script>
<script src="../../lib/js/custom/tblData.js"></script>
