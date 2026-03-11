<?php
$pdo = new PDO('mysql:host=localhost;dbname=BikeService;charset=utf8', 'root', ''); 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['bike_name'] ?? '';
    $brand = $_POST['bike_brand'] ?? '';
    $year = $_POST['bike_year'] ?? '';
    $hp = $_POST['bike_hp'] ?? 0;
    $km = $_POST['bike_km'] ?? 0;

    if (!empty($name) && !empty($brand)) {
        $sql = "INSERT INTO Bikes (BikeName, BikeManufactor, BikeYear, BikeHP, BikeKM) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$name, $brand, $year, $hp, $km]);
            $message = "<p>Motorrad erfolgreich hinzugef&uuml;gt! <a class='btn-secondary' href='index.php'>Zur &Uuml;bersicht</a></p>";
        } catch (PDOException $e) {
            $message = "<p style='color: red;'>Fehler beim Speichern: " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p>Bitte Name und Hersteller angeben.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike-Service</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="colors.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form-container">
        <h1>Neues Motorrad anlegen</h1>
        
        <?php echo $message; ?>

        <form method="POST" action="add_bike.php">
            <div class="form-group">
                <label for="bike_brand">Hersteller:</label>
                <input type="text" id="bike_brand" name="bike_brand" required>
            </div>

            <div class="form-group">
                <label for="bike_name">Modellname:</label>
                <input type="text" id="bike_name" name="bike_name" required>
            </div>

            <div class="form-group">
                <label for="bike_year">Erstzulassung:</label>
                <input type="date" id="bike_year" name="bike_year">
            </div>

            <div class="form-group">
                <label for="bike_hp">Leistung (PS):</label>
                <input type="number" id="bike_hp" name="bike_hp">
            </div>

            <div class="form-group">
                <label for="bike_km">Aktueller Kilometerstand:</label>
                <input type="number" id="bike_km" name="bike_km">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Speichern</button>
                <a href="index.php" class="btn-secondary">Abbrechen</a>
            </div>
        </form>
    </div>
</body>
</html>