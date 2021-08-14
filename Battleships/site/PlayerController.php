<?php

class PlayerController{
    public static function GetPlayers(){
        $db = new DbConnect();
        $conn = $db->connect();

        $players = array();
        $stmt = $conn->prepare("SELECT * FROM Players ORDER BY _score DESC");    
        $stmt -> execute();
        $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
           $player = new Player($row["_name"],$row["_score"],$row["_size"],$row["_difficulty"]);
           array_push($players,$player);
        }
        return $players;
    }
}

function connect(){
    try {
        $host = '192.168.1.217';
        $dbName = 'battleships';
        $user = 'root';
        $pass = '12345';
        $conn = new PDO('mysql:host=' .$host .'; dbname=' .$dbName, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    }
}

if (isset($_POST['name'], $_POST['score'], $_POST['size'], $_POST['difficulty'])){
    $name = $_POST['name'];
    $score = $_POST['score'];
    $size = $_POST['size'];
    $difficulty = $_POST['difficulty'];

    $conn = connect();
    
    $stmt = $conn->prepare("INSERT INTO Players (_name, _score, _size, _difficulty) VALUES ('".$name."',".$score.",".$size.",'".$difficulty."')");
    $stmt -> execute(); 
}
?>