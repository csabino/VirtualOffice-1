<?php

  class FileUploader implements FileUploaderInterface{

      public function __construct(){
         return "Welcome to file uploader";
      }

      public function uploadFile($file_type, $source, $file){

          if ($file['name'] !=''){
              $fileName = $file['name'];  // $_FILES['file']['name']
              $split_name = explode('.', $fileName);
              $extension = end($split_name);
              $today = date('Ymd_H_i_s');
              $wp_name = $today.rand(100,999).'.'.$extension;

              if ($file_type=='document'){
                  $location = "../../../uploads/{$source}/documents/{$wp_name}";
              }else if($file_type='image'){
                  $location = "../../../uploads/{$source}/images/{$wp_name}";
              }

              $result = move_uploaded_file($file['tmp_name'], $location);

              $response = '';
              if ($result==1){
                  $response  = array("status"=>'success', "wp_filename"=>$wp_name);
              }else{
                  $response = array("status"=>'error', "wp_filename"=>'');
              }

              return $response;

          }

      }


      public function uploadVideo($file_type, $source, $file){

          if ($file['name'] !=''){
              $fileName = $file['name'];  // $_FILES['file']['name']
              $split_name = explode('.', $fileName);
              $extension = end($split_name);
              $today = date('Ymd_H_i_s');
              $wp_name = $today.rand(100,999).'.'.$extension;

              if ($file_type=='video'){
                  $location = "../../../uploads/{$source}/{$wp_name}";
              }else if($file_type='image'){
                  $location = "../../../uploads/{$source}/images/{$wp_name}";
              }

              $result = move_uploaded_file($file['tmp_name'], $location);

              $response = '';
              if ($result==1){
                  $response  = array("status"=>'success', "wp_filename"=>$wp_name);
              }else{
                  $response = array("status"=>'error', "wp_filename"=>'');
              }

              return $response;

          }

      }




  }



?>
