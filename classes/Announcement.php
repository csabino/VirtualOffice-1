<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  class Announcement implements AnnouncementInterface{
      private $announcement_id;
      private $cell_id;
      private $author;
      private $user_id;
      private $title;
      private $message;
      private $file_upload_type;
      private $file;
      private $comment;
      private $comment_id;
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



      public function get_announcement_by_id($announcement_id){
          $this->announcement_id = $announcement_id;

          $sqlQuery = "Select a.id, a.cell_id, a.author, u.title , u.last_name, u.first_name, u.avatar, a.title as subject,
                        a.message, a.file_type, a.file, a.date_created, a.date_modified from announcements a inner join
                        users u on a.author=u.id where a.id=:announcement_id";
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // set field and parameters
          $stmt->bindParam(":announcement_id", $this->announcement_id);

          // execute pdo object
          $stmt->execute();
          return $stmt;

      }


      public function post_comment($fields){
          $this->announcement_id = $fields['announcement_id'];
          $this->user_id = $fields['user_id'];
          $this->comment = $fields['comment'];

          $sqlQuery = "Insert into announcements_comments set announcement_id=:announcement_id, user_id=:user_id,
                      comment=:comment";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // set fields and parameters
          $stmt->bindParam(":announcement_id", $this->announcement_id);
          $stmt->bindParam("user_id", $this->user_id);
          $stmt->bindParam("comment", $this->comment);

          // execute pdo object
          $stmt->execute();
          return $stmt;
      }


      public function get_comments($announcement_id){
          $sqlQuery = "Select c.id, c.announcement_id, c.user_id, u.title, u.first_name, u.last_name, u.avatar,
          c.comment, c.date_posted from announcements_comments c inner join users u on c.user_id=u.id
          where c.announcement_id=:announcement_id order by c.id desc";

          // pdo object
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          // bind param to object
          $stmt->bindParam(":announcement_id", $announcement_id);

          // execute pdo object
          $stmt->execute();
          return $stmt;
      }



      public function get_comments_range($announcement_id, $start, $count){
        //$sqlQuery = "Select c.id, c.announcement_id, c.user_id, u.title, u.first_name, u.last_name, u.avatar,
        //c.comment, c.date_posted from announcements_comments c inner join users u on c.user_id=u.id order by c.id desc limit {$start}, {$count";
        $sqlQuery = "Select c.id, c.announcement_id, c.user_id, u.title, u.first_name, u.last_name, u.avatar,
        c.comment, c.date_posted from announcements_comments c inner join users u on c.user_id=u.id
        where c.announcement_id=:announcement_id and c.id>{$start}";


        //pdo object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind param to pdo object
        $stmt->bindParam(":announcement_id", $announcement_id);


        // execute pdo object
        $stmt->execute();
        return $stmt;
      }





      public function comment_count($announcement_id){
        $sqlQuery = "Select count(*) as comment_number from announcements_comments where announcement_id=:announcement_id";

        // pdo object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind parameters
        $stmt->bindParam(":announcement_id", $announcement_id);

        // execute stmt
        $stmt->execute();
        return $stmt;
      }



      public function delete_comment($fields){
        $this->announcement_id = $fields['announcement_id'];
        $this->user_id = $fields['user_id'];
        $this->comment_id = $fields['comment_id'];

        //echo "Announcement ID: ".$this->announcement_id;
        //echo "<br/> User ID: ".$this->user_id;
        //echo "<br/>Comment ID: ".$this->comment_id;

        $sqlQuery = "Delete from announcements_comments where id=:comment_id and announcement_id=:announcement_id and user_id=:user_id";

        // pdo object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind parameters
        $stmt->bindParam(":comment_id", $this->comment_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":announcement_id", $this->announcement_id);


        //execute pdo
        $stmt->execute();
        return $stmt;
      }


      public function get_announcement_count($announcement_id){
        $this->announcement_id = $announcement_id;

      }


  } // end of class





?>
