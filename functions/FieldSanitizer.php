<?php
    class FieldSanitizer{
        static function inClean($field){
            $result = trim(addslashes($field));
            return $result;
        }

        static function outClean($field){
            $result = trim(stripslashes(htmlspecialchars($field)));
            return $result;
        }
    }


 ?>
