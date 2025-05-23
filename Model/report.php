<?php
require_once("database.php");

class Report
{
    public $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllReports()
    {
        $sql = "SELECT * FROM tbl_reports";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getReportById($report_id)
    {
        $sql = "SELECT * FROM tbl_reports WHERE report_id = ?";
        $query = $this->conn->prepare($sql);
        $query->bind_param("i", $report_id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function addReport($itemName, $itemCategory, $description, $itemPhoto, $fullName, $email, $contactNo, $dateLost)
    {
        $status = "pending";
        $sql = "INSERT INTO tbl_reports SET itemName = ?, itemCategory = ?, description = ?, itemPhoto = ?, fullName = ?, email = ?, contactNo = ?, dateLost = ?, status = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("sssssssss", $itemName, $itemCategory, $description, $itemPhoto, $fullName, $email, $contactNo, $dateLost, $status);

        if ($result->execute()) {
            $lastId = $this->conn->insert_id;

            $year = date("Y");
            $ref_number = "LF-$year-$lastId";

            $updateSql = "UPDATE tbl_reports SET ref_number = ? WHERE report_id = ?";
            $updatedStmt = $this->conn->prepare($updateSql);
            $updatedStmt->bind_param("si", $ref_number, $lastId);
            $updatedStmt->execute();

            return $ref_number;
        }

        return false;
    }
    public function deleteReport($report_id)
    {
        $sql = "DELETE FROM tbl_reports WHERE report_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("i", $report_id);
        return $result->execute();
    }

    public function getMatchingItems($itemName, $description, $itemCategory)
    {
        $sql = "SELECT * FROM tbl_items 
        WHERE itemName LIKE ? 
          OR description LIKE ? 
          AND itemCategory LIKE ? 
          AND status = 'pending'";

        $itemName = "%$itemName%";
        $description = "%$description%";
        $itemCategory = "%$itemCategory%";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $itemName, $description, $itemCategory);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function confirmMatch($reportId, $itemId)
    {
        $itemSql = "UPDATE tbl_items SET matched_report_id = ?, status = 'verified' WHERE item_id = ?";
        $stmt1 = $this->conn->prepare($itemSql);
        $stmt1->bind_param("ii", $reportId, $itemId);
        $stmt1->execute();

        $reportSql = "UPDATE tbl_reports SET matched_item_id = ?, status = 'verified' WHERE report_id = ?";
        $stmt2 = $this->conn->prepare($reportSql);
        $stmt2->bind_param("ii", $itemId, $reportId);
        $stmt2->execute();

        return $stmt1->affected_rows > 0 && $stmt2->affected_rows > 0;
    }

    public function noMatchFound($reportId)
    {
        $sql = "UPDATE tbl_reports SET status = 'no match' WHERE report_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $reportId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function markAsReturned($reportId, $itemId)
    {
        $itemSql = "UPDATE tbl_items SET status = 'returned' WHERE item_id = ?";
        $stmt1 = $this->conn->prepare($itemSql);
        $stmt1->bind_param("i", $itemId);
        $stmt1->execute();

        $reportSql = "UPDATE tbl_reports SET status = 'returned' WHERE report_id = ?";
        $stmt2 = $this->conn->prepare($reportSql);
        $stmt2->bind_param("i", $reportId);
        $stmt2->execute();

        return $stmt1->affected_rows > 0 && $stmt2->affected_rows > 0;
    }
}
