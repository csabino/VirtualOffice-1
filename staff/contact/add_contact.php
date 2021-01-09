<?php

  // get user eligibility
  if (!isset($_GET['en']) || $_GET['en']==''){
        header("location: ../my_dashboard.php");
  }

  $_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['en'])));
  $_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'Add Contact';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");






  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header //-->
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Contacts </h3>
          </div>
      </div>
      <!-- end of page header //-->



      <!-- main page area //-->
      <!-- list of tasks //-->
      <div class="row mt-5">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-3 text-info font-weight-bold" >
                    <big><i class="fas fa-user-plus"></i> Add Contact</big>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                    <?php

                        $code1 = mask($_GET_URL_user_id);

                        //$create_task_link = "create_contact.php?q=".$code1;

                    ?>

                  <!--  <a href="<?php  //echo $create_task_link; ?>" class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-plus"></i>&nbsp; New Task</a> //-->

              </div>

              <!-- main body area  //-->

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                    $form_action_link = 'add_contact.php?en='.$code1;
                ?>
                <form class="border border-light p-4" style="border-radius:5px;"
                  name="create contact" action="<?php echo htmlspecialchars($form_action_link); ?>"
                  method="post">

                  <!-- Postback feedback //-->


                  <!-- End of postback feedback //-->
                  <!-- Find User by File No. //-->
                  <label for="file_no" class="text-info font-weight-normal">File No.<span class='text-danger'></span></label>
                  <input type="text" id="file_no" name="file_no" class="form-control mb-3" placeholder="Find User By File No." required>
                  <button type='submit' name='btnSubmit' class="btn btn-sm btn-primary btn-rounded"> <i class="fas fa-chevron-left"></i> Search</button>
                </form>
              </div>


              <!-- end of main body area  //-->
      </div>

      <!-- end of main area //-->
      <div class="row mt-5">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <form class="border border-light p-4" style="border-radius:5px;" name="add contact"
          action="<?php echo htmlspecialchars($form_action_link); ?>" method="post">
                <?php
                    if (isset($_POST['btnSubmit'])){
                       $file_no = FieldSanitizer::inClean($_POST['file_no']);

                       $contact = new Contact();
                       $result = $contact->findUser($file_no);


                       if ($result->rowCount()){

                       }else{


                       }

                    }

                ?>
          </form>
        </div>
      </div>


  </div> <!-- end of container //-->

<br/><br/><br/>
<input type="hidden" id="selected_del_task_id"/>
<input type="hidden" id="current_user_id" value="<?php echo $_GET_URL_user_id; ?>" />

<!--    //-->


<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDelete"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Do you really wish to delete this record? <br/>
        <small>Note: This action is not reversible.</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
        <button type="button" id="delete_task" class="btn btn-danger" data-dismiss="modal"><i class="far fa-trash-alt"></i> Delete</button>
      </div>
    </div>
  </div>
</div>



<!--  //-->






<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
  <script src="../../lib/js/custom/tblData.js"></script>
  <script>
    $("body").on("click","#delete_task",function(){
         var task_id = $("#selected_del_task_id").val();
         var current_user_id = $("#current_user_id").val();

         //-------------------- Ajax module -----------------------------------
         $.ajax({
           method: "POST",
           url: "../../async/server/task/delete_task.php",
           data: {user_id: current_user_id, task_id: task_id},
           cache: false,
         }).done(function(data){
            var result = jQuery.parseJSON(data);
            alert(result.status);
         });
         //--------------------end of Ajax module ------------------------------

         //reload page
         location.reload(true);
    });

    $("body").on("click",".sel_delete_task",function(){
        var task_id = $(this).attr("id").replace(/\D/g,'');
        $("#selected_del_task_id").val(task_id);

    });

  </script>
