<?php
session_start();
include "../Model/report.php";
$report = new Report();

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["submit"])) {
        $itemName = $_POST["itemName"];
        $itemCategory = $_POST["itemCategory"];
        $description = $_POST["description"];
        $dateLost = $_POST["dateLost"];
        $itemPhoto = $_POST["itemPhoto"];
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $contactNo = $_POST["contactNo"];

        $result_add = $report->addReport($itemName, $itemCategory, $description, $itemPhoto, $fullName, $email, $contactNo, $dateLost);

        if ($result_add) {
            session_start();
            $_SESSION['ref_number'] = $result_add;
            header("Location: ../View/ReportLostItem.php?submitted=1&step=3");
            exit();
        }
    } else if (isset($_POST['confirm_delete'])) {
        $delete_id = $_POST['delete_id'];

        $result = $report->deleteReport($delete_id);

        if ($result) {
            header("Location: ../View/AdminLostReports.php");
        }
    } else if (isset($_POST['find_match'])) {
        $report_id = $_POST['report_id'];

        $reportLost = $report->getReportById($report_id);

        if ($reportLost) {
            $itemName = $reportLost['itemName'];
            $description = $reportLost['description'];
            $itemCategory = $reportLost['itemCategory'];

            $matches = $report->getMatchingItems($itemName, $description, $itemCategory);

            // Save full reportLost in session
            $_SESSION['reportLost'] = $reportLost;
            $_SESSION['matches'] = $matches;

            header("Location: ../View/FindMatch.php");
            exit();
        } else {
            echo "Report not found.";
        }
    } else if (isset($_POST["confirm_match"])) {
        $report_id = $_POST['report_id'];
        $item_id = $_POST['item_id'];
        $ref_number = $_POST['ref_number'];
        $email = $_POST['email'];
        $fullName = $_POST['fullName'];

        if ($item_id !== "") {
            $confirmMatch = $report->confirmMatch($report_id, $item_id);

            if ($confirmMatch) {
                $subject = "Lost and Found: Matched Item Notification";
                $message = "Dear $fullName,\n\nWe are pleased to inform you that your lost item has been successfully matched.\n\nPlease proceed to the OSA Office to claim your item.\nReference Number: $ref_number\n\nKindly bring a valid ID for verification.\n\nThank you,\nLost and Found Team";

                // Send email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'amandasmurf21@gmail.com';
                    $mail->Password = 'jfthhpjbzplxpbxh'; // Your app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('amandasmurf21@gmail.com', 'Lost and Found Team');
                    $mail->addAddress($email, $fullName);
                    $mail->isHTML(false);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    $mail->send();

                    header("Location: ../View/AdminLostReports.php");
                    exit();
                } catch (Exception $e) {
                    echo "❌ Email failed. Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Failed to confirm match. Please try again.";
            }
        } else {
            $noMatch = $report->noMatchFound($report_id);

            if ($noMatch) {
                $subject = "Lost and Found Report: No Match Found";
                $message = "Dear $fullName,\n\nWe regret to inform you that your report did not match any of the items currently in our Lost and Found database.\n\nPlease review your report details and try submitting it again. Make sure all the information is accurate and complete.\n\nThank you for your understanding.\n\nSincerely,\nLost and Found Team";

                // Send email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'amandasmurf21@gmail.com';
                    $mail->Password = 'jfthhpjbzplxpbxh'; // Your app password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('amandasmurf21@gmail.com', 'Lost and Found Team');
                    $mail->addAddress($email, $fullName);
                    $mail->isHTML(false);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    $mail->send();

                    header("Location: ../View/AdminLostReports.php");
                    exit();
                } catch (Exception $e) {
                    echo "❌ Email failed. Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Failed to confirm no match. Please try again.";
            }
        }
    } else if (isset($_POST['mark_returned'])) {
        $report_id = $_POST['report_id'];
        $item_id = $_POST['item_id'];

        $result = $report->markAsReturned($report_id, $item_id);

        if ($result) {
            header("Location: ../View/AdminLostReports.php");
        }
    }
}
