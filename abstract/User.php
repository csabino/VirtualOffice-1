<?php
    abstract class User{
              private $user_id;
              private $file_no;
              private $title;
              private $firstname;
              private $lastname;
              private $othernames;
              private $email;
              private $position;
              private $avatar;
              private $role;
              private $user_category;
              private $dob;
              private $grade_level;
              private $phone;
              private $about;
              private $date_created;
              private $date_modified;



              //
              private $authority;
              private $description;

          //
          //     public function __construct($file_no, $title, $firstname, $lastname, $othernames, $avatar){
          //         $this->file_no = $file_no;
          //         $this->title = $title;
          //         $this->firstname = $firstname;
          //         $this->lastname = $lastname;
          //         $this->othernames = $othernames;
          //         $this->avatar = $avatar;
          //     }

          abstract public function getUserById($user_id);

          // Get all users records
          public function get_all_users(){

              // sql statement
              $sqlQuery = "Select u.id, u.file_no, u.title, u.first_name, u.last_name,
                          u.other_names, u.position, u.avatar, u.date_created, u.date_modified, a.email, a.role from
                          users u inner join auth a on u.id=a.user_id ";

              // PDOStatement, prepare and execute
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);
              $stmt->execute();
              return $stmt;

          }
          // -- end of get all users records

        // check if user has already been created to avoid duplicate
        public function user_exist($file_no){
              $this->file_no = $file_no;
              // sql statement
              $sqlQuery = "Select * from users where file_no=:file_no";
              // pdostatement, prepare
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

              // bind parameter to sql object
              $stmt->bindParam(":file_no", $this->file_no);

              // execute sql object
              $stmt->execute();
              return $stmt;
        }


        // Create User
        public function create_user($fields){
                  //begin pdo transaction
                  $QueryExecutor = new PDO_QueryExecutor();

                  // Start Transaction
                  $QueryExecutor->customQuery()->beginTransaction();

                  try {



                        $this->file_no = $fields['file_no'];
                        $this->title = $fields['title'];
                        $this->firstname = ucwords($fields['firstname']);
                        $this->lastname = ucwords($fields['lastname']);
                        $this->othernames = ucwords($fields['othernames']);
                        $this->email = $fields['email'];
                        $this->position = ucwords($fields['position']);
                        $this->role = $fields['role'];

                        // current date_time
                        // to get time-stamp for 'created' field
                        $timestamp = date('Y-m-d H:i:s');
                        $this->date_created = $timestamp;
                        $this->date_modified = $timestamp;

                        // sql statement
                        $sqlQuery_user = "Insert into users set file_no=:file_no,
                                                                title=:title,
                                                                first_name=:first_name,
                                                                last_name=:last_name,
                                                                other_names=:other_names,
                                                                position=:position,
                                                                date_created=:date_created,
                                                                date_modified=:date_modified";
                        // pdostatement prepare
                        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery_user);

                        // bind parameters
                        $stmt->bindParam(":file_no",$this->file_no);
                        $stmt->bindParam(":title", $this->title);
                        $stmt->bindParam(":first_name", $this->firstname);
                        $stmt->bindParam(":last_name", $this->lastname);
                        $stmt->bindParam(":other_names", $this->othernames);
                        $stmt->bindParam(":position", $this->position);
                        $stmt->bindParam(":date_created", $this->date_created);
                        $stmt->bindParam(":date_modified", $this->date_modified);

                        // stmt sql object execute
                        $stmt->execute();


                        // get new user id to insert into auth table
                        //$new_user_id = $QueryExecutor->customQuery()->lastInsertId();


                        $new_user = $this->user_exist($this->file_no);
                        if ($new_user){
                            foreach($new_user as $nu){
                                $new_user_id = $nu['id'];
                            }
                        }

                        $sqlQuery_auth = "Insert into auth set user_id=:user_id,
                                                               file_no=:file_no,
                                                               email=:email,
                                                               role=:role,
                                                               date_created=:date_created,
                                                               date_modified=:date_modified";

                        // pdostatement prepare
                        $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery_auth);

                        // bind parameters
                        $stmt->bindParam(":user_id",$new_user_id);
                        $stmt->bindParam(":file_no", $this->file_no);
                        $stmt->bindParam(":email", $this->email);
                        $stmt->bindParam(":role",$this->role);
                        $stmt->bindParam(":date_created", $this->date_created);
                        $stmt->bindParam(":date_modified", $this->date_modified);

                        //execute
                        $stmt->execute();

                        // if no error is encountered and raised..commit transaction
                        //$QueryExecutor->customQuery()->commit();
                        return $stmt;

                  } catch (Exception $e) {
                        if ($QueryExecutor->customQuery()->inTransaction()){
                          echo $e->getMessage();
                          $QueryExecutor->customQuery->rollBack();
                        }
                        throw $e;

                  }


            }// end of create user



        public function get_user_by_id($user_id){
              $this->user_id = $user_id;

              $sqlQuery = "Select u.id, u.file_no, u.title, u.first_name, u.last_name, u.other_names,
              u.position, u.avatar, a.email, a.role, up.user_category, up.dob, up.designation,
              up.grade_level, up.phone, up.about, u.date_created, u.date_modified from users u left join
              user_profiles up on u.id=up.user_id left join auth a on u.id=a.user_id
              where u.id=:user_id";

              //pdo object, prepare sql
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

              // bind parameters
              $stmt->bindParam(":user_id", $this->user_id);

              // execute and return recordset
              $stmt->execute();
              return $stmt;
        }




        public function is_fileno_used_other_than_this_user($user_id, $file_no){
              $this->user_id = $user_id;
              $this->file_no = $file_no;

              $sqlQuery = "Select * from users where file_no=:file_no and id!=:user_id";

              // pdo object, prepare
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

              // bind parameter
              $stmt->bindParam(":file_no", $this->file_no);
              $stmt->bindParam(":user_id", $this->user_id);

              // execute pdo object
              $stmt->execute();
              return $stmt;

        }



        public function is_email_used_other_than_this_user($user_id, $email){
              $this->user_id = $user_id;
              $this->email = $email;

              // sql PDOStatement
              $sqlQuery = "Select * from auth where email=:email and user_id!=:user_id";

              // pdo object, prepare
              $QueryExecutor = new PDO_QueryExecutor();
              $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

              // execute pdo object
              $stmt->bindParam(":email", $this->email);
              $stmt->bindParam(":user_id", $this->user_id);

              // execute pdo object
              $stmt->execute();
              return $stmt;
        }


        public function update_user($fields){
              $this->user_id = $fields['user_id'];
              $this->file_no = $fields['file_no'];
              $this->title = $fields['title'];
              $this->firstname = $fields['firstname'];
              $this->lastname = $fields['lastname'];
              $this->othernames = $fields['othernames'];
              $this->email = $fields['email'];
              $this->position = $fields['position'];
              $this->user_category = $fields['user_category'];
              $this->dob = $fields['dob'];
              $this->grade_level = $fields['grade_level'];
              $this->phone = $fields['phone'];
              $this->about = $fields['about'];


              //create pdo object
              $QueryExecutor = new PDO_QueryExecutor();

              // sql statement for user table
              $sqlQuery_user = "Update users set file_no=:file_no, title=:title, first_name=:first_name,
                                last_name=:last_name, other_names=:other_names, position=:position
                                where id=:user_id";

              // prepare sql
              $stmt_user = $QueryExecutor->customQuery()->prepare($sqlQuery_user);

              // bind parameters
              $stmt_user->bindParam(":user_id", $this->user_id);
              $stmt_user->bindParam(":file_no", $this->file_no);
              $stmt_user->bindParam(":title", $this->title);
              $stmt_user->bindParam(":first_name", $this->firstname);
              $stmt_user->bindParam(":last_name", $this->lastname);
              $stmt_user->bindParam(":other_names", $this->othernames);
              $stmt_user->bindParam(":position", $this->position);

              // execute pdo object
              $stmt_user->execute();

              // sql statement for auth table
              $sqlQuery_auth = "Update auth set file_no=:file_no, email=:email where user_id=:user_id";

              // prepare sql
              $stmt_auth = $QueryExecutor->customQuery()->prepare($sqlQuery_auth);

              // bind parameters
              $stmt_auth->bindParam(":user_id", $this->user_id);
              $stmt_auth->bindParam(":file_no", $this->file_no);
              $stmt_auth->bindParam(":email", $this->email);

              // execute pdo object
              $stmt_auth->execute();


              // Check if user profile has been Created
              $user_profile_exist = $this->is_user_profile_exist($this->user_id)->rowCount();
              //echo "Profile exist - ".$user_profile_exist;

              // current date_time
              // to get time-stamp for 'created' field
              $timestamp = date('Y-m-d H:i:s');
              $this->date_created = $timestamp;
              $this->date_modified = $timestamp;

              $sqlQuery_profile = '';
              $stmt_profile = '';

              switch ($user_profile_exist)
              {
                  // Update information user profile exists
                  // sql statement for user profile table
                  case 1:
                        $sqlQuery_profile = "Update user_profiles set user_category=:user_category, dob=:dob,
                                            grade_level=:grade_level, phone=:phone, about=:about, date_modified=:date_modified where user_id=:user_id";

                                            $stmt_profile = $QueryExecutor->customQuery()->prepare($sqlQuery_profile);

                                            // bind parameters
                                            $stmt_profile->bindParam(":user_id", $this->user_id);
                                            $stmt_profile->bindParam(":user_category", $this->user_category);
                                            $stmt_profile->bindParam(":dob", $this->dob);
                                            $stmt_profile->bindParam(":grade_level", $this->grade_level);
                                            $stmt_profile->bindParam(":phone", $this->phone);
                                            $stmt_profile->bindParam(":about", $this->about);
                                            $stmt_profile->bindParam(":date_modified", $this->date_modified);

                        break;

                  case 0:
                // Insert information into user profile if it doesn't exist
                // sql statement for user profile table
                        $sqlQuery_profile = "Insert into user_profiles set user_id=:user_id, user_category=:user_category, dob=:dob,
                                            grade_level=:grade_level, phone=:phone, about=:about, date_created=:date_created, date_modified=:date_modified";

                                            $stmt_profile = $QueryExecutor->customQuery()->prepare($sqlQuery_profile);

                                            // bind parameters
                                            $stmt_profile->bindParam(":user_id", $this->user_id);
                                            $stmt_profile->bindParam(":user_category", $this->user_category);
                                            $stmt_profile->bindParam(":dob", $this->dob);
                                            $stmt_profile->bindParam(":grade_level", $this->grade_level);
                                            $stmt_profile->bindParam(":phone", $this->phone);
                                            $stmt_profile->bindParam(":about", $this->about);
                                            $stmt_profile->bindParam(":date_created", $this->date_created);
                                            $stmt_profile->bindParam(":date_modified", $this->date_modified);


                        break;
              }

              //echo "<br/>".$sqlQuery_profile;
              // prepare



              // execute pdo object
              $stmt_profile->execute();

              if ($stmt_user && $stmt_auth && $stmt_profile){
                  return 1;
              }else{
                  return 0;
              }


        }



        public function is_user_profile_exist($user_id){
            $this->user_id = $user_id;
            $sqlQuery = "Select * from user_profiles where user_id=:user_id";

            // pdo object, prepare
            $QueryExecutor =  new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // object bind with parameters
            $stmt->bindParam(":user_id", $this->user_id);

            // execute
            $stmt->execute();
            return $stmt;
        }


        public function get_user_roles(){

            //sql PDOStatement
            $sqlQuery = "Select id, role, authority, description, date_created, date_modified from user_roles";

            // pdo object, prepare
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // execute pdo object
            $stmt->execute();
            return $stmt;
        }


        public function user_role_exist($role){
            $this->role = $role;
            // sql PDOStatement
            $sqlQuery = "Select * from user_roles where role=:role";

            // pdo object, prepare
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameters\
            $stmt->bindParam(":role", $this->role);

            // pdo object execute
            $stmt->execute();
            return $stmt;
        }



        public function create_user_role($fields){
            $this->role = $fields['role'];
            $this->authority = $fields['authority'];
            $this->description = $fields['description'];

            // sql PDOStatement
            $sqlQuery = "Insert into user_roles set role=:role, authority=:authority,
                        description=:description, date_created=:date_created, date_modified=:date_modified";

            // pdo object, prepare
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);


            // current date_time
            // to get time-stamp for 'created' field
            $timestamp = date('Y-m-d H:i:s');
            $this->date_created = $timestamp;
            $this->date_modified = $timestamp;

            // bind parameters
            $stmt->bindParam(":role", $this->role);
            $stmt->bindParam(":authority", $this->authority);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":date_created", $this->date_created);
            $stmt->bindParam(":date_modified", $this->date_modified);

            // execute sql pdo object execute
            $stmt->execute();
            return $stmt;
        }



        public function get_user_by_fileno($fileno){
            $this->file_no = $fileno;
            //sql PDOStatement
            $sqlQuery = "Select u.id, u.file_no, u.title, u.first_name, u.last_name, u.other_names, u.position,
                        u.avatar, u.date_created, u.date_modified, u.deleted, up.user_category, up.dob, up.grade_level,
                        up.phone, up.about from users u left join user_profiles up on u.id=up.user_id where u.file_no=:file_no
                        and u.deleted='' ";


            // pdo object, prepare
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // bind parameter
            $stmt->bindParam(":file_no", $this->file_no);

            // execute
            $stmt->execute();
            return $stmt;

        }



        public function get_user_roles_by_array_id($cell_user_roles){
            $sqlQuery = "Select id, role, authority from user_roles where id in ({$cell_user_roles})";

            //sql pdostatement
            $QueryExecutor = new PDO_QueryExecutor();
            $stmt = $QueryExecutor->customQuery()->prepare($sqlQuery);

            // execute
            $stmt->execute();
            return $stmt;
        }






    }


 ?>
