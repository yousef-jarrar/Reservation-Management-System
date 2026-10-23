
<?php

require_once __DIR__ . "/Database.php";

class Appointment extends Database {

    public function getAvailableTimes($physiotherapistId) {

        $sql = "SELECT id, available_date, available_time
                FROM availability
                WHERE physiotherapist_id = ?
                AND available_date >= CURDATE()
                AND id NOT IN (
                    SELECT availability_id FROM appointments
                )
                ORDER BY available_date, available_time";

        $stmt = $this->connect->prepare($sql);

        $stmt->execute([$physiotherapistId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bookAppointment($patientId, $sessionId, $availabilityId, $physiotherapistId) {

    $sql = "INSERT INTO appointments
            (patient_id, session_id, availability_id)
            SELECT ?, ?, id
            FROM availability
            WHERE id = ?
            AND physiotherapist_id = ?
            AND available_date >= CURDATE()
            AND NOT EXISTS (
                SELECT 1 FROM appointments
                WHERE availability_id = ?
            )";

    $stmt = $this->connect->prepare($sql);

    $stmt->execute([
        $patientId,
        $sessionId,
        $availabilityId,
        $physiotherapistId,
        $availabilityId
    ]);

    return $stmt->rowCount() > 0;
}

public function getPatientAppointments($patientId) {

    $sql = "SELECT
                appointments.id,
                users.name AS physiotherapist_name,
                sessions.name AS session_name,
                availability.available_date,
                availability.available_time,
                appointments.status
            FROM appointments
            JOIN availability
                ON appointments.availability_id = availability.id
            JOIN users
                ON availability.physiotherapist_id = users.id
            JOIN sessions
                ON appointments.session_id = sessions.id
            WHERE appointments.patient_id = ?
            ORDER BY availability.available_date DESC,
                     availability.available_time DESC";

    $stmt = $this->connect->prepare($sql);

    $stmt->execute([$patientId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getPhysiotherapistAppointments($physiotherapistId) {

    $sql = "SELECT
                appointments.id,
                users.name AS patient_name,
                sessions.name AS session_name,
                availability.available_date,
                availability.available_time,
                appointments.status
            FROM appointments
            JOIN users
                ON appointments.patient_id = users.id
            JOIN sessions
                ON appointments.session_id = sessions.id
            JOIN availability
                ON appointments.availability_id = availability.id
            WHERE availability.physiotherapist_id = ?
            ORDER BY availability.available_date,
                     availability.available_time";

    $stmt = $this->connect->prepare($sql);

    $stmt->execute([$physiotherapistId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateAppointmentStatus($appointmentId, $physiotherapistId, $status) {

    if (!in_array($status, ["Accepted", "Rejected"], true)) {
        return false;
    }

    $sql = "UPDATE appointments
            JOIN availability
                ON appointments.availability_id = availability.id
            SET appointments.status = ?
            WHERE appointments.id = ?
            AND availability.physiotherapist_id = ?
            AND appointments.status = 'Pending'";

    $stmt = $this->connect->prepare($sql);

    $stmt->execute([
        $status,
        $appointmentId,
        $physiotherapistId
    ]);

    return $stmt->rowCount() > 0;
}
}
