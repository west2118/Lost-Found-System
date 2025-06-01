<link rel="stylesheet" href="../Styles/adminSidebar.css">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../View/login.php');
    exit();
}

require_once '../Model/user.php';
$user = new User();
$user_login = null;
if (isset($_SESSION['user_id'])) {
    $user_login = $user->getUserById($_SESSION['user_id']);
}

?>

<div class="sidebar">
    <div class="sidebar-header">
        <h3>Lost & Found Admin</h3>
        <p>Administrator Panel</p>
    </div>

    <div class="sidebar-menu">
        <div class="menu-category">Dashboard</div>
        <a href="../View/AdminDashboard.php" class="menu-item active">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>

        <div class="menu-category">Reports</div>
        <a href="../View/AdminLostReports.php" class="menu-item">
            <i class="fa fa-report"></i>
            <span>Lost Reports</span>
        </a>

        <div class="menu-category">Item Management</div>
        <div class="menu-item" id="item-toggle">
            <i class="fa fa-items"></i>
            <span>Lost Item Management</span>
        </div>
        <div class="submenu" id="item-submenu">
            <a href="../View/AdminAddItem.php" class="submenu-item">
                <i class="fa fa-add"></i>
                <span>Add Item</span>
            </a>
            <a href="../View/AdminListOfItems.php" class="submenu-item">
                <i class="fa fa-list"></i>
                <span>List of Items</span>
            </a>
        </div>

        <div class="menu-category">User Management</div>
        <div class="menu-item" id="item-toggle2">
            <i class="fa fa-items"></i>
            <span>User Management</span>
        </div>
        <div class="submenu" id="item-submenu2">
            <a href="../View/AdminAddUser.php" class="submenu-item">
                <i class="fa fa-add"></i>
                <span>Add User</span>
            </a>
            <a href="../View/AdminListOfUsers.php" class="submenu-item">
                <i class="fa fa-list"></i>
                <span>List of Users</span>
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="admin-info">
            <h3>Welcome,</h3>
            <span>Admin <?php echo $user_login['firstName'] ?></span>
        </div>
        <a href="../Controllers/logout.php" class="logout-btn">
            <span><i class="fa-solid fa-right-from-bracket"></i></span>
        </a>
    </div>
</div>

<script>
    // Toggle submenu visibility
    document.getElementById('item-toggle').addEventListener('click', function() {
        this.classList.toggle('rotate');
        document.getElementById('item-submenu').classList.toggle('show');
    });

    document.getElementById('item-toggle2').addEventListener('click', function() {
        this.classList.toggle('rotate');
        document.getElementById('item-submenu2').classList.toggle('show');
    });
</script>