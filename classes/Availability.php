
<?php

require_once __DIR__ . "/Database.php";

class Availability extends Database {

    public function addAvailability($physiotherapistId, $date, $time) {

        $sql = "INSERT INTO availability
                (physiotherapist_id, available_date, available_time)
                VALUES (?, ?, ?)";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $physiotherapistId,
            $date,
            $time
        ]);
    }
}
