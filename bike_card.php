<?php

class BikeCard {
    private $bikeData;

    public function __construct(private PDO $pdo, private int $bikeId) {
        $this->loadData();
    }

    private function loadData() {
        $sql = "SELECT BikeName, BikeManufactor, BikeYear, BikeHP, BikeKM 
                FROM Bikes 
                WHERE BikeId = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->bikeId]);
        

        $this->bikeData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function render() {
        if (!$this->bikeData) {
            return "<div class='error'>Motorrad mit ID {$this->bikeId} nicht gefunden.</div>";
        }


        $name = htmlspecialchars($this->bikeData['BikeName']);
        $hersteller = htmlspecialchars($this->bikeData['BikeManufactor']);
        $jahr = date("Y", strtotime($this->bikeData['BikeYear']));
        $ps = (int)$this->bikeData['BikeHP'];
        $km = number_format($this->bikeData['BikeKM'], 0, ',', '.');

        return "
                <a href='view_bike.php?id={$this->bikeId}'>
                    <div class='section-bike'>
                        <h3>$hersteller $name</h3>
                        <p>Aktuell: $km km</p>
                    </div>
                </a>
            ";
    }
}