<?php
//include "DbConnect.php";

class ShipController
{
    public static function PopulateShips($size, $difficulty)
    {
        $db = new DbConnect();
        $conn = $db->connect();

        ShipController::dropDB($conn);
        ShipController::createDB($conn);

        //Determin type and number of ships
        $ships = array();
        if ($size == 5 && $difficulty == "easy") {
            array_push($ships, new Ship(1, "submarine", "horizontal", "B2,B3"));
            array_push($ships, new Ship(2, "destroyer", "horizontal", "D3,D4,D5"));
        }
        if ($size == 5 && $difficulty == "medium") {
            array_push($ships, new Ship(1, "submarine", "horizontal", "B3,B4"));
            array_push($ships, new Ship(2, "destroyer", "vertical", "C1,D1,E1"));
        }
        if ($size == 5 && $difficulty == "hard") {
            array_push($ships, new Ship(1, "submarine", "vertical", "B2,C2"));
            array_push($ships, new Ship(2, "destroyer", "diagonal", "E3,D4,C5"));
        }

        if ($size == 7 && $difficulty == "easy") {
            array_push($ships, new Ship(1, "submarine", "vertical", "A2,B2"));
            array_push($ships, new Ship(2, "submarine", "vertical", "E6,F6"));
            array_push($ships, new Ship(3, "destroyer", "vertical", "A5,,B5,C5"));
            array_push($ships, new Ship(4, "destroyer", "vertical", "E1,F1,D1"));
            array_push($ships, new Ship(5, "cruiser", "vertical", "D3,E3,F3,G3"));
        }

        if ($size == 7 && $difficulty == "medium") {
            array_push($ships, new Ship(1, "submarine", "horizontal", "B5,B6"));
            array_push($ships, new Ship(2, "submarine", "vertical", "D7,E7"));
            array_push($ships, new Ship(3, "destroyer", "horizontal", "C1,C2,C3"));
            array_push($ships, new Ship(4, "destroyer", "vertical", "E2,F2,G2"));
            array_push($ships, new Ship(5, "cruiser", "horizontal", "G4,G5,G6,G7"));
        }

        if ($size == 7 && $difficulty == "hard") {
            array_push($ships, new Ship(1, "submarine", "vertical", "F5,G5"));
            array_push($ships, new Ship(2, "submarine", "diagonal", "B6,A7"));
            array_push($ships, new Ship(3, "destroyer", "horizontal", "B1,B2,B3"));
            array_push($ships, new Ship(4, "destroyer", "diagonal", "E1,F2,G3"));
            array_push($ships, new Ship(5, "cruiser", "horizontal", "D3,D4,D5,D6"));
        }

        if ($size == 10 && $difficulty == "easy") {
            array_push($ships, new Ship(1, "submarine","horizontal", "B8,B9"));
            array_push($ships, new Ship(2, "submarine","horizontal", "C5,C6"));
            array_push($ships, new Ship(3, "submarine","horizontal", "I2,I3"));
            array_push($ships, new Ship(4, "destroyer","horizontal", "H6,H7,H8"));
            array_push($ships, new Ship(5, "destroyer","horizontal", "E1,E2,E3"));
            array_push($ships, new Ship(6, "cruiser","horizontal", "J7,J8,J9,J10"));
            array_push($ships, new Ship(7, "cruiser","horizontal", "A2,A3,A4,A5"));
            array_push($ships, new Ship(8, "carrier","horizontal", "F5,F6,F7,F8,F9"));
        }

        if ($size == 10 && $difficulty == "medium") {
            array_push($ships, new Ship(1, "submarine","horizontal", "I4,I5"));
            array_push($ships, new Ship(2, "submarine","vertical", "F9,G9"));
            array_push($ships, new Ship(3, "submarine","horizontal", "A2,A3"));
            array_push($ships, new Ship(4, "destroyer","vertical", "D1,E1,F1"));
            array_push($ships, new Ship(5, "destroyer","horizontal", "I8,I9,I10"));
            array_push($ships, new Ship(6, "cruiser","horizontal", "B6,B7,B8,B9"));
            array_push($ships, new Ship(7, "cruiser","vertical", "C3,D3,E3,F3"));
            array_push($ships, new Ship(8, "carrier","horizontal", "D5,D6,D7,D8,D9"));
        }

        if ($size == 10 && $difficulty == "hard") {
            array_push($ships, new Ship(1, "submarine","diagonal", "F8,E9"));
            array_push($ships, new Ship(2, "submarine","horizontal", "B10,C10"));
            array_push($ships, new Ship(3, "submarine","vertical", "H3,I3"));
            array_push($ships, new Ship(4, "destroyer","diagonal", "A1,B2,C3"));
            array_push($ships, new Ship(5, "destroyer","horizontal", "J8,J9,J10"));
            array_push($ships, new Ship(6, "cruiser","horizontal", "H6,H7,H8,H9"));
            array_push($ships, new Ship(7, "cruiser","vertical", "D1,E1,F1,G1"));
            array_push($ships, new Ship(8, "carrier","diagonal", "F4,E5,D6,C7,B8"));
        }


        ShipController::InsertShips($conn,$ships);

        foreach($ships as $ship){
            $array = explode(',',$ship->get_location());
            foreach($array as $item){
                $stmt = $conn->prepare("UPDATE Squares SET shipId = ". $ship->get_id() ." WHERE id ='".$item."'");
                $stmt -> execute();
            }
        }
    }
    private static function dropDB($conn)
    {
        $stmt = $conn->prepare("DROP TABLE Ships");
        $stmt->execute();
    }

    private static function createDB($conn)
    {
        //$stmt = $conn->prepare("CREATE TABLE Ships (id int NOT NULL PRIMARY KEY, type varchar(20), size int, orientation varchar(20))");
        $stmt = $conn->prepare("CREATE TABLE Ships (id int NOT NULL PRIMARY KEY, type varchar(20), size int, orientation varchar(20), location varchar(20))");
        $stmt->execute();
    }

    private static function InsertShips($conn, $ships)
    {
        foreach($ships as $ship){
            //$stmt = $conn->prepare("INSERT INTO Ships (id, type, size, orientation) VALUES (".$ship->get_id().",'".$ship->get_type()."',". $ship->get_size().",'". $ship->get_orientation()."')");
            $stmt = $conn->prepare("INSERT INTO Ships (id, type, size, orientation, location) VALUES (".$ship->get_id().",'".$ship->get_type()."',". $ship->get_size().",'". $ship->get_orientation()."','".$ship->get_location()."')");
            $stmt -> execute();
        }
    }
}
