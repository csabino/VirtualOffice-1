<?php
  class NoticeBoard implements NoticeBoardInterface{

      public function onBoarding(){
          $sqlQuery = "Select id, type, cell, subject, message, sender, sender_position, date_created,
                      date_modified from notice_board where cell='' and deleted=''
                      order by id desc limit 1";
          //$QueryExecutor = new MySQL_QueryExecutor();
          //$result = $QueryExecutor::customQuery($sqlQuery);
          //echo $result->num_rows;
          //return $result
          $QueryExecutor = new PDO_QueryExecutor();
          $stmt = $QueryExecutor::customQuery()->prepare($sqlQuery);
          $stmt->execute();

          return $stmt;


      }
  }


 ?>
