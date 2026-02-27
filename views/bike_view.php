<?php

class BikeCard {
    private $bikeData;

    public function __construct(private PDO $pdo, private int $bikeId) {
        $this->loadData();
    }

    private function loadData() {
        $stmt = $this->pdo->prepare("");
        $stmt->execute([$this->bikeId]);
        $this->bikeData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function render() {
        if (!$this->bikeData) {
            return "<div class='error'>Motorrad</div>";
        }
        return "
            <div class='section-bike'>
                <h3></h3>
                <p></p>
                <p></p>
            </div>
        ";
    }
}
