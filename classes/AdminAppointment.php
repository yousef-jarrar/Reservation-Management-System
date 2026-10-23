<?php

require_once __DIR__ . "/Database.php";

class AdminAppointment extends Database {

    public function getAllAppointments() {

        $sql = "SELECT
                    appointments.id,
                    patients.name AS patient_name,
                    physiotherapists.name AS physiotherapist_name,
                    sessions.name AS session_name,
                    availability.available_date,
                    availability.available_time,
                    appointments.status

                FROM appointments

                JOIN users AS patients
                    ON appointments.patient_id = patients.id

                JOIN availability
                    ON appointments.availability_id = availability.id

                JOIN users AS physiotherapists
                    ON availability.physiotherapist_id = physiotherapists.id

                JOIN sessions
                    ON appointments.session_id = sessions.id

                ORDER BY availability.available_date DESC";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}