// ----- ------ Hide Project Definition Title  if not empty at Step2_back click --------------------------
    // get value of title Field


    $("#step2_back").bind("click", function(){
        var title = $("#title").val();
        if (title==''){
           alert("Empty");
        }else{
            $("label#title-error").hide();
        }
    })


//---------------------------- End of Hide Project Definition Title if not empty ----------------------
