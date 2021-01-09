<?php

class Contact implements ContactInterface{
  private $contact_id;
  private $user_id;
  private $file_no;



  public function findUser($file_no){
    $this->file_no = $file_no;
    $sqlQuery = "Select id, file_no, title, first_name, other_names, position, avatar
    from users where file_no=:file_no";
    $QueryExecutor = new PDO_QueryExecutor();
    $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

    // bind parameters
    $stmt->bindParam(":file_no", $this->file_no);

    // execute $stmt
    $stmt->execute();

    return $stmt;
  }

}





?>
