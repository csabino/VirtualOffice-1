<?php
    class FieldSanitizer{
        static function inClean($field){
            $result = trim(addslashes(htmlentities(htmlspecialchars($field))));
            return $result;
        }

        static function outClean($field){
            $result = trim(addslashes(htmlspecialchars($field)));
            return $result;
        }
    }


 ?>
