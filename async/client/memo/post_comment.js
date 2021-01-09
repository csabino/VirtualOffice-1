$(document).ready(function(){

   $("#btn_post_comment").bind("click", function(){

        var user_id = $("#user_id").val();
        var memo_id = $("#memo_id").val();
        var last_comment_id = $("#last_comment_id").val();
        var total_comments = $("#total_comments").text();

        var comment = $("#comment").val();

        if (comment!=''){
            $.post("../../async/server/memo/post_comment.php", {"user_id":user_id,
            "memo_id":memo_id,"last_comment_id":last_comment_id,"comment":comment}, function(data){
                var result = jQuery.parseJSON(data);
                if (result.status=='success'){
                  //alert(result.output);
                  $("#comment-panel").prepend(result.output);
                  $("#comment").val("");
                  total_comments++;
                  $("#total_comments").text(total_comments);
                  //$("#comment-panel").children().first().(5000);
                }
            });
        }

   });
})
