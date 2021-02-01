 <?php

    //-------------- Abstract -----------------------------------
    require_once("../../../abstract/User.php");
    require_once("../../../abstract/Database.php");

    // -------------- Interface ---------------------------------
    require_once("../../../interface/UserInterface.php");
    require_once("../../../interface/DBInterface.php");
    require_once("../../../interface/CellInterface.php");
    require_once("../../../interface/FileUploaderInterface.php");
    require_once("../../../interface/ProjectInterface.php");


    //--------------- Classes -----------------------------------
    require_once("../../../classes/FileUploader.php");
    require_once("../../../classes/StaffUser.php");
    require_once("../../../classes/Cell.php");
    require_once("../../../classes/Project.php");
    require_once("../../../classes/PDO_QueryExecutor.php");
    require_once("../../../classes/PDODriver.php");


  //header('Content-Type: text/html');

  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')
  {

      $project_id = $_POST['project_id'];
      $user_id = $_POST['user_id'];
      $checklist_item = $_POST['checklist_item'];
      $checklist_description = $_POST['checklist_description'];


       $response = '';
      If ($project_id!='' && $checklist_item!='' && $user_id!=''){
         $dataArray = array("project_id"=>$project_id, "user_id"=>$user_id, "checklist_item"=>$checklist_item,
         "checklist_description"=>$checklist_description);

         $project = new Project();
         $result = $project->create_project_checklist($dataArray);

         // check if the writing of the record is successful
         if ($result){

           // retrieve the last check list posted by the user on the project
            $getLastPostedCheckList = $project->getLastCheckListByUserAndProjectId($project_id, $user_id);

            // -------- check if the read is successful
            if ($getLastPostedCheckList->rowCount()){
                $checkListId = '';
                $item = '';
                $description = '';
                foreach($getLastPostedCheckList as $glpcl){
                    $checkListId = $glpcl['id'];
                    $item = $glpcl['item'];
                    $description = $glpcl['description'];
                    $status = 'success';
                    //$response = array("status"=>$status, "checkListId"=>$checkListId,
                    //"item"=>$item, "description"=>$description);
                    $li_id = 'chkLst'.$checkListId;
                    $delete_icon_id = 'delChkLst'.$checkListId;
                    $edit_icon_id = 'editChkLst'.$checkListId;

                    $output =  "<div class='chklist_item' title='{$description}' id='chkLst{$checkListId}' style='cursor:pointer;padding:3px;'>
                                   <i class='far fa-square fa-1x green-text pr-3'></i>
                                   {$item} &nbsp; &nbsp;<small><i id='delChkLst{$checkListId}' data-toggle='modal' data-target='#confirmDelete' class='fas fa-times text-danger delChkLst'></i></small>
                                   &nbsp; &nbsp; <small><i title='Edit this item' id='{$edit_icon_id}' class='far fa-edit text-info editChkLst'></i></small>
                                   </div>";
                    //$response = array("status"=>'success', "message"=>$output);
                    $response = $output;
                } // end of foreach

            }else{
                $status = "failed";
                $message = "An error occurred reading from the Project Check List";
                //$response = array("status"=>$status, "message"=>$message);

            }
            // -----------------end of reading of record------
         }else{
              $status = "failed";
              $message = "An error occurred saving the item to the Project Checklist";
              //$response = array("status"=>$status, "message"=>$message);
         }

         //echo json_encode($response);
      }

      echo $response;

  }



  ?>
