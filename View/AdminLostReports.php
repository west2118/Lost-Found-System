<?php
include "../Model/report.php";
$report = new Report();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include "../Includes/href.php" ?>
    <link rel="stylesheet" href="../Styles/adminLostReports.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">

        <div class="reports-table-container">
            <div class="custom-card">
                <div class="custom-card-header">
                    <h4>📋 List of Reports</h4>
                    <div class="search-filter">
                        <select class="filter-select">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Verified</option>
                            <option>No Match</option>
                            <option>Returned</option>
                        </select>
                    </div>
                </div>
                <div class="custom-card-body">
                    <div class="custom-table-responsive">
                        <table class="custom-table" id="myTable">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Date Lost</th>
                                    <th>Matched ID Item</th>
                                    <th>Status</th>
                                    <th>Reported By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $reports = $report->getAllReports();

                                if (empty($reports)) {
                                    echo '<tr><td colspan="9" style="text-align:center; padding: 20px;">No reports found.</td></tr>';
                                } else {
                                    foreach ($reports as $row) {
                                ?>
                                        <tr>
                                            <td><?php echo $row["ref_number"]; ?></td>
                                            <td><?php echo $row["itemName"]; ?></td>
                                            <td><?php echo $row['itemCategory']; ?></td>
                                            <td>
                                                <?php
                                                $desc = $row["description"];
                                                echo strlen($desc) > 60 ? substr($desc, 0, 60) . "..." : $desc;
                                                ?>
                                            </td>
                                            <td><?php echo date('M d, Y', strtotime($row['dateLost'])); ?></td>
                                            <td>
                                                <?php
                                                if ($row['status'] === "pending") {
                                                    echo 'Pending';
                                                } else if ($row['status'] === "no match") {
                                                    echo "None";
                                                } else if ($row['status'] === "verified" || $row['status'] === "returned") {
                                                    echo "Item-ID-" . $row['matched_item_id'];
                                                }
                                                ?>
                                            </td>
                                            <td class="status" data-status="<?php echo strtolower($row['status']); ?>">
                                                <?php echo $row['status']; ?>
                                            </td>
                                            <td class="reportedBy"><?php echo $row['email']; ?></td>
                                            <td style="display: flex; gap: 8px; align-items: center;">
                                                <button class="btn-delete" data-id="<?php echo $row['report_id']; ?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <?php
                                                if ($row['status'] === "pending") {
                                                    echo '
                                                <form method="POST" action="../Controllers/action_report.php" style="margin: 0;">
                                                    <input type="hidden" name="report_id" value="' . $row['report_id'] . '">
                                                    <button type="submit" class="btn-match" name="find_match">Find Match</button>
                                                </form>';
                                                } else if ($row['status'] === "verified") {
                                                    echo '
                                                <form method="POST" action="../Controllers/action_report.php" style="margin: 0;">
                                                    <input type="hidden" name="report_id" value="' . $row['report_id'] . '">
                                                    <input type="hidden" name="item_id" value="' . $row['matched_item_id'] . '">
                                                    <button type="submit" class="btn-match" name="mark_returned">Mark As Returned</button>
                                                </form>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tr id="noDataRow" style="display: none;">
                                <td colspan="9" style="text-align: center; padding: 20px; color: #888;">No reports found for the selected status.</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $deleteAction = '../Controllers/action_report.php';
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

            // 🔍 Filtering logic
            document.querySelector('.filter-select').addEventListener('change', function() {
                const selectedStatus = this.value.toLowerCase();
                const rows = document.querySelectorAll('#myTable tbody tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    // Skip the "no data" row
                    if (row.id === 'noDataRow') return;

                    const status = row.querySelector('.status')?.dataset.status;

                    if (selectedStatus === 'all status' || selectedStatus === status) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show or hide the no data row
                const noDataRow = document.getElementById('noDataRow');
                if (visibleCount === 0) {
                    noDataRow.style.display = '';
                } else {
                    noDataRow.style.display = 'none';
                }
            });
        </script>
</body>

</html>