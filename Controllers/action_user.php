<?php
include "../Model/user.php";
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['add'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($user->isEmailTaken($email)) {
            header("Location: ../View/AdminAddUser.php?error=emailUsed");
            exit();
        }

        if ($password !== $confirmPassword) {
            header("Location: ../View/AdminAddUser.php?error=passwordMismatch");
            exit();
        }


        $result_add = $user->addUser($firstName, $lastName, $email, $password);
        if ($result_add) {
            header("location: ../View/AdminListOfUsers.php");
            exit();
        } else {
            echo "<script>alert('Failed to add user');</script>";
        }
    } else if (isset($_POST['edit'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $oldPassword = $_POST['oldPassword'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $user_id = $_POST['user_id'];

        $existingUser = $user->getUserById($user_id);

        if (!$existingUser) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=userNotFound");
            exit();
        }

        $storedHashedPassword = $existingUser['password'];

        if (!password_verify($oldPassword, $storedHashedPassword)) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=invalidOldPassword");
            exit();
        }

        if ($user->isEmailTaken($email) && $email !== $existingUser['email']) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=emailUsed");
            exit();
        }

        if ($password !== $confirmPassword) {
            header("Location: ../View/AdminAddUser.php?edit=$user_id&error=passwordMismatch");
            exit();
        }


        $result_add = $user->editUser($user_id, $firstName, $lastName, $email, $password);

        if ($result_add) {
            header("location: ../View/AdminListOfUsers.php");
            exit();
        } else {
            echo "<script>alert('Failed to edit user');</script>";
        }
    } else if (isset($_POST['confirm_delete'])) {
        $delete_id = $_POST['delete_id'];

        $result = $user->deleteUser($delete_id);

        if ($result) {
            header("Location: ../View/AdminListOfUsers.php");
        }
    }
}
