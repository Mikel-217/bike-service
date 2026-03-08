<?php
require_once 'bike_card.php';
    $pdo = new PDO('mysql:host=localhost;dbname=BikeService;charset=utf8', 'root', ''); 
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bike-Service</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="overview-section">
        <div class="overview-section-content">
            <h1>Übersicht:</h1>
            <div class="overview-section-bike">
                <?php

                $stmt = $pdo->query("SELECT BikeId FROM Bikes ORDER BY BikeName ASC");
                $bikeIds = $stmt->fetchAll(PDO::FETCH_COLUMN);


                if (empty($bikeIds)) {
                    echo "<p>Noch keine Motorr&auml;der angelegt.</p>";
                } else {
                    foreach ($bikeIds as $id) {
                        $card = new BikeCard($pdo, $id);
                        echo $card->render();
                    }
                }
                ?>
            </div>

            <div class="overview-section-button">
                <a href="add_bike.php" class="btn-main">Neues Motorrad hinzuf&uuml;gen</a>
            </div>
        </div>
    </div>
</body>
</html>