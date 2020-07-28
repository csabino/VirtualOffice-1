console.log(user_record_found);
//alert("Inside User button --" + user_record_found);
function add_button(){

      var selected_user_id = $("#selected_user_id").val();
      var current_cell_id = $("#current_cell_id").val();

      $.ajax({
              url: '../../async/server/cell/get_user_in_cell.php',
              method: "POST",
              data: {user_id: selected_user_id, cell_id: current_cell_id},
              dataType: 'json',
              cache: false,
              processdata: false,
              beforeSend: function(){
                  console.log("Checking...");
              },
              success: function(data){
                   var btn = '';
                   if (data.recordCount==0){
                      $("#role-pane").css({"display":"block"});
                      btn = "<button id='btn_add' class='btn btn-success btn-sm btn-rounded' type='button'> <i class='fas fa-search'></i> Add User </button> ";

                   }else{
                      $("#role-pane").hide();
                      cell_user_roles = data.roles;
                      fn_get_cell_user_roles(cell_user_roles);


                      btn = "<small><strong>User has been added to this cell</strong></small><br/>";
                      btn += "<button id='btn_remove' class='btn btn-danger btn-sm btn-rounded' type='button'> <i class='fas fa-search'></i> Remove User </button> ";
                   }

                   $("#button-pane").html(btn);
                   $("#button-pane").show();

              }

      }); // end of ajax


}  // end of add_button function



// get Cell User roles
function fn_get_cell_user_roles(cell_user_roles){

        $.post("../../async/server/cell/get_cell_user_roles_info.php",{"roles":cell_user_roles},function(data){
            if (data)
            {
                  data = JSON.parse(data);

                  const keys = Object.keys(data);
                  console.log(data);
                  //console.log("Inside cell user roles info: " + data[0].length + "inside here");
                  var user_roles_html = '';
                  for (const key of keys){
                     console.log(key + ' ' + data[key]);
                     user_roles_html += "<li>" + data[key] + "</li>";
                  }

                  //alert(user_roles_html);
                  $("#role-array").html("<ul>" + user_roles_html + "</ul>");
                  //$("#role-array").css({"display":"block"});
                  $("#role-array").show();


            }

        });

}
// end of Cell User roles

// remove empty properties in json object
function removeEmptyProperties(obj){
    Object.keys(obj).forEach(function(key) {
        if (obj[key] && typeof obj[key] ==='object') removeEmpty(obj[key]); //recursive for objects
        else if (obj[key] == null || obj[key]=="") delete obj[key];  // remove empty properties
        if (typeof obj[key]==='object' && Object.keys(obj[key]).length==0) delete obj[key]; // remove empty objects

    });

    return obj;
}
