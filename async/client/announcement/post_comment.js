$(document).ready(function(){

  $("#btn_send_comment").bind("click", function(){
     var comment = $("#comment").val();
     var user_id = $("#announcement_id").val();
     var announcement_id = $("#user_id").val();

     // verify that comment is not _blank
     if (comment!='' && user_id!='' && announcement_id!='')
     {
       $.post("../../async/server/announcement/post_comment.php",{"user_id":user_id, "announcement_id": announcement_id,
          "comment":comment},function(data){

            alert(data);

        });
     } // end of check for blank comment



  }); // end of btn_send_comment


});
