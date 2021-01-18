<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    //require_once("../includes/logged_in_header.php");
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


<div id="calendar"></div>


<button type="button" class="btn btn-lg btn-primary" data-toggle="popover" title="Popover title" data-content="And here's some amazing content. It's very engaging. Right?">Click
  to toggle popover</button>


  <!--- Accordion //-->

  <!--Accordion wrapper-->
<div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="headingOne1">
      <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
        aria-controls="collapseOne1">
        <h5 class="mb-0">
          Collapsible Group Item #1 <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
      data-parent="#accordionEx">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
        labore sustainable VHS.
      </div>
    </div>

  </div>
  <!-- Accordion card -->

  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="headingTwo2">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
        aria-expanded="false" aria-controls="collapseTwo2">
        <h5 class="mb-0">
          Collapsible Group Item #2 <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
      data-parent="#accordionEx">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
        labore sustainable VHS.
      </div>
    </div>

  </div>
  <!-- Accordion card -->

  <!-- Accordion card -->
  <div class="card">

    <!-- Card header -->
    <div class="card-header" role="tab" id="headingThree3">
      <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
        aria-expanded="false" aria-controls="collapseThree3">
        <h5 class="mb-0">
          Collapsible Group Item #3 <i class="fas fa-angle-down rotate-icon"></i>
        </h5>
      </a>
    </div>

    <!-- Card body -->
    <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
      data-parent="#accordionEx">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
        labore sustainable VHS.
      </div>
    </div>

  </div>
  <!-- Accordion card -->

</div>
<!-- Accordion wrapper -->



  <!-- end of Accordion //-->


<?php

    //footer.php
    require('../includes/footer.php');
 ?>
 <script>
 $('#calendar').fullCalendar({
     header: {
         left: 'prev,next today',
         center: 'title',
         right: 'month,agendaWeek,agendaDay,listWeek'
     },
     defaultDate: '2018-11-16',
     navLinks: true,
     eventLimit: true,
     events: [{
             title: 'Front-End Conference',
             start: '2018-11-16',
             end: '2018-11-18'
         },
         {
             title: 'Hair stylist with Mike',
             start: '2018-11-20',
             allDay: true
         },
         {
             title: 'Car mechanic',
             start: '2018-11-14T09:00:00',
             end: '2018-11-14T11:00:00'
         },
         {
             title: 'Dinner with Mike',
             start: '2018-11-21T19:00:00',
             end: '2018-11-21T22:00:00'
         },
         {
             title: 'Chillout',
             start: '2018-11-15',
             allDay: true
         },
         {
             title: 'Vacation',
             start: '2018-11-23',
             end: '2018-11-29'
         },
     ]
 });
 </script>
