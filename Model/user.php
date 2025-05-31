<?php
require_once 'database.php';

class User
{
    public $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM tbl_users";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($user_id)
    {
        $sql = "SELECT * FROM tbl_users WHERE user_id = ?";
        $query = $this->conn->prepare($sql);
        $query->bind_param("i", $user_id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function addUser($firstName, $lastName, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tbl_users SET firstName = ?, lastName = ?, email = ?, password = ?, dateCreated = NOW()";
        $result = $this->conn->prepare($sql);
        $result->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
        return $result->execute();
    }

    public function editUser($user_id, $firstName, $lastName, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE tbl_users SET firstName = ?, lastName = ?, email = ?, password = ? WHERE user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("ssssi", $firstName, $lastName, $email, $hashedPassword, $user_id);
        return $result->execute();
    }

    public function deleteUser($user_id)
    {
        $sql = "DELETE FROM tbl_users WHERE user_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("i", $user_id);
        return $result->execute();
    }

    public function isEmailTaken($email)
    {
        $sql = "SELECT user_id FROM tbl_users WHERE email = ? LIMIT 1";
        $result = $this->conn->prepare($sql);
        $result->bind_param("s", $email);
        $result->execute();
        $result->store_result();
        return $result->num_rows > 0;
    }

    public function login($email, $password)
    {
        $sql = "SELECT * FROM tbl_users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function getUserId($email)
    {
        $sql = "SELECT user_id FROM tbl_users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['user_id'];
    }
}
