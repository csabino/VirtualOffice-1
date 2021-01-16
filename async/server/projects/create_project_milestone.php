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
      $milestone_title = $_POST['milestone_title'];
      $description = $_POST['description'];
      $milestone_date = $_POST['milestone_date'];

      If ($project_id!='' && $milestone_title!='' && $user_id!=''){
         $dataArray = array("project_id"=>$project_id, "user_id"=>$user_id, "milestone_title"=>$milestone_title,
         "description"=>$description, "milestone_date"=>$milestone_date);

         $project = new Project();
         $result = $project->create_project_milestone($dataArray);


         $response = '';
         // check if the writing of the record is successful
         if ($result){

           // retrieve the last milestone posted by the user on the project
            $getLastPostedMilestone = $project->getLastMilestoneByUserAndProjectId($project_id, $user_id);

            // -------- check if the read is successful
            if ($getLastPostedMilestone->rowCount()){
                $milestoneId = '';
                $title = '';
                $description = '';
                $milestone_date = '';
                foreach($getLastPostedMilestone as $glpm){
                    $milestoneId = $glpm['id'];
                    $title = $glpm['title'];
                    $description = $glpm['description'];
                    $milestone_date = $glpm['milestone_date'];
                    $status = 'success';
                    //$response = array("status"=>$status, "checkListId"=>$checkListId,
                    //"item"=>$item, "description"=>$description);

                    if ($milestone_date!=''){
                      $title = $milestone_date." <small><i class='fas fa-chevron-right'></i></small> ".$title;
                    }

                    $output =  "<li title='{$description}' id='milestone{$milestoneId}' style='cursor:pointer;padding:3px;'>
                                   <i class='far fa-calendar-check fa-1x green-text pr-2'></i>
                                   &nbsp; {$title} &nbsp;<small><i id='delMilestone{$milestoneId}' class='fas fa-times text-danger delMilestone'></i></small></li>";
                    //$response = array("status"=>'success', "message"=>$output);
                    $response = $output;
                } // end of foreach

            }else{
                $status = "failed";
                $message = "An error occurred reading from the Project Milestone";
                //$response = array("status"=>$status, "message"=>$message);

            }
            // -----------------end of reading of record------
         }else{
              $status = "failed";
              $message = "An error occurred saving the record to the Project Milestone";
              //$response = array("status"=>$status, "message"=>$message);
         }

         //echo json_encode($response);
      }

      echo $response;

  }



  ?>
