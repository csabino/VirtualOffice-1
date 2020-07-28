<?php
    $link = "../config/init_wp.php";
    $config_path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"workplace")+9)))));
    require_once("../".$config_path);

 ?>
