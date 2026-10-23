<?php

require_once __DIR__ . "/Database.php";

class AdminStats extends Database {

    public function countPatients() {

        $sql = "SELECT COUNT(*) FROM users WHERE role = 'patient'";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

public function countPhysiotherapists() {

    $sql = "SELECT COUNT(*) FROM users WHERE role = 'physiotherapist'";

    $stmt = $this->connect->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}
   
public function countSessions() {

    $sql = "SELECT COUNT(*) FROM sessions";

    $stmt = $this->connect->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}
public function countAppointments() {

    $sql = "SELECT COUNT(*) FROM appointments";

    $stmt = $this->connect->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}
}

