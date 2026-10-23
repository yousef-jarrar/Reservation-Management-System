<?php

require_once "Database.php";

class User extends Database {

    public function register($name, $email, $password) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $name,
            $email,
            $hashedPassword
        ]);
    }

    public function login($email, $password) {
    
        $sql = "SELECT * FROM users WHERE email = ?";
    
        $stmt = $this->connect->prepare($sql);
        $stmt->execute([$email]);
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user["password"])) {
            return $user;
        }
    
        return false;
    }


    public function getPhysiotherapists() {
    
        $sql = "SELECT id, name, email FROM users WHERE role = ?";
    
        $stmt = $this->connect->prepare($sql);
    
        $stmt->execute(["physiotherapist"]);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
public function addPhysiotherapist($name, $email, $password) {

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, role)
            VALUES (?, ?, ?, 'physiotherapist')";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([
        $name,
        $email,
        $hashedPassword
    ]);
}

public function getPhysiotherapistById($id) {

    $sql = "SELECT id, name, email
            FROM users
            WHERE id = ? AND role = 'physiotherapist'";

    $stmt = $this->connect->prepare($sql);

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

 
public function updatePhysiotherapist($id, $name, $email, $password) {

    if ($password != "") {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users
                SET name = ?, email = ?, password = ?
                WHERE id = ? AND role = 'physiotherapist'";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $name,
            $email,
            $hashedPassword,
            $id
        ]);

    } else {

        $sql = "UPDATE users
                SET name = ?, email = ?
                WHERE id = ? AND role = 'physiotherapist'";

        $stmt = $this->connect->prepare($sql);

        return $stmt->execute([
            $name,
            $email,
            $id
        ]);
    }
}

public function deletePhysiotherapist($id) {

    $sql = "DELETE FROM users
            WHERE id = ? AND role = 'physiotherapist'";

    $stmt = $this->connect->prepare($sql);

    return $stmt->execute([$id]);
}
public function hasPhysiotherapistAppointments($id) {
    $sql = "SELECT COUNT(*)
            FROM appointments
            JOIN availability
            ON appointments.availability_id = availability.id
            WHERE availability.physiotherapist_id = ?";

    $stmt = $this->connect->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetchColumn() > 0;
}
}