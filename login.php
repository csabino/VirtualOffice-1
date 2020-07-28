<?php

      $page_title = "Login";
      // Core
      require_once("core/config.php");
      // Header
      require_once("includes/header.php");
      // Navigation
      require_once("nav/nav_login.php");




      $err_flag = 0;
      $err_msg = null;
      if (isset($_POST['formLogin'])){
          $username = FieldSanitizer::inClean($_POST['loginUsername']);
          $password = FieldSanitizer::inClean($_POST['loginPassword']);

          if (($username != "") || ($password != "")){

              $auth = new Auth();
              $stmt = $auth->login($username, $password);
              $recordFound = $stmt->rowCount();
              if ($recordFound){

                  // login succeeds
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);

                  //Start session
                  session_start();
                  $_SESSION['ulogin_state'] = 200;
                  $_SESSION['ulogin_id'] = $row['id'];
                  $_SESSION['ulogin_userid'] = $row['user_id'];
                  $_SESSION['ulogin_role'] = $row['role'];
                  $_SESSION['ulogin_fileno'] = $row['file_no'];
                  $_SESSION['ulogin_email'] = $row['email'];

                  //Redirect to appropriate dashboard
                  if ($_SESSION['ulogin_role']=='admin'){
                      header("location: cadmin/admin_dashboard.php");
                  }elseif($_SESSION['ulogin_role']=='staff'){
                      header("location: staff/my_dashboard.php");
                  }


              }else{
                 // login fails
                 $err_flag = 1;
                 $err_msg = "Invalid login credentials";
              }

          }else{
              $err_msg = "Username and Password are required.";
              $err_flag = 1;
          }

      }



 ?>

<div class="container-fluid">
    <div class="row d-flex justify-content-center" style="margin-top:20px;">

      <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <!-- Material form login -->
            <div class="card">
                <h5 class="card-header primary-color white-text text-center py-4" style="opacity:0.6">
                  <strong>Sign in</strong>
                </h5>

                <!--Card content-->
                <div class="card-body px-lg-5 pt-0">

                    <!-- Form -->
                    <form class="text-center" style="color: #757575;" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                          <!-- Submit Feedback  -->
                          <div class="md-form">
                              <?php
                                  if (isset($_POST['formLogin'])){
                                        if ($err_flag==1){
                                              miniErrorAlert($err_msg);
                                        }
                                  }
                              ?>
                          </div>

                          <!-- Email -->
                          <div class="md-form">
                            <input type="text" id="loginUsername" name="loginUsername" class="form-control">
                            <label for="loginUsername">Username</label>
                          </div>

                          <!-- Password -->
                          <div class="md-form">
                            <input type="password" id="loginPassword" name="loginPassword" class="form-control">
                            <label for="loginPassword">Password</label>
                          </div>

                          <div class="d-flex justify-content-around">
                            <div>
                              <!-- Remember me -->
                              <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="loginFormRemember">
                                <label class="form-check-label" for="loginFormRemember">Remember me</label>
                              </div>
                            </div>
                            <div>
                              <!-- Forgot password -->
                              <a href="">Forgot password?</a>
                            </div>
                          </div>

                          <!-- Sign in button -->
                          <button name="formLogin" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0" type="submit">Sign in</button>


                      </form>
                      <!-- Form -->

                </div><!-- Card content //-->


            </div><!-- Material form login -->

      </div><!-- end of columm //-->



    </div><!-- end of row //-->
</div><!-- end of container //-->

<br/><br/>
<?php
      //footer
      require_once("includes/footer.php");
 ?>
