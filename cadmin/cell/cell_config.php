<?php
require_once("../../baseurl.php");
// Authorization acces
require_once("../../includes/is_login_auth.php");
// Functions - Include Directory
require_once("../../functions/FieldSanitizer.php");
require_once("../../functions/Alerts.php");


// Abstract - Abstract Directory
require_once("../../abstract/Database.php");
require_once("../../abstract/User.php");


// Interface - Interface Directory
require_once("../../interface/AuthInterface.php");
require_once("../../interface/DBInterface.php");
require_once("../../interface/NoticeBoardInterface.php");
require_once("../../interface/UserInterface.php");

 ?>
