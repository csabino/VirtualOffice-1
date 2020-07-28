<?php
      function generate_code(){
        $code = '';
        $i = 0;
         $characters = "012345689abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ.!()";
         $character_length = strlen($characters);


         $randIndex = mt_rand(0, $character_length-1);
         for($i=0; $i<100; $i++ ){
            $randIndex = mt_rand(0, $character_length-1);
            $code .= $characters[$randIndex];
         }
         return $code;
      }

      function mask($item){
          $code_a = generate_code();
          $code_b = generate_code();

          $full_mask = $code_a."-{$item}-".$code_b;
          return $full_mask;
      }

      //$result = mask();
      //echo $result;
 ?>
