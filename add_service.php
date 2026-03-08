<?php
$pdo = new PDO('mysql:host=localhost;dbname=BikeService;charset=utf8', 'root', ''); 

$message = "";
$bikeId = $_GET['bike_id'] ?? null;

if ($bikeId) {
    $stmt = $pdo->prepare("SELECT BikeName, BikeManufactor FROM Bikes WHERE BikeId = ?");
    $stmt->execute([$bikeId]);
    $bike = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$bike) {
    die("Fehler: Kein gültiges Motorrad ausgewählt.");
}


$typeStmt = $pdo->query("SELECT * FROM ServiceType");
$serviceTypes = $typeStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceName = $_POST['service_name'] ?? '';
    $content = $_POST['service_content'] ?? '';
    $km = $_POST['service_km'] ?? 0;

    if (!empty($serviceName)) {
        $sql = "INSERT INTO Services (ServiceName, ServiceContent, ServiceKM, BikeId) 
                VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$serviceName, $content, $km, $bikeId]);
            $message = "<p style='color: green;'>Service-Eintrag erfolgreich gespeichert! <a href='index.php'>Zurück</a></p>";
        } catch (PDOException $e) {
            $message = "<p style='color: red;'>Fehler: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Service hinzufügen - Bike-Service</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="form-container">
        <h1>Service eintragen</h1>
        
        <div class="bike-info">
            <strong>Motorrad:</strong> <?php echo htmlspecialchars($bike['BikeManufactor'] . " " . $bike['BikeName']); ?>
        </div>

        <?php echo $message; ?>

        <form method="POST">
            <div class="form-group">
                <label for="service_name">Service Art:</label>
                <select id="service_name" name="service_name" required>
                    <option value="">-- Bitte wählen --</option>
                    <?php foreach ($serviceTypes as $type): ?>
                        <option value="<?php echo htmlspecialchars($type['ServiceName']); ?>">
                            <?php echo htmlspecialchars($type['ServiceName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="service_km">Kilometerstand beim Service:</label>
                <input type="number" id="service_km" name="service_km" required>
            </div>

            <div class="form-group">
                <label for="service_content">Details / Notizen:</label>
                <textarea id="service_content" name="service_content" rows="4" placeholder="z.B. &Ouml;lwechsel, Filter neu, Bremsbel&auml;ge hinten..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Service speichern</button>
            <p style="text-align: center; margin-top: 15px;">
                <a href="index.php">Abbrechen</a>
            </p>
        </form>
    </div>
</body>
</html>