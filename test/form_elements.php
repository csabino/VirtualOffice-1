<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>

<div class="container">
  <form>
    <div class="form-row">
      <div class="col-md-4 mb-3 md-form">
        <label for="validationServer015">First name</label>
        <input type="text" class="form-control is-valid" id="validationServer015" value="Mark" required>
        <div class="valid-feedback">
          Looks good!
        </div>
      </div>
      <div class="col-md-4 mb-3 md-form">
        <label for="validationServer025">Last name</label>
        <input type="text" class="form-control is-valid" id="validationServer025" value="Otto" required>
        <div class="valid-feedback">
          Looks good!
        </div>
      </div>
      <div class="col-md-4 mb-3 md-form">
        <label for="validationServerUsername55">Username</label>
        <input type="text" class="form-control is-invalid" id="validationServerUsername55" required>
        <div class="invalid-feedback">
          Please choose a username.
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-6 mb-3 md-form">
        <label for="validationServer035">City</label>
        <input type="text" class="form-control is-invalid" id="validationServer035" required>
        <div class="invalid-feedback">
          Please provide a valid city.
        </div>
      </div>
      <div class="col-md-3 mb-3 md-form">
        <label for="validationServer045">State</label>
        <input type="text" class="form-control is-invalid" id="validationServer045" required>
        <div class="invalid-feedback">
          Please provide a valid state.
        </div>
      </div>
      <div class="col-md-3 mb-3 md-form">
        <label for="validationServer055">Zip</label>
        <input type="text" class="form-control is-invalid" id="validationServer055" required>
        <div class="invalid-feedback">
          Please provide a valid zip.
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-check pl-0 md-form m-0">
        <input class="form-check-input is-invalid" type="checkbox" value="" id="invalidCheck35" required>
        <label class="form-check-label" for="invalidCheck35">
          Agree to terms and conditions
        </label>
      </div>
      <div class="invalid-feedback mt-3 ml-4">
        You must agree before submitting.
      </div>
    </div>
    <button class="btn btn-primary btn-sm btn-rounded" type="submit">Submit form</button>
  </form>
</div>


<?php

    //footer.php
    require('../includes/footer.php');
 ?>
