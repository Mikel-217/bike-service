<?php

$pdo = new PDO('mysql:host=localhost;dbname=BikeService;charset=utf8', 'root', ''); 

$bikeId = $_GET['id'] ?? null;

if (!$bikeId) {
    die("Kein Motorrad ausgewählt.");
}

$stmt = $pdo->prepare("SELECT * FROM Bikes WHERE BikeId = ?");
$stmt->execute([$bikeId]);
$bike = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$bike) {
    die("Motorrad nicht gefunden.");
}

$serviceStmt = $pdo->prepare("SELECT * FROM Services WHERE BikeId = ? ORDER BY ServiceKM DESC");
$serviceStmt->execute([$bikeId]);
$services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($bike['BikeName']); ?> - Details</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="detail-container">
    <a href="index.php" class="back-link">&larr; Zurück zur Übersicht</a>
    
    <div class="bike-header">
        <h1><?php echo htmlspecialchars($bike['BikeManufactor'] . " " . $bike['BikeName']); ?></h1>
        <p>
            <strong>Baujahr:</strong> <?php echo date("Y", strtotime($bike['BikeYear'])); ?> | 
            <strong>Leistung:</strong> <?php echo $bike['BikeHP']; ?> PS | 
            <strong>Aktueller Stand:</strong> <?php echo number_format($bike['BikeKM'], 0, ',', '.'); ?> km
        </p>
    </div>

    <h2>Service-Historie</h2>
    <a href="add_service.php?bike_id=<?php echo $bikeId; ?>" class="btn-main">+ Neuen Service eintragen</a>

    <?php if (empty($services)): ?>
        <p>Bisher wurden keine Services für dieses Motorrad eingetragen.</p>
    <?php else: ?>
        <table class="service-list">
            <thead>
                <tr>
                    <th>Kilometer</th>
                    <th>Service</th>
                    <th>Inhalt / Notizen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                <tr>
                    <td><span class="km-badge"><?php echo number_format($s['ServiceKM'], 0, ',', '.'); ?> km</span></td>
                    <td><strong><?php echo htmlspecialchars($s['ServiceName']); ?></strong></td>
                    <td><?php echo nl2br(htmlspecialchars($s['ServiceContent'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>