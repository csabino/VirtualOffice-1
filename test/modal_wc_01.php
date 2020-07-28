<?php
    $page_title = 'My Dashboard';

    require_once('../baseurl.php');
    require_once("../includes/logged_in_header.php");
    require_once("../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");
  ?>


  <!-- Central Modal Warning Demo-->
  <div class="modal fade bottom" id="ModalWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-notify modal-primary modal-lg modal-bottom" role="document" >
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header" style='opacity:0.7'>
          <p class="heading">Welcome Message</p>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>

        <!--Body-->
        <div class="modal-body">

          <div class="row">
            <div class="col-3 text-center">
              <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(1).jpg" alt="IMG of Avatars"
                class="img-fluid z-depth-1-half rounded-circle">
              <div style="height: 10px"></div>
              <p class="title mb-0">Jane</p>
              <p class="text-muted " style="font-size: 13px">Consultant</p>
            </div>

            <div class="col-9">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga, molestiae provident temporibus
                sunt earum. The Project Investigation recently submitted proposed for a software for the optimisation of drilling hydraulics in drilling operations.

The key goal entirely in oil and gas production is to be able to produce in very large volumes by optimization in a cost-effective manner (Sangeetha, et al., 2019) Drilling problems like formation fracture ,kicks and wellbore instability occur as a result of poorly defined drilling fluid properties like rheological properties (viscosity) or even having an Equivalent Circulating Density(ECD) that is too high or too low during drilling operations .,and this often results in high drilling cost and this has been a frequent phenomenon in exploration and development of oil well drilling operations.
There have been advances in pre drilling modelling but recent study has it that 44% of (NPT) Non-Productive Time(According to Chapter 2.9) of major oil companies was linked to improper annular pressure data which resulted in wellbore instability and geopressured problems during drilling operations, and as a result costs the industry about $8 billion every year (Offshore, 2011).More so, there are  deeper oil wells in unfavourable geological locations  with severe climates conditions, hence,  there is an earnest demand for computerized applications  for an optimum drilling process.
This application seeks to bridge the gap between manual drilling processes that requires manual intervention of adjusting the weight on bit (WOB) of the drill string that only depends on the drilling expertise of a drilling engineer, and also to help mud Engineers in planning and real time  monitoring of drilling hydraulics used during the drilling process.
</p>
              <p class="card-text"><strong>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</strong></p>
            </div>
          </div>


        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <a type="button" class="btn btn-warning">Get it now <i class="far fa-gem ml-1 white-text"></i></a>
          <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal">No, thanks</a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!-- Central Modal Warning Demo-->

  <div class="text-center">
    <a href="" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#ModalWarning">Launch Modal
      Warning <i class="far fa-eye ml-1 text-white"></i></a>
  </div>





<br/><br/><br/>
<?php

    //footer.php
    require('../includes/footer.php');
 ?>

 <script>
    $(document).ready(function(){
          $("#ModalWarning").modal();
    });
 </script>
