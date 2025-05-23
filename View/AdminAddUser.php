<?php

include "../Model/user.php";
$user = new User();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/adminAddUser.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">

        <div class="form-container">
            <?php
            if (isset($_GET['edit'])) {
                $get_id_edit = $_GET['edit'];
                $row = $user->getUserById($get_id_edit);
                if ($row) { ?>
                    <form id="addUserForm" action="../Controllers/action_user.php" method="POST">
                        <div class="form-section">
                            <h3><i class="fa fa-lock" style="margin-right: 10px"></i> Add Admin</h3>

                            <input type="text" class="form-control" name="user_id" value="<?php echo $row['user_id']; ?>" required style="display: none;">

                            <div class="form-group">
                                <label for="firstName">First Name*</label>
                                <input type="text" id="firstName" name="firstName" value="<?php echo $row['firstName'] ?>" required placeholder="Enter first name">
                            </div>

                            <div class="form-group">
                                <label for="lastName">Last Name*</label>
                                <input type="text" id="lastName" name="lastName" value="<?php echo $row['lastName'] ?>" required placeholder="Enter last name">
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address*</label>
                                <input type="email" id="email" name="email" value="<?php echo $row['email'] ?>" required placeholder="Enter email address">
                            </div>

                            <div class="form-group">
                                <label for="password">Old Password*</label>
                                <div class="password-input">
                                    <input type="password" id="oldPassword" name="oldPassword" required placeholder="Enter old password">
                                    <button type="button" class="btn-toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="password-group">
                                <div class="form-group">
                                    <label for="password">New Password*</label>
                                    <div class="password-input">
                                        <input type="password" id="password" name="password" required placeholder="Create password">
                                        <button type="button" class="btn-toggle-password">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password">New Confirm Password*</label>
                                    <div class="password-input">
                                        <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm password">
                                        <button type="button" class="btn-toggle-password">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="button" class="btn-cancel" onclick="window.location.href='AdminListOfUsers.php'">Cancel</button>
                            <button type="submit" name="edit" class="btn-submit">
                                Update User
                            </button>
                        </div>
                    </form>
                <?php }
            } else {
                ?>
                <form action="../Controllers/action_user.php" method="POST" id="addUserForm">
                    <div class="form-section">
                        <h3><i class="fa fa-lock" style="margin-right: 10px"></i> Add Admin</h3>

                        <div class="form-group">
                            <label for="firstName">First Name*</label>
                            <input type="text" id="firstName" name="firstName" required placeholder="Enter first name">
                        </div>

                        <div class="form-group">
                            <label for="lastName">Last Name*</label>
                            <input type="text" id="lastName" name="lastName" required placeholder="Enter last name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address*</label>
                            <input type="email" id="email" name="email" required placeholder="Enter email address">
                        </div>

                        <div class="password-group">
                            <div class="form-group">
                                <label for="password">Password*</label>
                                <div class="password-input">
                                    <input type="password" id="password" name="password" required placeholder="Create password">
                                    <button type="button" class="btn-toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password*</label>
                                <div class="password-input">
                                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm password">
                                    <button type="button" class="btn-toggle-password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="window.location.href='AdminListOfUsers.php'">Cancel</button>
                        <button type="submit" name="add" class="btn-submit">
                            <i class="fa fa-user-plus"></i> Create User
                        </button>
                    </div>
                </form>
            <?php }
            ?>
        </div>
    </div>
</body>

</html>