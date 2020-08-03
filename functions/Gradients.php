<?php
      function gradient(){
        $code = array('purple-gradient', 'blue-gradient', 'aqua-gradient', 'peach-gradient', 'warm-flame-gradient', 'night-fade-gradient', 'spring-warmth-gradient',
                      'juicy-peach-gradient', 'young-passion-gradient', 'rainy-ashville-gradient', 'sunny-morning-gradient', 'lady-lips-gradient', 'winter-neva-gradient', 'frozen-dreams-gradient',
                      'dusty-grass-gradient', 'tempting-azure-gradient', 'heavy-rain-gradient', 'amy-crisp-gradient', 'mean-fruit-gradient', 'deep-blue-gradient', 'ripe-malinka-gradient',
                      'morpheus-den-gradient', 'rare-wind-gradient', 'near-moon-gradient');

        $code_length = count($code);
        $randIndex = mt_rand(0, $code_length-1);
         return $code[$randIndex];
      }

 ?>
