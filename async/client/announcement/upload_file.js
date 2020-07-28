$(document).ready(function(){

      $("#file_upload_type_document").bind("click",function(){
          $("#file_uploader").show();

      });

      $("#file_upload_type_image").bind("click",function(){
          $("#file_uploader").show();
          alert($("#file_upload_type_document").val());
      })


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
            alert(image_size);
            if (image_size>500000){
                alert("The file is larger than the allowed size. Please resize.");
            }else{
                    var form_data = new FormData();
                    form_data.append("file", property);
                    //form_data.append("source", 'announcement');
                    //form_data.append("file_type", file_type);

                    $.ajax({
                        url: '../../async/server/file_upload/upload_file.php?source=announcements&file_type='+file_type,
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
                            console.log("am here");
                            $("#spinner").hide();

                            data = JSON.parse(data);
                            if (data.status=='success'){
                                $("#spinner").html("File Uploader");
                                $("#spinner").show();

                            }

                        }
                    });
            } // end of if
      }
// -------------------------------------------------------------------------------------------

});
