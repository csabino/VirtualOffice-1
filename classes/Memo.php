<?php

  class Memo implements MemoInterface{

    private $memo_id;
    private $title;
    private $file_type;
    private $file;
    private $author;
    private $remark;
    private $comment;
    private $user_id;
    private $sender;
    private $recipient_email;
    private $recipient_fileno;


    public function new_memo($fields){
      $this->author = $fields['author'];
      $this->title = $fields['title'];
      $this->remark = $fields['remark'];
      $this->file_type = $fields['file_upload_type'];
      $this->file = $fields['file'];

      $sqlQuery = "Insert into memos set title=:title, file_type=:file_type, file=:file, author=:author,
                  remark=:remark";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameters
      $stmt->bindParam(":title", $this->title);
      $stmt->bindParam(":author", $this->author);
      $stmt->bindParam(":remark", $this->remark);
      $stmt->bindParam(":file_type", $this->file_type);
      $stmt->bindParam(":file",$this->file);

      //execute pdo Object
      $stmt->execute();
      return $stmt;
    }


    public function get_memo_listing($_GET_URL_user_id){
      $this->author = $_GET_URL_user_id;
      $sqlQuery = "Select m.id, m.title as subject, m.file_type, m.file, m.author, u.title, u.first_name,
                  u.last_name,m.remark, m.date_created from memos m inner join users u on
                  m.author=u.id where m.author=:author order by m.id desc";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameter
      $stmt->bindParam(":author", $this->author);

      $stmt->execute();
      return $stmt;
    }


    public function get_memo_by_id($memo_id){
      $this->memo_id = $memo_id;
      $sqlQuery = "Select m.id, m.title as subject, m.file_type, m.file,
                  m.author, u.title, u.first_name, u.last_name, m.remark,
                  m.date_created from memos m inner join users u on
                  m.author=u.id where m.id=:memo_id order by id desc";

      //pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      //bind parameters
      $stmt->bindParam(":memo_id", $this->memo_id);

      // execute pdo object
      $stmt->execute();
      return $stmt;

    }

    public function get_memo_comments($memo_id){
      $this->memo_id = $memo_id;
      $sqlQuery = "Select mu.id, mu.memo_id, mu.user_id, u.title, u.first_name, u.last_name, u.avatar,
                  mu.comment, mu.date_posted from memos_comments mu inner join users u on mu.user_id=u.id where
                  mu.memo_id=:memo_id order by mu.id desc";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameter
      $stmt->bindParam(":memo_id", $this->memo_id);

      // execute pdo object
      $stmt->execute();
      return $stmt;
    }

    public function post_memo_comment($fields){
      $this->memo_id = $fields['memo_id'];
      $this->user_id = $fields['user_id'];
      $this->comment = $fields['comment'];

      $sqlQuery = "Insert into memos_comments set memo_id=:memo_id,
                  user_id=:user_id, comment=:comment";

      // pdo object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameters
      $stmt->bindParam(":memo_id", $this->memo_id);
      $stmt->bindParam(":user_id", $this->user_id);
      $stmt->bindParam(":comment", $this->comment);

      // pdo execute
      $stmt->execute();
      return $stmt;
    }


    public function share_memo($fields){
      $this->memo_id = $fields['memo_id'];
      $this->sender = $fields['sender'];
      $this->recipient_fileno = $fields['recipient_fileno'];
      $source = 'memo';

      $recipient = $this->get_user_by_email($this->recipient_fileno);
      if ($recipient->rowCount()){
          foreach($recipient as $row){
             $recipient_id = $row['id'];
          }

          $sqlQuery = "Insert into share set source=:source, resource_id=:memo_id,
          sender=:sender, recipient=:recipient";

          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

          $stmt->bindParam(":source", $source);
          $stmt->bindParam(":memo_id", $this->memo_id);
          $stmt->bindParam(":sender", $this->sender);
          $stmt->bindParam(":recipient", $recipient_id);
          $stmt->execute();
          return "Success. Memo has been shared";


      }else{
         return "Failed. Email address doesn't exist";
      }

    }


    private function get_user_by_email($fileno){
      $sqlQuery = "Select * from users where file_no=:file_no";

      //pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameters
      $stmt->bindParam(":file_no", $fileno);

      //pdo execute
      $stmt->execute();
      return $stmt;
    }







    public function get_memo_share($memo_id){
      $this->memo_id = $memo_id;
      $sqlQuery = "Select ms.id, ms.resource_id, ms.sender, ms.recipient, u.title, u.first_name, u.last_name, u.position,
                  u.avatar, ms.date_shared from share ms inner join users u on ms.recipient=u.id where
                  source='memo' and ms.resource_id=:memo_id order by ms.id desc";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameter
      $stmt->bindParam(":memo_id", $this->memo_id);

      // execute pdo object
      $stmt->execute();
      return $stmt;
    }





  }



 ?>
