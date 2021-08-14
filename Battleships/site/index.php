<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <title>Document</title>
</head>

<body>



    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h2 class="text-center">Game Menu</h2>
                <hr>
                <form name="menu" method="post" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?php if (isset($_POST['name'])) {
                                                                                                                                echo $_POST['name'];
                                                                                                                            } ?>" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="size" id="size" required>
                            <option value="">Select Size</option>
                            <option <?php echo (isset($_POST['size']) && $_POST['size'] == 5) ? 'selected="selected"' : ''; ?> value="5"> Small (5x5)</option>
                            <option <?php echo (isset($_POST['size']) && $_POST['size'] == 7) ? 'selected="selected"' : ''; ?> value="7"> Medium (7x7)</option>
                            <option <?php echo (isset($_POST['size']) && $_POST['size'] == 10) ? 'selected="selected"' : ''; ?> value="10">Large (10x10)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="difficulty" id="difficulty" required>
                            <option value="">Select Difficulty</option>
                            <option <?php echo (isset($_POST['difficulty']) && $_POST['difficulty'] == "easy") ? 'selected="selected"' : ''; ?> value="easy">Easy (Vertical or Horizontal)</option>
                            <option <?php echo (isset($_POST['difficulty']) && $_POST['difficulty'] == "medium") ? 'selected="selected"' : ''; ?> value="medium">Medium (Vertical and Horizontal)</option>
                            <option <?php echo (isset($_POST['difficulty']) && $_POST['difficulty'] == "hard") ? 'selected="selected"' : ''; ?> value="hard">Hard (Vertical, Horizontal, Diagonal)</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="startGame" id="StartBtn">Start</button>
                    </div>
                </form>
                <div class="stats">
                </div>
                <div class="score">
                </div>
            </div>

            <div class="col-sm-9">
                <div class="container-fluid">

                    <?php
                    include "model/square.php";
                    include "model/ship.php";
                    include "model/player.php";
                    include "SquareController.php";
                    include "ShipController.php";
                    include "PlayerController.php";

                    if (isset($_POST['startGame'])) {

                        $size = $_POST['size'];
                        $difficulty = $_POST['difficulty'];

                        SquareController::PopulateSquares($size);
                        ShipController::PopulateShips($size, $difficulty);

                        $squares = SquareController::getSquares();

                        $row = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K');
                        $col = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);


                        for ($r = 0; $r <= $size; $r++) {
                            echo ("<div class='row'>");
                            for ($c = 0; $c <= $size; $c++) {
                                foreach ($squares as $square) {
                                    if ($square->get_row() == $row[$r] && $square->get_col() == $col[$c]) {
                                        echo ("<div type='submit' class='box' row='" . $square->get_row() . "' col=" . $square->get_col() . " id='" . $square->get_id() . "'><div class='inner'>" . $square->get_id() . "</div></div>");
                                    }
                                }
                            }
                            echo ("</div>");
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Leaderboard</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Player</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Difficulty</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>
                            <tbody id="leaderbord">
                                <?php
                                $players = PlayerController::GetPlayers();
                                $index = 0;
                                foreach ($players as $player) {
                                    $index++;
                                    echo ("<tr><th scope = 'row'>" . $index . "</th><td>" . $player->get_name() . "</td><td>" . $player->get_size() . "</td><td>" . $player->get_difficulty() . "</td><td>" . $player->get_score() . "</td></tr>");
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            var size = $("#size option:selected").val();
            var difficulty = $("#difficulty option:selected").val();
            var score = 0;
            var shots = parseInt((size * size) / 2);
            var name = "";

            $("#size").change(function() {
                size = $("#size option:selected").val();
                if (size == 5) {
                    $(".stats").html("<img src='images/submarine.png'/>" + "<img src='images/destroyer.png'/>");
                } else if (size == 7) {
                    $(".stats").html("<div><img src='images/submarine.png'/><img src='images/submarine.png'/>" + "<img src='images/destroyer.png'/><img src='images/destroyer.png'/>" + "<img src='images/cruiser.png'/>");
                } else if (size == 10) {
                    $(".stats").html("<img src='images/submarine.png'/><img src='images/submarine.png'/><img src='images/submarine.png'/>" + "<img src='images/destroyer.png'/><img src='images/destroyer.png'/>" + "<img src='images/cruiser.png'/><img src='images/cruiser.png'/><img src='images/carrier.png'/>");
                } else {
                    alert("Select Size");
                }
            });

            $("#modal_close").click(function() {
                window.location.reload();
            })

            $('.box').click(function() {

                shots--;
                var col_val = $(this).attr("col");
                var row_val = $(this).attr("row");
                var id = row_val + "" + col_val;

                $.ajax({
                    url: "SquareController.php",
                    method: "POST",
                    data: {
                        'row': row_val,
                        'col': col_val
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $(this).text(data.hit);
                        if (data.hit == 1) {
                            $("#" + id).css("background-image", "url('fire.jpg')");
                            score++;
                            $(".score").html("<div><h3>Shots :" + shots + "</h3></div>" + "<div><h3>Score :" + score + "</h3></div>");
                        } else {
                            $("#" + id).css("filter", "grayscale(100%)");
                        }
                    }
                })

                $(".score").html("<div><h3>Shots :" + shots + "</h3></div>" + "<div><h3>Score :" + score + "</h3></div>");

                if (shots <= 0) {
                    name = $("#name").val();
                    alert("Game Over " + name + ", You Scored: " + score + " at " + size + "/" + difficulty);
                    $.ajax({
                        url: "PlayerController.php",
                        method: "POST",
                        data: {
                            'name': name,
                            'score': score,
                            'size': size,
                            'difficulty': difficulty
                        },
                        dataType: "JSON",
                        success: function(data) {
                            data.forEach(myFunction);
                        }
                    })
                    $("#myModal").modal('toggle');

                }
            });
        });
    </script>

</body>

</html>