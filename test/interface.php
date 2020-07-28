<?php

  interface Vehicle{
      public function moving($model);
      public function stop();
  }

  abstract class Student{
      public function __construct(){
          echo "I am here";
      }
      abstract public function registration() : string;

  }

  class Bus extends Student implements Vehicle{
      public function moving($model){

      }

      public function stop(){

      }

      public function registration():string{

      }


  }































































































































































 ?>
