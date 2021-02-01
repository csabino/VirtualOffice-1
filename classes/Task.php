<?php

class Task implements TaskInterface {
  private $id;
  private $cell_id;
  private $task_id;
  private $author;
  private $user_id;
  private $title;
  private $project;
  private $project_id;
  private $project_name;
  private $description;
  private $source;
  private $task_update;
  private $file_type;
  private $file;

  private $status;
  private $progress;


  public function new_task($fields){
    $this->title = $fields['title'];
    $this->cell_id = $fields['cell_id'];
    $this->project_id = $fields['project_id'];

    $this->project_name = $fields['project_name'];
    $this->description = $fields['description'];
    $this->author = $fields['author'];
    $this->source = $fields['source'];
    $this->file_type = $fields['file_upload_type'];
    $this->file = $fields['file'];



    // current date_time
    // to get time-stamp for 'created' field
    $timestamp = date('Y-m-d H:i:s');
    $this->date_created = $timestamp;
    $this->date_modified = $timestamp;

    $sqlQuery = "Insert into tasks set title=:title, description=:description, file_type=:file_type, file=:file,
                creator=:author, source=:source, cell_id=:cell_id, project_id=:project_id, project_name=:project_name,
                date_created=:date_created, date_modified=:date_modified";

    // pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // define pdo parameters
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":file_type", $this->file_type);
    $stmt->bindParam(":file", $this->file);
    $stmt->bindParam(":author", $this->author);
    $stmt->bindParam(":source", $this->source);
    $stmt->bindParam(":cell_id", $this->cell_id);
    $stmt->bindParam(":project_id", $this->project_id);
    $stmt->bindParam(":project_name", $this->project_name);

    $stmt->bindParam(":date_created", $this->date_created);
    $stmt->bindParam(":date_modified", $this->date_modified);

    // stmt pdo object execute
    $stmt->execute();
    return $stmt;

  }

// ------------------------ update task ---------------------------------------------------
  public function update_task($fields){
    $this->id = $fields['id'];
    $this->title = $fields['title'];
    $this->cell_id = $fields['cell_id'];
    $this->project_id = $fields['project_id'];

    $this->project_name = $fields['project_name'];
    $this->description = $fields['description'];
    $this->author = $fields['author'];
    $this->source = $fields['source'];

    $this->file_type = $fields['file_upload_type'];
    $this->file = $fields['file'];

    // current date_time
    // to get time-stamp for 'created' field
    $timestamp = date('Y-m-d H:i:s');
    //$this->date_created = $timestamp;
    $this->date_modified = $timestamp;

    $sqlQuery = "Update tasks set title=:title, description=:description, file_type=:file_type, file=:file,
                 creator=:author, source=:source, cell_id=:cell_id, project_id=:project_id, project_name=:project_name,
                 date_modified=:date_modified where id=:id";

    // pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // define pdo parameters
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":file_type", $this->file_type);
    $stmt->bindParam(":file", $this->file);
    $stmt->bindParam(":author", $this->author);
    $stmt->bindParam(":source", $this->source);
    $stmt->bindParam(":cell_id", $this->cell_id);
    $stmt->bindParam(":project_id", $this->project_id);
    $stmt->bindParam(":project_name", $this->project_name);
    $stmt->bindParam(":date_modified", $this->date_modified);

    // stmt pdo object execute
    $stmt->execute();
    return $stmt;

  }

// ----------------  end of update task -------------------------------------------------

  // Task listing method with only fields that are needed
  public function get_my_tasks_listing($user_id){

    $this->user_id = $user_id;

    $sqlQuery = "Select t.id, t.title as subject, u.title, t.file_type, t.file, u.first_name, u.last_name, t.creator, u.avatar, t.source, t.project_id, t.project_name,
                  t.status, t.progress, t.date_created from tasks t inner join users u on t.creator=u.id where t.creator=:user_id
                  or t.source='My Work' order by t.id desc";

    //Pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // pdo parameters
    $stmt->bindParam(":user_id", $this->user_id);

    $stmt->execute();

    return $stmt;
  }



    // Task listing method with only fields that are needed
    public function get_project_tasks_listing($project_id){

      $this->project_id = $project_id;

      $sqlQuery = "Select t.id, t.title as subject, u.title, t.file_type, t.file, u.first_name, u.last_name, t.creator, u.avatar, t.source, t.project_id, t.project_name,
                    t.status, t.progress, t.date_created from tasks t inner join users u on t.creator=u.id where t.creator=:user_id
                    or t.source='My Work' order by t.id desc";

      //Pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // pdo parameters
      $stmt->bindParam(":project_id", $this->project_id);

      $stmt->execute();

      return $stmt;
    }


  public function get_task_by_id($id){
      $this->id = $id;

      $sqlQuery = "Select t.id, t.title as subject, t.description, t.file_type, t.file, u.title, u.first_name, u.last_name, t.creator,
      t.source, t.project_id, t.project_name, t.assigned_to, t.status, t.progress, t.date_created from tasks t inner join users u
      on t.creator = u.id where t.id=:id";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameter
      $stmt->bindParam(":id", $this->id);


      // execute pdo object
      $stmt->execute();
      return $stmt;
  }


  public function post_task_update($fields){
    $this->task_id = $fields['task_id'];
    $this->user_id = $fields['user_id'];
    $this->task_update = $fields['task_update'];


    // sqlQuery
    $sqlQuery = "Insert into tasks_updates set task_id=:task_id, user_id=:user_id, updates=:task_update";

    // pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // bind pdo parameter
    $stmt->bindParam(":task_id", $this->task_id);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->bindParam(":task_update", $this->task_update);

    // execute Pdo
    $stmt->execute();
    return $stmt;

  }


  public function get_task_updates_by_taskid($task_id){
    $this->task_id = $task_id;
    $sqlQuery = "Select * from tasks_updates where task_id=:task_id order by id desc";

    //pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    //bind parameters
    $stmt->bindParam(":task_id", $this->task_id);

    // execute pdo object
    $stmt->execute();
    return $stmt;

  }

  public function get_task_updates_count_by_taskid($task_id){
     $this->task_id = $task_id;
     $sqlQuery = "Select count(*) as task_updates_count from tasks_updates where task_id=:task_id";

     // pdo object
     $QueryExecutor = new PDO_QueryExecutor();
     $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

     // bind parameters
     $stmt->bindParam(":task_id", $task_id);

     $stmt->execute();

     return $stmt;
  }

  public function get_task_updates_by_id($id){
    $this->id = $id;
    $sqlQuery = "Select * from tasks_updates where id=:id order by id desc";

    //pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    //bind parameters
    $stmt->bindParam(":id", $this->id);

    // execute pdo object
    $stmt->execute();
    return $stmt;

  }


  public function get_user_task_updates_last_id($user_id){
      $this->user_id = $user_id;

      $sqlQuery = "Select id from tasks_updates where user_id=:user_id order by id desc limit 1";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameters
      $stmt->bindParam(":user_id", $this->user_id);

      // execute pdo objects
      $stmt->execute();

      $taskUpdateId = '';
      foreach($stmt as $row){
        $taskUpdateId = $row['id'];
      }
      //echo $taskUpdateId;

      return $taskUpdateId;
  }


  public function delete_task($fields){
     $this->id = $fields['id'];
     $this->user_id = $fields['user_id'];

     // sql Query
     $sqlQuery = "Delete from tasks where id=:id and creator=:user_id";

     // pdo Query $QueryExecutor
     $QueryExecutor = new PDO_QueryExecutor();
     $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

     // bind parameters
     $stmt->bindParam(":id", $this->id);
     $stmt->bindParam(":user_id", $this->user_id);

     // execute pdo object
     $result = $stmt->execute();

     // check if task delete is successful,
     // if yes delete task updates for the deleted task
     if ($result){
        $this->task_id = $fields['id'];
        $sqlQuery = "Delete from tasks_updates where task_id=:task_id";
        $stmt_2 = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind parameters
        $stmt_2->bindParam(":task_id", $this->task_id);

        // execute pdo object
        $stmt_2->execute();
     }

     // return result of the first query
     return $stmt;
  }

  public function delete_task_update($fields)
  {
     $this->id = $fields['post_id'];
     $this->user_id = $fields['user_id'];
     $this->task_id = $fields['task_id'];

     // sql statement
     $sqlQuery = "Delete from tasks_updates where id=:id and task_id=:task_id and user_id=:user_id";

     // pdo Query Executor
     $QueryExecutor = new PDO_QueryExecutor();
     $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

     // bind parameters
     $stmt->bindParam(":id", $this->id);
     $stmt->bindParam(":user_id", $this->user_id);
     $stmt->bindParam(":task_id",  $this->task_id);

     // execute pdo object
     $stmt->execute();

     // return object
     return $stmt;

  }


  public function set_task_status($fields)
  {
      $this->task_id = $fields['task_id'];
      $this->status = $fields['status'];
      $this->progress = $fields['progress'];

      // $sqlQuery
      $sqlQuery = "Update tasks set status=:status, progress=:progress where id=:id";

      // PDO object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind Params
      $stmt->bindParam(":status", $this->status);
      $stmt->bindParam(":progress", $this->progress);
      $stmt->bindParam(":id", $this->task_id);

      // execute
      $stmt->execute();

      //echo $stmt->rowCount();
      return $stmt;


  }

}





 ?>
