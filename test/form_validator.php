<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>


  <form class="needs-validation container" novalidate>
<div class="form-row">
<div class="mb-3 md-form">
<select class="mdb-select" required>
  <option value="1">USA</option>
  <option value="2">Germany</option>
  <option value="3">Poland</option>
</select>
<div class="invalid-feedback">Please select a country.</div>
</div>
</div>
<div class="form-row mb-4">
<div class="form-check pl-0">
<input class="form-check-input" type="checkbox" value="" id="invalidCheck29" required>
<label class="form-check-label" for="invalidCheck29">Agree to terms and conditions</label>
<div class="invalid-feedback">You shall not pass!</div>
</div>
</div>
<button class="btn btn-primary btn-sm btn-rounded" type="submit">Submit form</button>
</form>


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
      $('.mdb-select').materialSelect();
      $('.mdb-select.select-wrapper .select-dropdown').val("").removeAttr('readonly').attr("placeholder",
      "Choose your country ").prop('required', true).addClass('form-control').css('background-color', '#fff');
      });
 </script>
