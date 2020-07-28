
<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>

<div class="container">


      <form class="md-form">
        <div class="file-field">
          <div class="btn btn-primary btn-sm float-left">
            <span>Choose file</span>
            <input type="file">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Upload your file">
          </div>
        </div>
      </form>

</div>



<?php

    //footer.php
    require('../includes/footer.php');
 ?>
