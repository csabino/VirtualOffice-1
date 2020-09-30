$(document).ready(function(){

   $("#btn_share_memo").bind("click", function(){

        var sender = $("#user_id").val();
        var memo_id = $("#memo_id").val();
        var recipient_fileno = $("#user_fileno").val();

        if (recipient_fileno!=''){
            $.post("../../async/server/memo/share_memo.php", {"sender":sender,
            "memo_id":memo_id, "recipient_fileno":recipient_fileno}, function(data){

                alert(data);
            });
        }



   });
})
