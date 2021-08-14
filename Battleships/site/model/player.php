<?php 
class Player { 
    public $name;
    public $score;
    public $size;
    public $difficulty;

    function set_name($name){
     $this->name = $name;
    }

    function get_name(){
     return $this->name;   
    }

    function set_score($score) {
     $this->score = $score;   
    }

    function get_score() {
     return $this->score;   
    }

    function set_size($size) {
     $this->size = $size;   
    }
   
    function get_size() {
     return $this->size;   
    }

    function set_difficulty($difficulty) {
     $this->difficulty = $difficulty;   
    }
      
    function get_difficulty() {
     return $this->difficulty;   
    }
       
    function __construct($name, $score, $size, $difficulty) {
        $this->name = $name;
        $this->score = $score;
        $this->size = $size;
        $this->difficulty = $difficulty;
    }
}
?>