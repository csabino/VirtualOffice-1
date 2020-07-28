<?php

      $absolute_path =  realpath("../../core/wp_config.php");
      $position = strpos($absolute_path,"workplace");
      echo $absolute_path."<br/>";
      echo $position;

      echo "<br/>";
      $position = $position + 9;
      echo "<br/>".$position."<br/>";
      $new_string =  substr($absolute_path, $position, strlen($absolute_path));
      $new_string = str_replace("\\", "/", $new_string);

      echo $new_string;

       $link = "../../core/wp_config.php";
       echo "<br/>position: ".strpos(realpath($link),"workplace");
       echo "<br/>";
       $path = str_replace("\\","/", ((substr(realpath($link), (strpos(realpath($link),"workplace")+9)))));

       echo "<br/>";
       echo $path;
 ?>
