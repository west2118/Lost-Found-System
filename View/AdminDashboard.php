<?php

include "../Model/report.php";
include "../Model/item.php";

$report = new Report();
$item = new Item();

$totalReports = $report->countAllReports();

$totalFoundItems = $item->countItems();

$totalPendingReports = $report->countPendingReports();

$totalReturnedItems = $item->countReturnedItems();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lost and Found System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../Styles/adminDashboard.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Dashboard Overview</h2>

        <div class="dashboard-cards">
            <div class="card lost">
                <div class="card-header">
                    <div>
                        <div class="card-title">Total Lost Reports</div>
                        <div class="card-value"><?php echo $totalReports; ?></div>
                    </div>
                    <div class="card-icon lost">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>

            <div class="card found">
                <div class="card-header">
                    <div>
                        <div class="card-title">Total Found Items</div>
                        <div class="card-value"><?php echo $totalFoundItems; ?></div>
                    </div>
                    <div class="card-icon found">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="card pending">
                <div class="card-header">
                    <div>
                        <div class="card-title">Pending Verification</div>
                        <div class="card-value"><?php echo $totalPendingReports; ?></div>
                    </div>
                    <div class="card-icon pending">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>

            <div class="card returned">
                <div class="card-header">
                    <div>
                        <div class="card-title">Total Returned Items</div>
                        <div class="card-value"><?php echo $totalReturnedItems; ?></div>
                    </div>
                    <div class="card-icon returned">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports Table -->
        <div class="recent-reports">
            <h3 class="title-table"><i class="fas fa-history"></i> Recent Reports</h3>
            <table>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Category</th>
                        <th>Item Name</th>
                        <th>Date Reported</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $reports = $report->getLast10Reports();
                    foreach ($reports as $row) { ?>
                        <tr>
                            <td><?php echo $row['ref_number']; ?></td>
                            <td><?php echo $row['itemCategory']; ?></td>
                            <td><?php echo $row['itemName']; ?></td>
                            <td><?php echo $row['dateLost']; ?></td>
                            <td>
                                <?php
                                $status = $row['status'];
                                $badgeClass = '';

                                switch ($status) {
                                    case 'pending':
                                        $badgeClass = 'pending-badge';
                                        break;
                                    case 'matched':
                                        $badgeClass = 'match-badge';
                                        break;
                                    case 'returned':
                                        $badgeClass = 'returned-badge';
                                        break;
                                    case 'no matched':
                                        $badgeClass = 'no-match-badge';
                                        break;
                                    default:
                                        $badgeClass = 'default-badge';
                                        break;
                                }
                                ?>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $status; ?></span>
                            </td>
                            <td>
                                <form action="../Controllers/action_report.php" method="POST">
                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row['report_id']); ?>">
                                    <button name="confirm_delete" type="submit" class="action-btn view-btn">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>