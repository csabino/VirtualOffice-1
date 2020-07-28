<?php

class Circle implements CircleInterface{
    private $user_id;
    private $cell_id;
    private $circle_id;



    public function get_user_circle($user_id){
        $this->user_id = $user_id;

        // sql PDOStatement
        $sqlQuery = "Select cu.id as circle_id, cu.cell_id, c.name as circle_name, c.short_name, c.parent as parent_id, cp.name as parent,
                    c.type as type_id, ct.name as type, cu.user_id, cu.roles from cells c inner join cell_users cu on c.id=cu.cell_id left join cell_types ct on c.type=ct.id left join
                    cells cp on cp.id=c.parent where cu.user_id=:user_id";

        // pdo Object
        $QueryExecutor = new PDO_QueryExecutor();
        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

        // bind parameters
        $stmt->bindParam(":user_id", $this->user_id);

        // execute sql Object
        $stmt->execute();
        return $stmt;
    }


    public function get_circle_user_info($cell_id, $user_id){
      $this->user_id = $user_id;
      $this->cell_id = $cell_id;



      // sql PDOStatement
      $sqlQuery = "Select cu.id as circle_id, cu.cell_id, c.name as circle_name, c.short_name, c.parent as parent_id, cp.name as parent,
                  c.type as type_id, ct.name as type, cu.user_id, cu.roles from cells c inner join cell_users cu on c.id=cu.cell_id left join cell_types ct on c.type=ct.id left join
                  cells cp on cp.id=c.parent where cu.cell_id=:cell_id and cu.user_id=:user_id";

      // pdo Object
      $QueryExecutor = new PDO_QueryExecutor();
      $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

      // bind parameters
      $stmt->bindParam(":cell_id", $this->cell_id);
      $stmt->bindParam(":user_id", $this->user_id);

      // execute sql Object
      $stmt->execute();
      return $stmt;
    }




} // end of class Circle

 ?>
