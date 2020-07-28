<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //require_once("../../interface/CellInterface.php");

    class Cell implements CellInterface{
        private $cell_id;
        private $cell_name;
        private $cell_short_name;
        private $cell_parent;
        private $cell_type;
        private $cell_description;
        private $cell_date_created;
        private $cell_date_modified;

        public function create_cell_type(){

        }

        public function create_cell($fields){
            $this->cell_name = $fields['name'];
            $this->cell_short_name = $fields['short_name'];
            $this->cell_parent = $fields['parent'];
            $this->cell_type = $fields['type'];
            $this->cell_description = $fields['description'];

            // state SQL and prepare compilation
            $sqlQuery = "Insert into cells set name=:name, short_name=:short_name, parent=:parent,
                        type=:type, description=:description, date_created=:date_created,
                        date_modified=:date_modified";
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // current date_time
            // to get time-stamp for 'created' field
            $timestamp = date('Y-m-d H:i:s');
            $this->cell_date_created = $timestamp;
            $this->cell_date_modified = $timestamp;

            //set fields to named parameters
            $stmt->bindParam(":name", $this->cell_name);
            $stmt->bindParam(":short_name", $this->cell_short_name);
            $stmt->bindParam(":parent", $this->cell_parent);
            $stmt->bindParam(":type", $this->cell_type);
            $stmt->bindParam(":description", $this->cell_description);
            $stmt->bindParam(":date_created", $this->cell_date_created);
            $stmt->bindParam(":date_modified", $this->cell_date_modified);


            // execute SQL statement
            $stmt->execute();
            return $stmt;

        }

        public function is_cell_exist($cell_name){
            $this->cell_name = ucwords($cell_name);
            $sqlQuery = "Select id from cells where name=:cell_name";
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);
            $stmt->bindParam(":cell_name", $this->cell_name);
            $stmt->execute();
            //echo $stmt->rowCount();
            return $stmt;
        }

        public function get_all_cells()
        {
            $sqlQuery = "Select id, name, short_name, parent, type, description, date_created, date_modified
                        from cells where deleted='' order by parent, type, name ";
            $QueryExecutor = new MySQL_QueryExecutor();
            $stmt = $QueryExecutor::customQuery($sqlQuery);
            return $stmt;
        }

        public function get_cell_types()
        {
            $sqlQuery = "Select id, name, description, date_created, date_modified
                        from cell_types order by name asc";
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        public function get_cell_type_by_id($cell_id){

            $this->cell_id = $cell_id;

            $sqlQuery = "Select id, name, description, date_created, date_modified
                        from cell_types where id=:id";

            // pdo driver object, connection and prepare sql compilation
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // assign parameter to pdo sql statement object
            $stmt->bindParam(":id",$this->cell_id);

            // execute statement object
            $stmt->execute();

            return $stmt;

        }

        public function get_cell_by_id($cell_id){
            $this->cell_id = $cell_id;

            // sql statement
            $sqlQuery = "Select id, name, short_name, parent, type, description, date_created, date_modified, deleted
                        from cells where id=:id and deleted='' ";

            // pdo driver object, connection and prepare sql compilation
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // assign parameter to pdo sql statement SplObjectStorage
            $stmt->bindParam(":id",$this->cell_id);

            // execute statement object
            $stmt->execute();

            return $stmt;


        }

        public function get_parent_cell_by_id($cell_id){

            return $this->get_cell_by_id($cell_id);

        }


        public function update_cell($fields){
            $this->cell_id = $fields['id'];
            $this->cell_name = $fields['name'];
            $this->cell_short_name = $fields['short_name'];
            $this->cell_parent = $fields['parent'];
            $this->cell_type = $fields['type'];
            $this->cell_description = $fields['description'];

            $date_modified = new datetime();
            $date_modified = $date_modified->format('Y-m-d h:m:s');

            $this->cell_date_modified = $date_modified;

            // create sql PDOStatement
            $sqlQuery = "Update cells set name=:name, short_name=:short_name, parent=:parent,
                        type=:type, description=:description, date_modified=:date_modified where id=:id";

            // createa pdo object, prepare sql statement for compilation
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // assign parameters
            $stmt->bindParam(":id", $this->cell_id);
            $stmt->bindParam(":name", $this->cell_name);
            $stmt->bindParam(":short_name", $this->cell_short_name);
            $stmt->bindParam(":parent", $this->cell_parent);
            $stmt->bindParam(":type", $this->cell_type);
            $stmt->bindParam(":description", $this->cell_description);
            $stmt->bindParam(":date_modified", $this->cell_date_modified);


            // execute pdo sql PDOStatement
            $stmt->execute();

            return $stmt;

        }



        public function delete_cell($cell_id){
            $this->cell_id = $cell_id;

            // sql statement
            $sqlQuery = "Update cells set deleted='1' where id=:id";

            //pdo object, preapre and compilation
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // set parameter
            $stmt->bindParam(":id",$cell_id);

            // execute
            $stmt->execute();

            return $stmt;
        }


        public function is_having_children($cell_id){
            // check if a cell is a parent, meaning it has a child/children
            $this->cell_id = $cell_id;

            // create sql statement
            $sqlQuery = "Select id, name, short_name, parent, description,
                        date_created, date_modified from cells where parent=:cell_id order by id asc";

            // create pdo prepare, query sql PDOStatement
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // set parameters
            $stmt->bindParam(":cell_id", $this->cell_id);

            // execute object
            $stmt->execute();

            return $stmt;
        }

        public function is_cell_type_exist($cell_type_name){

            $this->cell_type = $cell_type_name;

            // Sql statement
            $sqlQuery = "Select * from cell_types where name=:name";

            // pdo object, sql prepare
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt =  $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bindParams
            $stmt->bindParam(":name", $this->cell_type);

            // execute
            $stmt->execute();

        }


        public function cell_users($cell_id){
            $this->cell_id = $cell_id;

            // sql PDOStatement
            $sqlQuery = "Select cu.id as cell_user_id, cu.cell_id, cu.user_id, u.file_no, u.title, u.first_name, u.last_name, u.other_names, u.position, u.avatar,
                         cu.roles from cell_users cu left join cells c on cu.cell_id=c.id left join users u on cu.user_id=u.id
                         where cell_id=:cell_id";


            // pdo object, prepare
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":cell_id",$this->cell_id);

            //execute
            $stmt->execute();
            return $stmt;

        }


        public function is_user_in_cell($cell_id, $user_id){
            $this->cell_id =  $cell_id;

            // sql statement
            $sqlQuery = "Select cell_id, user_id, roles from cell_users where
                        cell_id=:cell_id and user_id=:user_id";

            // pdo object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":cell_id", $this->cell_id);
            $stmt->bindParam(":user_id", $user_id);

            // execute and return
            $stmt->execute();
            return $stmt;
        }


        public function get_user_roles_in_cell($cell_id, $user_id){
            $sqlQuery = "Select id, roles, date_created, date_modified from cell_users
                        where cell_id=:cell_id and user_id=:user_id";

            // pdo Object
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters
            $stmt->bindParam(":cell_id", $cell_id);
            $stmt->bindParam(":user_id", $user_id);

            //execute and return
            $stmt->execute();
            return $stmt;
        }


        public function add_user_to_cell($fields){

            $user_id = $fields['user_id'];
            $cell_id = $fields['cell_id'];
            $roles = $fields['roles'];


            // check if record has been added
             $record_exist = $this->is_user_in_cell($cell_id, $user_id);

             $stmt = 0;
             if (!$record_exist->rowCount())
             {
                     //sql PDOStatement
                     $sqlQuery = "Insert into cell_users set cell_id=:cell_id, user_id=:user_id,
                                 roles=:roles, date_created=:date_created, date_modified=:date_modified";

                     // pdo Object
                     $QueryExecutor = new PDO_QueryExecutor();
                     $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

                     $date_created = new datetime();
                     $date_created = $date_created->format('Y-m-d h:m:s');
                     $date_modified = $date_created;

                     // bind parameters
                     $stmt->bindParam(":cell_id", $cell_id);
                     $stmt->bindParam(":user_id", $user_id);
                     $stmt->bindParam(":roles", $roles);
                     $stmt->bindParam(":date_created", $date_created);
                     $stmt->bindParam(":date_modified", $date_modified);

                     // Execute sql Object
                     $stmt->execute();


             } else{
                  $stmt = 1;
             }// end of if statement

             $status = ''; $msg = '';
             if ($stmt){
                  $status = 'success';
                  $msg = 'The User has been added to the Cell';
             }else{
                  $status = 'error';
                  $msg = 'An error occurred adding the User to the Cell';
             }

             $response = array("status"=>$status, "msg"=>$msg);
             return $response;


        }


        public function remove_user_from_cell($fields)
        {
              $cell_id = $fields['cell_id'];
              $user_id = $fields['user_id'];

              // sql statement
              $sqlQuery = "Delete from cell_users where cell_id=:cell_id and user_id=:user_id";

              // pdo PDOStatement
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

              // sql parameters
              $stmt->bindParam(":cell_id", $cell_id);
              $stmt->bindParam(":user_id", $user_id);

              // execute and return
              $stmt->execute();

              $status = ''; $msg = '';
              if ($stmt){
                   $status = 'success';
                   $msg = 'The User has been removed from the Cell';
              }else{
                   $status = 'error';
                   $msg = 'An error occurred removing the User from the Cell';
              }

              $response = array("status"=>$status, "msg"=>$msg);
              return $response;

        }






    } // end of class




 ?>
