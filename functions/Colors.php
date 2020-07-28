<?php
      function color(){
        $code = array('#FDB2A1', '#FFC300', '#F7DD22', '#C3E614', '#8DE614', '#60E614', '#7EEB82',
                      '#7EEBC8', '#88CAF3', '#889FF3', '#A888F3', '#D288F3', '#F388F3', '#F388B2',
                      '#F38888', '#F38888', '#F38888', '#F3D988', '#F3EE88', '#DAF388');

        $code_length = count($code);
        $randIndex = mt_rand(0, $code_length-1);
         return $code[$randIndex];
      }

 ?>
