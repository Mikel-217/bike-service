<?php

class BikeCard {
    private $pdo;
    private $bikeId;

    // constructor for bike class and we want to things here :)
    public function __construct($pdo, $bikeId) {
        $this->pdo = $pdo;
        $this->bikeId = $bikeId;
    }

    public function render() {
        // gets the bike
        $stmt = $this->pdo->prepare("SELECT * FROM Bikes WHERE BikeId = ?");
        $stmt->execute([$this->bikeId]);
        $bike = $stmt->fetch(PDO::FETCH_ASSOC);

        // error just return empty
        if (!$bike) return "";
        
        // else return the
        $html = '<div class="bike-card">';
        $html .= '  <div>';
        $html .= '    <span class="manufactor">' . htmlspecialchars($bike['BikeManufactor']) . '</span>';
        $html .= '    <h3>' . htmlspecialchars($bike['BikeName']) . '</h3>';
        
        $html .= '    <div class="bike-stats">';
        $html .= '      <div><strong>Jahr:</strong> ' . date("Y", strtotime($bike['BikeYear'])) . '</div>';
        $html .= '      <div><strong>Leistung:</strong> ' . $bike['BikeHP'] . ' PS</div>';
        $html .= '      <div><strong>Kilometer:</strong> ' . number_format($bike['BikeKM'], 0, ',', '.') . ' km</div>';
        $html .= '    </div>';
        $html .= '  </div>';
        
        $html .= '  <a href="view_bike.php?id=' . $this->bikeId . '" class="btn-details">Details & Service</a>';
        $html .= '</div>';

        return $html;
    }
}