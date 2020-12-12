$(document).ready(function(){
//------------------------- Select Delete Post -------------------------------------------------------------
  $("body").on("click",".selectDeletePost", function(){
    var select_delete_post_id = $(this).attr('id').replace(/\D/g,'');
    $("#confirm_delete_post_id").val(select_delete_post_id);
    var confirmValue = $("#confirm_delete_post_id").val();
    //alert("Confirmed: " + confirmValue);
  });

//----------------------- End of Select Delete Post --------------------------------------------------------

//--------------------------- Delete Task Update-----------------------------------------------------------
  $("#delete_task_update").on("click", function(){

      var user_id = $("#user_id").val();
      var post_id = $("#confirm_delete_post_id").val();
      var task_id = $("#task_id").val();
      var total_updates = $("#total_updates").text();
      //alert("User_id: " + user_id + " Post Id: " + post_id + " Task_Id: " + task_id);
      $.ajax({
        method: "POST",
        url: "../../async/server/task/delete_update.php",
        data: {user_id:user_id, post_id:post_id, task_id:task_id},
        cache: false,
      }).done(function(data){
         var result = jQuery.parseJSON(data);
         if (result.status=='success'){
           $("#"+post_id).slideUp();
           total_updates--;
           $("#total_updates").text(total_updates);
         }
      });
  });
//---------------------------End of Delete Task Update---------------------------------------------------------


});
