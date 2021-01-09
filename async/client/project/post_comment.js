$(document).ready(function(){

  $("#btn_send_comment").bind("click", function(){

    $(this).prop("disabled", true);
    var comment = $("#comment").val();
    var project_update_id = $("#project_update_id").val();
    var user_id = $("#user_id").val();
    var last_comment_id = $("#last_comment_id").val();
    var total_comments = $("span#total_comments").text();

    if (comment!='' && project_update_id!=''){

        $.post("../../async/server/projects/post_comment.php",{"user_id":user_id,"project_update_id":project_update_id,
        "comment":comment, "last_comment_id":last_comment_id}, function(data){
            // prepend data as $result
            $("#comment-panel").prepend(data);

            var updated_last_comment_id = $("#comment-panel").children(".row").first().attr("id");
            $("#last_comment_id").val(updated_last_comment_id);

            //slideDown animation latest post
            $(".row#"+updated_last_comment_id).hide().slideDown(1000);

            // Clear the comment textarea
            $('#comment').val('')

            // total comments + 1
            total_comments = parseInt(total_comments)  + 1;


            // write it back into span
            $("span#total_comments").text(total_comments);

            //Enable the Send Comment Button
            $("#btn_send_comment").prop("disabled", false);

        });
    } //end of if statement
















  }); // end of btn_send_comment






//-----------------------------------------------------------------------------------------------------------
// Select Delete Comment
  $(document).on("click",".btn_select_delete", function(){
      var comment_id = $(this).attr("id").replace(/\D/g,'');
      $("#selected_del_comment_id").val(comment_id);

  });
//-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------



  //button Delete Comment
  $(document).on("click", "#btn_delete", function(){

      var project_update_id = $("#project_update_id").val();
      var user_id = $("#user_id").val();
      var total_comments = $("span#total_comments").text();
      var comment_id = $("#selected_del_comment_id").val()
      //var item_id = $(this).attr('id').match(/\d+/);
      //var item_id = $(this).attr('id').replace(/\D/g,'');
      //alert(item_id);

      $.post("../../async/server/projects/delete_comment.php",{"comment_id":comment_id,"user_id":user_id,
      "project_update_id":project_update_id}, function(data){

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
      //reload page
      location.reload(true);
  });

});

//----------------------------------------------------------------------------------------------------------
