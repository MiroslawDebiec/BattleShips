<?php 
class Ship {
    public $id;
    public $type;
    public $size;
    public $orientation;
    public $location;

    function set_id($id){
     $this->id = $id;
    }

    function get_id(){
     return $this->id;   
    }

    function set_type($type) {
     $this->type = $type;   
    }

    function get_type() {
     return $this->type;   
    }

    function set_size($size) {
     $this->size = $size;   
    }
   
    function get_size() {
     return $this->size;   
    }
    function set_orientation($orientation) {
     $this->orientatione = $orientation;   
    }
      
    function get_orientation() {
     return $this->orientation;   
    }
       
    function set_location($location) {
     $this->location = $location;  
    }

    function get_location(){
     return $this->location;   
    }

    function __construct($id, $type, $orientation, $location) {
        $this->id = $id;
        $this->type = $type;
        $this->orientation = $orientation;
        $this->location = $location;
        if($type == "submarine") $this->size = 2;
        if($type == "destroyer") $this->size = 3;
        if($type == "cruiser") $this->size = 4;
        if($type == "carrier") $this->size = 5;
       }
}
?>