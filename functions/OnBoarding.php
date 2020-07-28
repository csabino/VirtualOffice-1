
  <!-- Central Modal -->
  <div class="modal fade bottom" id="ModalOnBoarding" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-notify modal-primary modal-lg modal-bottom" role="document" >
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header" style='opacity:0.7'>
          <p class="heading" style="font-weight:bold"><?php echo $onboarding_subject;  ?></p>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times;</span>
          </button>
        </div>





        <!--Body-->
        <?php
              $avatar = "{$baseUrl}images/avatars/".$onboarding_sender_avatar;
         ?>

        <div class="modal-body">

          <div class="row">
            <div class="col-3 text-center">
              <img src="<?php echo $avatar; ?>" alt="User Avatar"
                class="img-fluid z-depth-1-half rounded-circle">
              <div style="height: 10px"></div>
              <p class="title mb-0 font-weight-normal"><?php echo $onboarding_sender_title.' '.$onboarding_sender_fname.' '.$onboarding_sender_lname; ?></p>
              <p class="text-muted " style="font-size: 13px"><?php echo $onboarding_sender_position; ?></p>
            </div>

            <div class="col-9 font-weight-normal"  >
              <p>
                  <?php echo nl2br($onboarding_message); ?>
              </p>

              <p class="card-text"><strong> </strong></p>
            </div>
          </div>


        </div>

        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <a type="button" class="btn btn-warning" data-dismiss>Update your Profile<i class="far fa-user ml-1 white-text"></i></a>
          <a type="button" class="btn btn-outline-warning waves-effect" data-dismiss="modal"> Your Feedback </a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!-- Central Modal -->
