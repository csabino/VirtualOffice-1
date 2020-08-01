<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  class Announcement implements AnnouncementInterface{
      private $cell_id;
      private $author;
      private $title;
      private $message;
      private $file_upload_type;
      private $file;
      private $date_created;
      private $date_modified;


      public function new_announcement($fields){

        $this->cell_id = $fields['cell'];
        $this->author = $fields['author'];
        $this->title = $fields['title'];
        $this->message = $fields['message'];
        $this->file_upload_type = $fields['file_upload_type'];
        $this->file = $fields['file'];

        // current date_time
        // to get time-stamp for 'created' field
        $timestamp = date('Y-m-d H:i:s');
        $this->date_created = $timestamp;
        $this->date_modified = $timestamp;


        // state SQL and prepare compilation
        $sqlQuery = "Insert into announcements set cell_id=:cell, author=:author, title=:title,
                    message=:message, file_type=:file_upload_type, file=:file, date_created=:date_created,
                    date_modified=:date_modified";

        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);


        // set fields and named parameters
        $stmt->bindParam(":cell", $this->cell_id);
        $stmt->bindParam(":author", $this->author);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":file_upload_type", $this->file_upload_type);
        $stmt->bindParam(":file", $this->file);
        $stmt->bindParam(":date_created", $this->date_created);
        $stmt->bindParam(":date_modified", $this->date_modified);


        // execute SQL PDOStatement
        $stmt->execute();
        return $stmt;


      }



      public function get_announcements($cell){

          $this->cell_id = $cell;
          $sqlQuery = "Select a.id, a.cell_id, a.author, u.title as user_title, u.first_name, u.last_name,
                      u.other_names, u.position, u.avatar, a.title, a.message, a.file_type, a.file, a.date_created,
                      a.date_modified from announcements a inner join users u on a.author=u.id where a.cell_id=:cell";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // set fields and parameters
          $stmt->bindParam(":cell", $this->cell_id);

          // execute pdo Object
          $stmt->execute();
          return $stmt;
      }


  }





?>
