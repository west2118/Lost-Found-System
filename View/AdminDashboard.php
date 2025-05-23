<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lost and Found System</title>
    <link rel="stylesheet" href="../Styles/adminDashboard.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Dashboard Overview</h2>

        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Total Lost Reports</div>
                        <div class="card-value">1,248</div>
                        <div class="card-change">+12% from last month</div>
                    </div>
                    <div class="card-icon lost">
                        <i class="fa">🛄</i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Total Found Items</div>
                        <div class="card-value">876</div>
                        <div class="card-change">+8% from last month</div>
                    </div>
                    <div class="card-icon found">
                        <i class="fa">✅</i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Pending Verification</div>
                        <div class="card-value">54</div>
                        <div class="card-change negative">-5% from last month</div>
                    </div>
                    <div class="card-icon pending">
                        <i class="fa">⏳</i>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Total Returned Items</div>
                        <div class="card-value">732</div>
                        <div class="card-change">+15% from last month</div>
                    </div>
                    <div class="card-icon returned">
                        <i class="fa">🏠</i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional dashboard content would go here -->
    </div>


</body>

</html>