$(document).ready(function() {

//----------------------------------------------------------------------------

//$("#progress").css({"font-weight":"bold", "color":"red"});
  set_status_switchbox();

//---------------------------------------------------------------------------

const $valueSpan = $('.valueSpan2');
const $value = $('#customRange11');
$valueSpan.html($value.val());
$value.on('input change', () => {

  $valueSpan.html($value.val());
  $("#progress_value").val($value.val());
});

//---------------------  Status Lever change (Status) ----------------------

$("#chk_status").on("click", function(){
     set_status_switchbox();

})

function set_status_switchbox(){
      //alert("change");

     if($("#chk_status").is(":checked")){

       $("#completed").css({"font-weight":"bold", "color":"green"});
       $("#progress").css({"font-weight":"300", "color":"#333333"});

       $("#status_value").val("Completed");

     }else{

       //$("#chk_status").prop('checked', false);
       $("#completed").css({"font-weight":"300", "color":"#333333"});
       $("#progress").css({"font-weight":"bold", "color":"red"});

       $("#status_value").val("In progress");
     }
}
//-------------------- End of Status Lever change (Progress)-------------------

//--------------------- Button update Status ----------------------------------
$("#btn_update").on("click", function(event){
    event.preventDefault();
    var status_value = $("#status_value").val();
    var progress_value = $("#progress_value").val();
    var task_id = $("#task_id").val();




        // ----- ajax  -----
          $.ajax({
              url: '../../async/server/task/update_task_status.php',
              method: "POST",
              data: {status: status_value, progress: progress_value, task_id: task_id},
              dataType: 'json',
              cache: false,
              beforeSend: function(){},
              success: function(data){

                  var result = data['status'];
                  if (result=='success'){
                    var success_message = "<div class='alert alert-success mb-2' role='alert'>The <strong>Task Status</strong> has been successfully updated.</div>";
                    $("#update_status_message").html(success_message).slideDown().delay(5000).slideUp(2000);
                  }else{
                    var error_message = "<div class='alert alert-danger mb-2' role='alert'>No change is noticed, hence no update is performed. Make a change and update.</div>";
                    $("#update_status_message").html(error_message).slideDown().delay(5000).slideUp(2000);
                  }
              }
          });
         //------- end of ajax



})


//---------------------- End of Button update status --------------------------------------------------

}); // end of document ready
