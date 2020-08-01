<?php
require_once("../../baseurl.php");
// Authorization acces
require_once("../../includes/is_login_auth.php");
// Functions - Include Directory
require_once("../../functions/FieldSanitizer.php");
require_once("../../functions/Alerts.php");
require_once("../../functions/Encrypt.php");
require_once("../../functions/Colors.php");



// Abstract - Abstract Directory
require_once("../../abstract/Database.php");
require_once("../../abstract/User.php");


// Interface - Interface Directory
require_once("../../interface/AuthInterface.php");
require_once("../../interface/DBInterface.php");
require_once("../../interface/NoticeBoardInterface.php");
require_once("../../interface/UserInterface.php");
require_once("../../interface/CellInterface.php");
require_once("../../interface/CircleInterface.php");
require_once("../../interface/FileUploaderInterface.php");
require_once("../../interface/AnnouncementInterface.php");

// Logged-In Header
require_once("../../includes/logged_in_header.php");


// Class Autoload
spl_autoload_register('classAutoLoader');


function classAutoLoader($class){
    $path = "../../classes/";
    $class = "{$path}{$class}.php";
    include_once($class);
}


 ?>
