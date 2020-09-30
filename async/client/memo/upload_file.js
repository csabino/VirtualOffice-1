$(document).ready(function(){

      $("#file_upload_type_document").bind("click",function(){
          $("#file_uploader").show();

      });

      $("#file_upload_type_image").bind("click",function(){
          $("#file_uploader").show();
          //alert($("#file_upload_type_document").val());
      })

//---------------------------------------------------------------------------------------------------

      // file upload
      $("#file").on("change", function(){
            var property = document.getElementById("file").files[0];
            var image_name = property.name;

            var image_extension = image_name.split('.').pop().toLowerCase();

            var radioValue = $("input[name='file_upload_type']:checked").val();
            var file_type = '';
            switch(radioValue){
                case "document":
                    file_type = radioValue;
                    if (jQuery.inArray(image_extension,['doc','docx','pdf'])==-1){
                          alert("Invalid document format. Please select a document.");
                    }else{
                        run_file_upload(file_type, property);
                    }

                    break;

                case "image":
                    file_type = radioValue;
                    if (jQuery.inArray(image_extension,['gif','png','jpg','jpeg'])==-1){
                          alert("Invalid image format. Please select an image.");
                    }else{
                        run_file_upload(file_type, property);
                    }

                    break;
            }


      })

// -------------------------------------------------------------------------------------------

      // function to load files
      function run_file_upload(file_type, property){
            var image_size = property.size;
            image_size = image_size/1024;
            //alert(image_size);
            if (image_size>10000){
                alert("The file is larger than the allowed 10MB size. Please resize and try again.");
            }else{
                    var form_data = new FormData();
                    form_data.append("file", property);
                    //form_data.append("source", 'announcement');
                    //form_data.append("file_type", file_type);

                    $.ajax({
                        url: '../../async/server/file_upload/memo_upload_file.php?source=memos&file_type='+file_type,
                        method: "POST",
                        data: form_data,
                        dataType:  'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function(){
                            $("#file_uploader").hide();
                            $("#spinner").show();
                        },
                        success: function(data){
                            //console.log("am here");
                            //console.log(data.status);
                            $("#spinner").hide();

                            //data = JSON.parse(data);
                            if (data.status=='success'){
                                var msgblock = "<div class='py-3' id='myuploadedfile'><i class='fas fa-paperclip'></i> " + data.wp_filename;
                                msgblock += "&nbsp;&nbsp;&nbsp;<span id='deletefile' title='Delete file' style='cursor:pointer'><i class='fas fa-times text-danger'></i></span>";
                                msgblock += "</div>";
                                $("#activity_notifier").html(msgblock);


                            }

                        }
                    });
            } // end of if
      }
// -------------------------------------------------------------------------------------------

// Remove file
    $("#activity_notifier").on("click", "span#deletefile", function(){

    });





//----------------------------------------------------------------------------------------------

});
