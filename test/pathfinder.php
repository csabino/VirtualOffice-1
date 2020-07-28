<?php
    $absolute_path = realpath("../baseurl.php");
    echo $absolute_path;

    echo "<br/>";
    $dirname = dirname($absolute_path);
    echo $dirname;

?>
