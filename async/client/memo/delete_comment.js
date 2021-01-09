$(document).ready(function(){
  //-----------------------------------------------------------------------------------
      $('body').on('click', '.btn_delete', function(){
          var select_del_memo_comment_id = $(this).attr("id").replace(/\D/g,'');
          $("#select_del_memo_comment_id").val(select_del_memo_comment_id);
          //alert(select_del_memo_comment_id);
      });

     //-----------------------------------------------------------------------------------
      $('body').on('click', '#delete_memo_comment', function(){
          var select_del_memo_comment_id = $("#select_del_memo_comment_id").val();
          var user_id = $("#user_id").val();
          var total_comments = $("#total_comments").text();

          //--------------------- Ajax module ----------------------------------------
          $.ajax({
            method: "POST",
            url: "../../async/server/memo/delete_comment.php",
            data: {user_id:user_id, comment_id: select_del_memo_comment_id},
            cache: false,
          }).done(function(data){
              var result = jQuery.parseJSON(data);
              //alert(select_del_memo_comment_id);
              $("#"+select_del_memo_comment_id).fadeOut(1000);
              total_comments--;
              $("#total_comments").text(total_comments);
          });
          //--------------------- end of Ajax module --------------------------------

      });

});
