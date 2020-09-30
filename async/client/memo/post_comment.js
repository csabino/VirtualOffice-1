$(document).ready(function(){

   $("#btn_post_comment").bind("click", function(){

        var user_id = $("#user_id").val();
        var memo_id = $("#memo_id").val();

        var comment = $("#comment").val();

        if (comment!=''){
            $.post("../../async/server/memo/post_comment.php", {"user_id":user_id,
            "memo_id":memo_id, "comment":comment}, function(data){

                alert(data);
            });
        }

   });
})
