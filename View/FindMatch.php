<?php

session_start();
require_once "../Model/report.php";

$reportLost = $_SESSION['reportLost'] ?? null;
$matches = $_SESSION['matches'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Matching Found Items</title>
    <link rel="stylesheet" href="../Styles/findMatch.css">
</head>

<body>

    <h1>Find Match Result</h1>

    <!-- Lost Report Section -->
    <div class="section report-card">
        <div class="report-title">Reported Lost Item: <?php echo $reportLost['itemName'] ?></div>
        <p><strong>Report ID:</strong> <?php echo $reportLost['report_id'] ?></p>
        <p><strong>Category:</strong> <?php echo $reportLost['itemCategory'] ?></p>
        <p><strong>Description:</strong> <?php echo $reportLost['description'] ?></p>
        <p><strong>Date Lost:</strong> <?php echo $reportLost['dateLost'] ?></p>
        <p><strong>Status:</strong> <?php echo $reportLost['status'] ?></p>
        <p><strong>Reported By:</strong> <?php echo $reportLost['email'] ?></p>
    </div>


    <h2>Matching Found Items</h2>

    <div class="section match-results">

        <!-- Matching item 1 -->
        <?php
        foreach ($matches as $item) { ?>
            <div class="item-card">
                <img src=<?php echo $item['itemImage'] ?> alt="Found Item" class="item-image">
                <div class="item-details">
                    <div class="item-header">Found Item #1: <?php echo $item['itemName'] ?></div>
                    <p><strong>Category:</strong> <?php echo $item['itemCategory'] ?></p>
                    <p><strong>Date Found:</strong> <?php echo $item['dateFound'] ?></p>
                    <p><strong>Location:</strong> <?php echo $item['location'] ?></p>
                    <p><strong>Description:</strong> <?php echo $item['description'] ?></p>
                </div>
                <div>
                    <button class="btn-confirm"
                        data-report-id="<?php echo $reportLost['report_id'] ?>"
                        data-full-name="<?php echo $reportLost['fullName'] ?>"
                        data-ref-number="<?php echo $reportLost['ref_number'] ?>"
                        data-item-id="<?php echo $item['item_id'] ?>"
                        data-email="<?php echo $reportLost['email'] ?>">Match</button>
                </div>
            </div>
        <?php } ?>

        <div class="item-card no-match-card">
            <div>
                <h3 class="no-match-title">No Match Found</h3>
                <p class="no-match-text">We couldn't find any matching items for this report right now.</p>
                <p class="no-match-text">Click below to notify the reporter or follow up with updated details.</p>
                <button
                    class="no-match-btn open-no-match-modal"
                    data-report-id="<?php echo $reportLost['report_id'] ?>"
                    data-full-name="<?php echo $reportLost['fullName'] ?>"
                    data-email="<?php echo $reportLost['email'] ?>">
                    Notify User
                </button>
            </div>
        </div>
    </div>

    <a href="AdminLostReports.php" class="btn-back">← Back to Reports</a>

    <?php
    include '../Includes/EmailUserModal.php';
    ?>

    <script>
        // Handle Match buttons
        document.querySelectorAll('.btn-confirm').forEach(btn => {
            btn.addEventListener('click', () => {
                const reportId = btn.getAttribute('data-report-id');
                const fullName = btn.getAttribute('data-full-name');
                const itemId = btn.getAttribute('data-item-id');
                const refNum = btn.getAttribute('data-ref-number');
                const email = btn.getAttribute('data-email');

                document.getElementById('modalReportId').value = reportId;
                document.getElementById('modalItemId').value = itemId;
                document.getElementById('modalRefNum').value = refNum;
                document.getElementById('modalEmail').value = email;
                document.getElementById('modalFullname').value = fullName;

                document.getElementById('displayRefNum').textContent = refNum;

                document.getElementById('overlay').classList.add('show');
                document.getElementById('email_user_modal').classList.add('show');
            });
        });

        // Handle No Match buttons
        document.querySelectorAll('.no-match-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const reportId = btn.getAttribute('data-report-id');
                const fullName = btn.getAttribute('data-full-name');
                const email = btn.getAttribute('data-email');

                document.getElementById('modalReportId').value = reportId;
                document.getElementById('modalItemId').value = ''; // no item id in this case
                document.getElementById('modalRefNum').value = ''; // no ref number here
                document.getElementById('modalEmail').value = email;
                document.getElementById('modalFullname').value = fullName;

                document.getElementById('displayRefNum').textContent = '(No Reference Number)';

                document.getElementById('overlay').classList.add('show');
                document.getElementById('email_user_modal').classList.add('show');
            });
        });

        // Cancel buttons hide modal
        document.querySelectorAll('.cancelBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('overlay').classList.remove('show');
                document.getElementById('email_user_modal').classList.remove('show');
            });
        });
    </script>


</body>

</html>