
<?php

require_once __DIR__ . "/Database.php";

class TherapySession extends Database {

    public function getAllSessions() {

        $sql = "SELECT * FROM sessions ORDER BY id DESC";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSession($name, $duration, $price) {

        $sql = "INSERT INTO sessions (name, duration, price)
                VALUES (?, ?, ?)";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([$name, $duration, $price]);
    }
    
public function updateSession($id, $name, $duration, $price) {

    $sql = "UPDATE sessions
            SET name = ?, duration = ?, price = ?
            WHERE id = ?";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([
        $name,
        $duration,
        $price,
        $id
    ]);
}

public function getSessionById($id) {

    $sql = "SELECT * FROM sessions WHERE id = ?";

    $stmt = $this->connect->prepare($sql);

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


public function deleteSession($id) {

    $sql = "DELETE FROM sessions WHERE id = ?";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([$id]);
}
public function hasAppointments($id) {
    $sql = "SELECT COUNT(*) FROM appointments WHERE session_id = ?";
    $stmt = $this->connect->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetchColumn() > 0;
}
}
