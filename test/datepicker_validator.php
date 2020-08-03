 <?php

    if (isset($_POST['btnSubmit'])){
        $date = $_POST['date'];
        echo $date;
    }

    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>
<form class="needs-validation container" novalidate action="datepicker_validator.php" method="post" >
  <div class="mb-3 md-form">
    <input type="text" name="date" id="date" name="date" class="form-control datepicker" value="" required />
    <label for="date">Date</label>
    <div class="invalid-feedback">Please select a valid date.</div>
  </div>

  <div class="form-row my-4">
    <div class="form-check pl-0">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck266" required>
      <label class="form-check-label" for="invalidCheck266">Agree to terms and conditions</label>
      <div class="invalid-feedback">You shall not pass!</div>
    </div>
  </div>
  <button name="btnSubmit" class="btn btn-primary btn-sm btn-rounded" type="submit">Submit form</button>
</form>

<div class="chip" style="background-color:pink;">
 <img class="border-1" src="https://mdbootstrap.com/img/Photos/Avatars/avatar-6.jpg" alt="Contact Person"> Babarinde Oluwaseyi Abiodun
</div>



<button type="button" mdbBtn color="default" class="waves-light"
    mdbPopover="And here some amazing content. It's very engaging. Right?"
    placement="right"
    mdbPopoverHeader="Popover on right" mdbWavesEffect>
    Popover on right
  </button>

  <button type="button" mdbBtn color="default" class="waves-light"
    mdbPopover="And here some amazing content. It's very engaging. Right?"
    placement="bottom"
    mdbPopoverHeader="Popover on bottom" mdbWavesEffect>
    Popover on bottom
</button>

  <button type="button" mdbBtn color="default" class="waves-light"
    mdbPopover="And here some amazing content. It's very engaging. Right?"
    placement="left"
    mdbPopoverHeader="Popover on left" mdbWavesEffect>
    Popover on left
  </button>

  <button type="button" mdbBtn color="default" class="waves-light"
    mdbPopover="And here some amazing content. It's very engaging. Right?"
    placement="top"
    mdbPopoverHeader="Popover on top" mdbWavesEffect>
    Popover on top
  </button>


<?php

    //footer.php
    require('../includes/footer.php');
 ?>

<script>
    (function() {
    'use strict';
    window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
    event.preventDefault();
    event.stopPropagation();
    }
    form.classList.add('was-validated');
    }, false);
    });
    }, false);
    })();

    $(document).ready(function() {
    $('.datepicker').pickadate();
    $('.datepicker').removeAttr('readonly');
    });
</script>
