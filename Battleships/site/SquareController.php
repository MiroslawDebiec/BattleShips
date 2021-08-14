<?php
include "DbConnect.php";

class SquareController {
    public static function PopulateSquares($size){
        $db = new DbConnect();
        $conn = $db->connect();

        SquareController::dropDB($conn);
        SquareController::createDB($conn);

        $squares = array();
        $row = array('A','B','C','D','E','F','G','H','I','J','K');
        $col = array(1,2,3,4,5,6,7,8,9,10);

        for ($r = 0; $r < $size; $r++){
            for ($c = 0; $c < $size; $c++){
                $square = new Square($row[$r]."".$col[$c],$row[$r],$col[$c],0,0);
                SquareController::insertSquare($conn, $square);
            }
        } 
    }
  
    private static function dropDB($conn){
        $stmt = $conn->prepare("DROP TABLE Squares");
        $stmt -> execute();
    }

    private static function createDB($conn){
        $stmt = $conn->prepare("CREATE TABLE Squares (id varchar(10) NOT NULL PRIMARY KEY, _row varchar(10), _col int, selected BOOLEAN, hit BOOLEAN, shipId int)");
        $stmt -> execute();
    }

    private static function insertSquare($conn, $square){
        $stmt = $conn->prepare("INSERT INTO Squares (id, _row, _col, selected, hit, shipId) VALUES ('".$square->get_id()."','". $square->get_row()."',".$square->get_col().",FALSE, FALSE,".$square->get_shipId().")");
        $stmt -> execute();
    }

    public static function GetSquares(){
        $db = new DbConnect();
        $conn = $db->connect();
        $squares = array();
        $stmt = $conn->prepare("SELECT * FROM Squares");
        $stmt -> execute();
        $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
           $square = new Square($row["id"],$row["_row"],$row["_col"],$row["selected"],$row["shipId"]);
           array_push($squares,$square);
        }
        return $squares;
    }

    public static function SelectSquare($x, $y){
        $db = new DbConnect();
        $conn = $db->connect();
        $stmt = $conn->prepare("UPDATE Squares SET selected = TRUE WHERE id =". $x. "". $y);
        $stmt -> execute();
    }

    public static function InsertShips($ships){
        $db = new DbConnect();
        $conn = $db->connect();

        foreach($ships as $ship){
            $array = explode('-',$ship->get_location());
            foreach($array as $item){
                $stmt = $conn->prepare("UPDATE Squares SET selected = TRUE, shipId = 1  WHERE id =".$item);
                $stmt -> execute();
            }
        }
    }

    private static function GetSquaresFromArray($string){
        $array = array();
        $array = explode('-',$string);
        return $array;
    }

    public static function DisplaySquares($squares, $size){
        $row = array('A','B','C','D','E','F','G','H','I','J','K');
        $col = array(1,2,3,4,5,6,7,8,9,10);

        $response="";

        for($r = 0; $r <= $size; $r++){
            $response += "<div class='row'>";
            for($c = 0; $c <= $size; $c++){
              foreach($squares as $square){
                if($square->get_row()== $row[$r] && $square->get_col()== $col[$c]){
                    $response+= "<button type='submit' class='box' row='".$square->get_row()."' col=".$square->get_col()."><div class='inner'>".$square->get_id()."</div></button>";
                }
              }
            }
            $response +="</div>";
        } 
        return $response;
      }

}

if (isset($_POST['row'],$_POST['col'])) {
    $row_val = $_POST['row'];
    $col_val = $_POST['col'];
    $db = new DbConnect();
    $conn = $db->connect();
    $stmt = $conn->prepare("UPDATE Squares SET selected = TRUE WHERE id ='". $row_val."". $col_val."'");
    $stmt -> execute(); 
    $stmt = $conn->prepare("UPDATE Squares SET hit = TRUE WHERE id ='". $row_val."". $col_val."' AND shipId > 0");
    $stmt -> execute(); 
    
    $stmt = $conn->prepare("SELECT * FROM Squares WHERE id ='". $row_val."". $col_val."'");    
    $stmt -> execute();
    $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
       $data["hit"] = $row["hit"];
    }
    echo json_encode($data);
}

?>