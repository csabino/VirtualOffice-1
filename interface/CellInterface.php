<?php
    interface CellInterface{

       public function create_cell_type();
       public function create_cell($fields);
       public function is_cell_exist($cell_name);
       public function get_all_cells();
       public function get_cell_types();
    }


 ?>
