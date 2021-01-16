<div class="row border rounded" style="width:100%;">


  <div class="col-xs-6 col-sm-6 col-md-4 col-lg-6"><!-- left pane //-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 py-4">
        <h4>Step 3 - Milestones</h4>
        Provide bulleted items of task or activities to be performed.
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

               <!-- Title //-->
               <div class="form-group row">
                       <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Item</label>
                       <div class="col-xs-12 col-sm-12 col-md-9">
                                   <input class="form-control" id="milestones_title" placeholder="Title" required >

                       </div>
               </div>
               <!-- end of Targets //-->

               <!-- Description //-->
               <div class="form-group row">
                       <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Description</label>
                       <div class="col-xs-12 col-sm-12 col-md-9">
                                   <textarea class="form-control" id="milestone_description" placeholder="Description" ></textarea>

                       </div>
               </div>
               <!-- end of Description //-->


               <!-- Start Date //-->
               <div class="form-group row">
                       <label for="milestoneDate" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right">Start Date</label>
                       <div class="col-xs-12 col-sm-12 col-md-9">
                                   <input class="form-control datepicker" id="milestoneDate" placeholder="Start Date" >

                       </div>
               </div>
               <!-- end of Start Date //-->



                <!-- Save button //-->
                <div class="form-group row">
                        <label for="target" class="col-xs-12 col-sm-12 col-md-3 col-form-label text-md-right"></label>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                            <div id='save_milestone' class="btn btn-sm btn-success btn-rounded mb-4">Save</div>
                        </div>
                </div>
                <!-- end of save button //-->



    </div>


  </div><!-- end of left pane //-->

  <!-- right pane //-->
  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-6 mt-4">

        <div id='divAddedMilestones' class="col-xs-12" style="height:380px; overflow:auto;">
            <ul id='milestoneItems'></ul>
        </div>
  </div>
  <!-- end of right pane //-->

</div>
