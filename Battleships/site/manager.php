<?php
include "DbConnect.php";
include "SquareController.php";

// class Manager {
//     public static function Populate($size, $difficulty){
//         MANAGER::DropDB();
//         MANAGER::CreateDB();
//         $squares = array();
//         for ($x = 1; $x <= $size; $x++){
//             for ($y = 1;$y <= $size; $y++){
//                 $square = new Square($x,$y);
//                 MANAGER::InsertSquare($square);
//                 array_push($squares,$square);
//             }
//         } 
//         Manager::PopulateShips($squares,$difficulty);
//         return $squares;
//     }
  
//     public static function DropDB(){
//         $db = new DbConnect();
//         $conn = $db->connect();
//         $stmt = $conn->prepare("DROP TABLE Squares");
//         $stmt -> execute();
//     }

//     public static function CreateDB(){
//         $db = new DbConnect();
//         $conn = $db->connect();
//         $stmt = $conn->prepare("CREATE TABLE Squares (id int, x int, y int, selected BOOLEAN, restricted BOOLEAN, shipId int, vh int, hh int, dh int)");
//         $stmt -> execute();
//     }

//     public static function InsertSquare($square){
//         $db = new DbConnect();
//         $conn = $db->connect();
//         $stmt = $conn->prepare("INSERT INTO Squares (id, x, y, selected) VALUES (".$square->get_x()."".$square->get_y().",". $square->get_x().",".$square->get_y().",FALSE);");
//         $stmt -> execute();
//     }

//     public static function PopulateShips($squares, $difficulty){
//         //Dtermin number of squres vs available to populate; 
//         $numb = count($squares);
//         $orinetations = array("vertical", "horizontal","diagonal");
//         //Determin type and number of ships
//         $ships = array();
//         if($numb == 25 && $difficulty == "easy"){
//             $orient = $orinetations[rand(0,1)];
//             array_push($ships,new Ship(1,"submarine",$orient)); 
//             array_push($ships,new Ship(2,"destroyer",$orient));
//         }
//         if($numb == 25 && $difficulty == "medium"){
//             array_push($ships,new Ship(1,"submarine",$orinetations[rand(0,1)])); 
//             array_push($ships,new Ship(2,"destroyer",$orinetations[rand(0,1)]));
//         }
//         if($numb == 25 && $difficulty == "hard"){
//             array_push($ships,new Ship(1,"submarine",$orinetations[rand(0,2)])); 
//             array_push($ships,new Ship(2,"destroyer",$orinetations[rand(0,2)]));
//         }

//         if($numb == 49 && $difficulty == "easy" ){
//             $orient = $orinetations[rand(0,1)];
//             array_push($ships,new Ship(1,"submarine",$orient));
//             array_push($ships,new Ship(2,"submarine", $orient)); 
//             array_push($ships,new Ship(3,"destroyer", $orient));
//             array_push($ships,new Ship(4,"destroyer", $orient));
//             array_push($ships,new Ship(5,"cruiser", $orient));
//         }

//         if($numb == 49 && $difficulty == "medium" ){
//             array_push($ships,new Ship(1,"submarine", $orinetations[rand(0,1)]));
//             array_push($ships,new Ship(2,"submarine", $orinetations[rand(0,1)])); 
//             array_push($ships,new Ship(3,"destroyer", $orinetations[rand(0,1)]));
//             array_push($ships,new Ship(4,"destroyer", $orinetations[rand(0,1)]));
//             array_push($ships,new Ship(5,"cruiser", $orinetations[rand(0,1)]));
//         }

//         if($numb == 49 && $difficulty == "hard" ){
//             array_push($ships,new Ship(1,"submarine", $orinetations[rand(0,2)]));
//             array_push($ships,new Ship(2,"submarine", $orinetations[rand(0,2)])); 
//             array_push($ships,new Ship(3,"destroyer", $orinetations[rand(0,2)]));
//             array_push($ships,new Ship(4,"destroyer", $orinetations[rand(0,2)]));
//             array_push($ships,new Ship(5,"cruiser", $orinetations[rand(0,2)]));
//         }   

//         if($numb == 100 && $difficulty == "easy"){
//             $orient = $orinetations[rand(0,1)];
//             array_push($ships,new Ship(1,"submarine",$orient));
//             array_push($ships,new Ship(2,"submarine",$orient)); 
//             array_push($ships,new Ship(3,"submarine",$orient));
//             array_push($ships,new Ship(4,"destroyer",$orient));
//             array_push($ships,new Ship(5,"destroyer",$orient));
//             array_push($ships,new Ship(6,"cruiser",$orient));
//             array_push($ships,new Ship(7,"cruiser",$orient));
//             array_push($ships,new Ship(8,"carrier",$orient));
//         }

//         if($numb == 100 && $difficulty == "medium"){
//             array_push($ships,new Ship(1,"submarine",$orinetations[rand(0,1)]));
//             array_push($ships,new Ship(2,"submarine",$orinetations[rand(0,1)])); 
//             array_push($ships,new Ship(3,"submarine",$orinetations[rand(0,1)]));
//             array_push($ships,new Ship(4,"destroyer",$orinetations[rand(0,1)]));
//             array_push($ships,new Ship(5,"destroyer",$orinetations[rand(0,1)]));
//             array_push($ships,new Ship(6,"cruiser",$orinetations[rand(0,1)]));
//             array_push($ships,new Ship(7,"cruiser",$orinetations[rand(0,1)]));
//             array_push($ships,new Ship(8,"carrier",$orinetations[rand(0,1)]));
//         }

//         if($numb == 100 && $difficulty == "hard"){
//             array_push($ships,new Ship(1,"submarine",$orinetations[rand(0,2)]));
//             array_push($ships,new Ship(2,"submarine",$orinetations[rand(0,2)])); 
//             array_push($ships,new Ship(3,"submarine",$orinetations[rand(0,2)]));
//             array_push($ships,new Ship(4,"destroyer",$orinetations[rand(0,2)]));
//             array_push($ships,new Ship(5,"destroyer",$orinetations[rand(0,2)]));
//             array_push($ships,new Ship(6,"cruiser",$orinetations[rand(0,2)]));
//             array_push($ships,new Ship(7,"cruiser",$orinetations[rand(0,2)]));
//             array_push($ships,new Ship(8,"carrier",$orinetations[rand(0,2)]));
//         }

//         Manager::InsertShips($ships);
//         //LOOP->Place Ships<-LOOP
//         //Get Square vh, hh, dh
//     } 


//     public static function getSquares(){
//         $db = new DbConnect();
//         $conn = $db->connect();
//         $stmt = $conn->prepare("SELECT * FROM Squares");
//         $stmt -> execute();
//         $squares = $stmt -> fetchAll(PDO::FETCH_ASSOC);
//         return $squares;
//     }

//     public static function InsertShips($ships)
//     {
//         $db = new DbConnect();
//         $conn = $db->connect();
//         $stmt = $conn->prepare("DROP TABLE Ships");
//         $stmt -> execute();
//         $stmt = $conn->prepare("CREATE TABLE Ships (id int, type varchar(20), size int, orientation varchar(20))");
//         $stmt -> execute();
//         foreach($ships as $ship){
//             $stmt = $conn->prepare("INSERT INTO Ships (id, type, size, orientation) VALUES (".$ship->get_id().",'".$ship->get_type()."',". $ship->get_size().",'". $ship->get_orientation()."')");
//             $stmt -> execute();
//         }
//     }
// }

class manager{
    public static function CalculateSquareHealth(){
        $db = new DbConnect();
        $conn = $db->connect();



        //Get Squares
        $squares = SquareController::GetSquares();
        //Calculate vh,hh,dh 
        foreach ($squares as $square) {
            //Set Vertical Health (vh)
            //$square->set_vh(SquareController::calcVerticalHealth($squares, $square));
            $square->set_vh(123);
            //Set Vertical Health (vh)
            //Set Vertical Health (dh)
            //Update table  
            $stmt = $conn->prepare("UPDATE Squares SET vh = ".$square->get_vh()." WHERE id =".$square->get_id());
            $stmt -> execute();
        }     
    }

    private static function calcVerticalHealth($squares, $square){
        $x = $square->get_x();
        $y = $square->get_y();
        $vh=0;
        foreach($squares as $s){
            if($s->get_selected()==False && $s->get_y()==$y) $vh++; 
        }
        return $vh;
    }

}

if (isset($_POST['x'],$_POST['y'])) {
    $x_val = $_POST['x'];
    $y_val = $_POST['y'];
    $db = new DbConnect();
    $conn = $db->connect();
    $stmt = $conn->prepare("UPDATE Squares SET selected = TRUE WHERE id =". $x_val."". $y_val);
    $stmt -> execute(); 
    manager::CalculateSquareHealth();
}
?>