<!-- get project_id created by the User //-->
<?php
    $project = new Project();
    $project_info = $project->getUserLastProject($_GET_URL_user_id);

    $new_project_id = '';
    foreach($project_info as $row){
        $new_project_id = $row['id'];
    }






?>
<!-- end of get project_id created by the User //-->


<div class="row border rounded" style="width:100%;">


    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-6"><!-- left pane //-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-4">
            <h4>Step 2 - Checklist</h4>
            Provide bulleted items of task or activities to be performed.
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- step 2 status //-->
                    <div id='step2_output_status'>

                    </div>
                    <!-- end of Step 2 Status //-->


                     <!-- Title //-->
                   <div class="form-group row">
                           <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Item</label>
                           <div class="col-xs-12 col-sm-12 col-md-9">
                                       <input class="form-control" id="checklist_item" placeholder="Item" required >

                           </div>
                   </div>
                   <!-- end of Targets //-->

                   <!-- Description //-->
                   <div class="form-group row">
                           <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Description</label>
                           <div class="col-xs-12 col-sm-12 col-md-9">
                                       <textarea class="form-control" id="checklist_description" placeholder="Description" ></textarea>

                           </div>
                   </div>
                   <!-- end of Description //-->



                    <!-- Save button //-->
                    <div class="form-group row">
                            <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right"></label>
                            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                                <div id='step2_btn_save' class="btn btn-sm btn-success btn-rounded mb-4">Save</div>
                            </div>
                    </div>
                    <!-- end of save button //-->



        </div>


    </div><!-- end of left pane //-->

    <!-- right pane //-->
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6 mt-4">

          <div id='divAddedCheckList' class="col-xs-12" style="height:380px; overflow:auto;">
              <ul id='chkLstItems' style='list-style-type:none;'></ul>
          </div>
    </div>
    <!-- end of right pane //-->


</div>
