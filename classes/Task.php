<?php

class Task implements TaskInterface {
  private $author;
  private $user_id;
  private $title;
  private $project;
  private $project_name;
  private $description;
  private $source;


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

}





 ?>
