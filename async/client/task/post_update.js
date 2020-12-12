$(document).ready(function(){

   $("#btn_post_update").bind("click", function(){

        var user_id = $("#user_id").val();
        var task_id = $("#task_id").val();
        var last_taskupdate_id = $("#last_taskupdate_id").val();
        var total_updates = $("#total_updates").text();

        var task_update = $("#task_update").val();

        if (task_update!=''){
            $.post("../../async/server/task/post_update.php", {"user_id":user_id,
            "task_id":task_id, "task_update":task_update}, function(data){
                var result = jQuery.parseJSON(data);

                if (result.status=='success')
                {
                  if (last_taskupdate_id==''){
                    $("#row_post_pane").prepend(result.output);
                  }else{
                    $("#"+last_taskupdate_id).before(result.output);
                  }

                  $("#last_taskupdate_id").val(result.lastTaskUpdateId);
                  total_updates++;
                  $("#total_updates").text(total_updates);
                  $("#task_update").val('');
                }



            });
        }

   });
})
