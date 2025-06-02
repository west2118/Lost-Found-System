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
    <?php include "../Includes/href.php" ?>
    <link rel="stylesheet" href="../Styles/adminListOfUsers.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">

        <div class="reports-table-container">
            <div class="custom-card">
                <div class="custom-card-header">
                    <h4>📋 List of Admin</h4>
                    <div>
                        <button onclick="window.location.href='AdminAddUser.php'">Add New Admin</button>
                    </div>
                </div>
                <div class="custom-card-body">
                    <div class="custom-table-responsive">
                        <table class="custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>
                                        <i class="fa fa-user" aria-hidden="true"></i> User
                                    </th>
                                    <th>
                                        <i class="fa fa-envelope" aria-hidden="true"></i> Email
                                    </th>
                                    <th>
                                        <i class="fa fa-user-tag" aria-hidden="true"></i> Role
                                    </th>
                                    <th>
                                        <i class="fa fa-calendar-alt" aria-hidden="true"></i> Registered
                                    </th>
                                    <th>
                                        <i class="fa fa-cogs" aria-hidden="true"></i> Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $users = $user->getAllUsers();
                                foreach ($users as $row) { ?>
                                    <tr>
                                        <td class="user-avatar">
                                            <div class="user-info">
                                                <span class="user-name"><?php echo $row["firstName"] ?> <?php echo $row["lastName"] ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo $row["email"] ?></td>
                                        <td><span class="role-badge admin">Admin</span></td>
                                        <td><?php $date = new DateTime($row["dateCreated"]);
                                            echo $date->format("F j, Y") ?></td>
                                        <td class="actions">
                                            <a href="AdminAddUser.php?edit=<?php echo $row['user_id'] ?>" class="btn-edit"><i class="fa fa-edit"></i></a>
                                            <button class="btn-delete" data-id="<?php echo $row['user_id']; ?>"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $deleteAction = '../Controllers/action_user.php';
        include '../Includes/RemoveItemModal.php';
        ?>

        <script>
            let table = new DataTable('#myTable');

            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', () => {
                    const itemId = btn.getAttribute('data-id');
                    document.getElementById('deleteItemId').value = itemId;
                    document.getElementById('overlay').style.display = 'block';
                    document.getElementById('deleteModal').style.display = 'block';
                });
            });

            document.querySelectorAll('.cancelBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.getElementById('overlay').style.display = 'none';
                    document.getElementById('deleteModal').style.display = 'none';
                });
            });
        </script>
</body>

</html>