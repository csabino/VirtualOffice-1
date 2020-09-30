$(document).ready(function(){

   $("#btn_post_update").bind("click", function(){

        var user_id = $("#user_id").val();
        var task_id = $("#task_id").val();

        var task_update = $("#task_update").val();

        if (task_update!=''){
            $.post("../../async/server/task/post_update.php", {"user_id":user_id,
            "task_id":task_id, "task_update":task_update}, function(data){

                alert(data);
            });
        }

   });
})
