<?php 
class Square {
    public $id;
    public $row;
    public $col;
    public $selected;
    public $shipId;

    function set_id($id) {
     $this->id = $id;
    }
   
    function get_id() {
     return $this->id;   
    }

    function set_row($row) {
     $this->row = $row;   
    }

    function get_row() {
     return $this->row;   
    }

    function set_col($col) {
     $this->col = $col;   
    }
   
    function get_col() {
     return $this->col;   
    }

    function set_selected($selected) {
     $this->selected = $selected;   
    }
         
    function get_selected() {
     return $this->selected;   
    }

    function set_shipId($shipId) {
     $this->shipId = $shipId;
    }
      
    function get_shipId() {
     return $this->shipId;   
    }
    
    function __construct($id, $row, $col, $selected, $shipId){
     $this->id = $id;  
     $this->row = $row;
     $this->col = $col;   
     $this->selected = $selected;
     $this->shipId = $shipId;
    }
}
?>