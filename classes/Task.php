<?php

class Task implements TaskInterface {
  private $task_id;
  private $author;
  private $user_id;
  private $title;
  private $project;
  private $project_name;
  private $description;
  private $source;
  private $task_update;


  public function new_task($fields){
    $this->title = $fields['title'];
    $this->project_name = $fields['project'];
    $this->description = $fields['description'];
    $this->author = $fields['author'];
    $this->source = $fields['source'];

    // current date_time
    // to get time-stamp for 'created' field
    $timestamp = date('Y-m-d H:i:s');
    $this->date_created = $timestamp;
    $this->date_modified = $timestamp;

    $sqlQuery = "Insert into tasks set title=:title, description=:description, creator=:author,
                project_name=:project_name, source=:source, date_created=:date_created,
                date_modified=:date_modified";

    // pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // define pdo parameters
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":author", $this->author);
    $stmt->bindParam(":project_name", $this->project_name);
    $stmt->bindParam(":source", $this->source);
    $stmt->bindParam(":date_created", $this->date_created);
    $stmt->bindParam(":date_modified", $this->date_modified);

    // stmt pdo object execute
    $stmt->execute();
    return $stmt;

  }

  // Task listing method with only fields that are needed
  public function get_tasks_listing($user_id){

    $this->user_id = $user_id;

    $sqlQuery = "Select t.id, t.title as subject, u.title, u.first_name, u.last_name, t.source, t.project_id, t.project_name,
                  t.status, t.date_created from tasks t inner join users u on t.creator=u.id where t.creator=:user_id
                  or assigned_to=:user_id order by t.id desc";

    //Pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // pdo parameters
    $stmt->bindParam(":user_id", $this->user_id);

    $stmt->execute();
    return $stmt;


  }


  public function get_task_by_id($task_id){
      $sqlQuery = "Select t.id, t.title as subject, t.description, t.file_type, t.file, u.title, u.first_name, u.last_name, t.creator,
      t.source, t.project_id, t.project_name, t.assigned_to, t.status, t.date_created from tasks t inner join users u
      on t.creator = u.id ";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

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


  public function get_task_updates_by_id($task_id){
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



}





 ?>
