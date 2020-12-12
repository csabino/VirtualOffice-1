<link href="https://fonts.googleapis.com/css2?family=Chilanka&family=Sacramento&family=Sansita+Swashed:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<?php

// get user eligibility
if (!isset($_GET['q']) || $_GET['q']==''){
      header("location: ../my_dashboard.php");
}

$_GET_URL_user_id = explode("-",htmlspecialchars(strip_tags($_GET['q'])));
$_GET_URL_user_id = $_GET_URL_user_id[1];

    $page_title = 'My Profile';

    require_once("../../config/step2/init_wp.php");
    require_once("../../nav/staff_nav.php");
    //require_once("../includes/staff_header.php");


    // get user profile information
    $user = new StaffUser();
    $profile = $user->getUserById($_GET_URL_user_id);
    $title = '';  $first_name = '';  $last_name = ''; $other_names = '';
    $full_name = ''; $position;
    $avatar = '../images/avatar_100.png';
    foreach($profile as $prof){
        $title = $prof['title'];
        $first_name = $prof['first_name'];
        $last_name = $prof['last_name'];
        $full_name = $title.' '.$last_name.' '.$first_name;
        $position = $prof['position'];
        if ($prof['avatar']!=''){
          $avatar = '../avatars/'.$prof['avatar'];
        }
    }



  ?>


  <!-- Dashboard body //-->
  <div class="container">

      <!-- Page header
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 page_header_spacer">
              <h3>Work Circle </h3>
          </div>
      </div>
      end of page header //-->



      <!-- main page area //-->
      <div class="row mt-3">
                  <div class="col-xs-11 col-sm-11 col-md-12 col-lg-12" style='padding:15px;'>
                    <!-- Card -->
                        <div class="card card-cascade wider reverse testimonial-card">

                                <!-- Background color -->
                                <div class="card-up blue-gradient lighten-2">
                                  <!--<img class="card-img-top"
                                      src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20%28131%29.jpg" alt="Card image cap">
                                      //-->
                                      <div  style='position:absolute;top:53px;left:160px;font-size:25px;color:#ffffff;font-family: Chilanka;'><?php echo $full_name;?></div>
                                      <div style='position:absolute;top:80px;left:160px;font-size:27px;color:#ffffff;font-family: Sacramento;'><?php echo $position;?></div>
                                      <div style='position:absolute;top:130px;left:160px;font-size:27px;'>
                                            <button type="button" class="btn btn-success btn-rounded btn-sm"><i class="fas fa-pen-alt"></i> Edit Profile</button>

                                      </div>
                                </div>

                                <!-- Avatar -->
                                <div class="avatar white ml-4">
                                <img src="<?php echo $avatar; ?>" class="rounded-circle"
                                  alt="woman avatar">
                                </div>

                                <!-- Content -->
                                <div class="card-body">

                                </div>

                        </div>
                    <!-- Card -->
                  </div>

      </div>
      <!-- end of main area //-->


  </div> <!-- end of container //-->

<br/><br/><br/>

<?php

    //footer.php
    require('../../includes/footer.php');
 ?>
