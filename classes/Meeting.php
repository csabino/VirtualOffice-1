<?php

class Meeting implements MeetingInterface{

  private $meeting_id;
  private $meeting_code;
  private $meeting_title;
  private $description;
  private $creator;
  private $meeting_date;
  private $meeting_time;
  private $date_created;
  private $date_modified;

  public function new_meeting($fields){
    $this->meeting_title = $fields['title'];
    $this->creator = $fields['creator'];
    $this->description = $fields['description'];
    $this->meeting_date = $fields['meeting_date'];
    $this->meeting_time = $fields['meeting_time'];

    // to get time-stamp for 'date created' field
    $timestamp = date('Y-m-d H:i:s');

    $this->date_created = $timestamp;
    $this->date_modified = $timestamp;

    // meeting_code
    $meeting_code = rand(1000000,9999999);

    // $sqlQuery
    $sqlQuery = "Insert into meetings set title=:title, meeting_date=:meeting_date, meeting_time=:meeting_time,
                description=:description, creator=:creator, meeting_code=:meeting_code, date_created=:date_created, date_modified=:date_modified";

    // pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt =  $QueryExecutor->customQuery()->prepare($sqlQuery);

    // bind parameters
    $stmt->bindParam(":title", $this->meeting_title);
    $stmt->bindParam(":meeting_date", $this->meeting_date);
    $stmt->bindParam(":meeting_time", $this->meeting_time);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":creator", $this->creator);
    $stmt->bindParam(":date_created", $this->date_created);
    $stmt->bindParam(":date_modified", $this->date_modified);
    $stmt->bindParam(":meeting_code", $meeting_code);

    // stmt execute
    $stmt->execute();

    return $stmt;




  }

  //-------------------------------------------------------------------------------
  //------------------------------ Get meeting list -------------------------------

  // Task listing method with only fields that are needed
  public function get_meeting_listing_by_user($user_id){

    $this->user_id = $user_id;

    $sqlQuery = "Select m.id, m.title as subject, u.title, u.first_name, u.last_name, u.avatar, m.meeting_date, m.meeting_time,
                 m.description, m.creator, m.meeting_code, m.date_created, m.date_modified from meetings m inner join
                 users u on m.creator=u.id where m.creator=:user_id order by m.id desc";

    //Pdo object
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // pdo parameters
    $stmt->bindParam(":user_id", $this->user_id);

    $stmt->execute();
    return $stmt;


  }

 //--------------------------------------------------------------------------------
 //---------------------------- Get meeting by Code and Title -------------------------------

 public function get_meeting_by_code_and_title($code, $title){
   $this->meeting_code = $code;
   $this->meeting_title = $title;

   // sqlQuery
   $sqlQuery = "Select * from meetings where meeting_code=:code and title=:title";

   // pdo object
   $QueryExecutor = new PDO_QueryExecutor();
   $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

   // bind parameters
   $stmt->bindParam(":code", $this->meeting_code);
   $stmt->bindParam(":title", $this->meeting_title);

   // stmt is_execute
   $stmt->execute();

   return $stmt;
 }




 //---------------------------  End of get meeting by Code and Title ------------------------

}



 ?>
