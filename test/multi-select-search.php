<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>
<div class="container">
  <select class="mdb-select md-form">
      <option value="" disabled selected>Choose your option</option>
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
    </select>
</div>


<?php

    //footer.php
    require('../includes/footer.php');
 ?>

<script>
            $(document).ready(function() {
              $('.mdb-select').materialSelect();
            });
</script>
