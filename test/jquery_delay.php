
<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>

<div class="container">

    <div class="row mt-5">

        <div id='mydiv' class="col-xs-1" style="background-color:#f1f1f1;" ></div>
        <div class='col-xs-12'>
            <button id='mybtn' class='btn btn-info button-sm btn-rounded'>Click Me</button>
        </div>
    </div>


</div>



<?php

    //footer.php
    require('../includes/footer.php');
 ?>
<script>
    $(document).ready(function(){


        $("#mybtn").bind("click", function(){

              $("#mydiv").text("I am here.. testing that things are working well...");
              $("#mydiv").css({"backgroundColor":"purple","color":"white"});
              $("#mydiv").hide()
              .slideDown()
              .delay(5000)
              .fadeOut(5000);

        })
    });

</script>
