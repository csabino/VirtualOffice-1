<?php
session_start();
unset($_SESSION['loggedIn_profile_user_id']);
unset($_SESSION['loggedIn_profile_file_no']);
header("location:../index.php");


 ?>
