$(document).ready(function(){

  $("#btn_send_comment").bind("click", function(){

    $(this).prop("disabled", true);
     var comment = $("#comment").val();
     var announcement_id = $("#announcement_id").val();
     var last_comment_id = $("#last_comment_id").val();
     var user_id = $("#user_id").val();
     var total_comments = $("span#total_comments").text();

     // verify that comment is not _blank
     if (comment!='' && user_id!='' && announcement_id!='')
     {
       $.post("../../async/server/announcement/post_comment.php",{"user_id":user_id, "announcement_id":announcement_id,
          "comment":comment, "last_comment_id":last_comment_id},function(data){

            //prepend data as result
            //alert(data);
            $("#comment-panel").prepend(data);
            var updated_last_comment_id = $("#comment-panel").children(".row").first().attr("id");
            $("#last_comment_id").val(updated_last_comment_id);

            // Clear the comment textarea
            $('#comment').val('')

            // total comments + 1
            total_comments = parseInt(total_comments)  + 1;


            // write it back into span
            $("span#total_comments").text(total_comments);

            //Enable the Send Comment Button
            $("#btn_send_comment").prop("disabled", false);


        });
     } // end of check for blank comment



  }); // end of btn_send_comment

//-----------------------------------------------------------------------------------------------------------



  //button Delete Comment
  $(document).on("click", ".btn_delete", function(){
      var announcement_id = $("#announcement_id").val();
      var user_id = $("#user_id").val();
      var total_comments = $("span#total_comments").text();

      //var item_id = $(this).attr('id').match(/\d+/);
      var item_id = $(this).attr('id').replace(/\D/g,'');
      //alert(item_id);
      $.post("../../async/server/announcement/delete_comment.php",{"comment_id":item_id,"user_id":user_id,
      "announcement_id":announcement_id}, function(data){

        if (data==1){
             $(".row#"+item_id).slideUp(1000).delay(1000).prev('hr').remove();
             //$(".row#"+item_id).next('hr').remove();
             //$(".row#"+item_id).;
             // total comments - 1
             total_comments = parseInt(total_comments)  - 1;


             // write it back into span
             $("span#total_comments").text(total_comments);

        }


      });

  });

});
