<?php
session_start();
unset($_SESSION['loggedIn_profile_user_id']);
unset($_SESSION['loggedIn_profile_file_no']);

$_SESSION['ulogin_state'] = '';

unset($_SESSION['ulogin_state']);
unset($_SESSION['ulogin_userid']);
unset($_SESSION['ulogin_role']);
unset($_SESSION['ulogin_fileno']);
unset($_SESSION['ulogin_email']);

header("location:../index.php");


 ?>
