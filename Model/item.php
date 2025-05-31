<?php
require_once 'database.php';

class Item
{
    public $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAllItems()
    {
        $sql = "SELECT * FROM tbl_items";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllItemsPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_items LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getItemCount()
    {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM tbl_items");
        return $result->fetch_assoc()['count'];
    }

    public function getItemById($item_id)
    {
        $sql = "SELECT * FROM tbl_items WHERE item_id = ?";
        $query = $this->conn->prepare($sql);
        $query->bind_param("i", $item_id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function addItem($itemName, $itemCategory, $dateFound, $location, $itemImage, $description, $reporterName, $reporterContact, $reporterEmail)
    {
        $status = "pending";
        $sql = "INSERT INTO tbl_items SET itemName = ?,	itemCategory = ?, dateFound = ?, location = ?,  itemImage = ?,	description = ?, reporterName = ?, reporterContact = ?, reporterEmail = ?, status = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("ssssssssss", $itemName, $itemCategory, $dateFound, $location, $itemImage, $description, $reporterName, $reporterContact, $reporterEmail, $status);
        return $result->execute();
    }

    public function editItem($item_id, $itemName, $itemCategory, $dateFound, $location, $itemImage, $description, $reporterName, $reporterContact, $reporterEmail)
    {
        $sql = "UPDATE tbl_items SET itemName = ?,	itemCategory = ?, dateFound = ?, location = ?,  itemImage = ?, description = ?, reporterName = ?, reporterContact = ?, reporterEmail = ? WHERE item_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("sssssssssi", $itemName, $itemCategory, $dateFound, $location, $itemImage, $description, $reporterName, $reporterContact, $reporterEmail, $item_id);
        return $result->execute();
    }

    public function deleteItem($item_id)
    {
        $sql = "DELETE FROM tbl_items WHERE item_id = ?";
        $result = $this->conn->prepare($sql);
        $result->bind_param("i", $item_id);
        return $result->execute();
    }

    public function markAsDonated($itemId)
    {
        $itemSql = "UPDATE tbl_items SET status = 'donated' WHERE item_id = ?";
        $stmt1 = $this->conn->prepare($itemSql);
        $stmt1->bind_param("i", $itemId);
        $stmt1->execute();

        return $stmt1->affected_rows > 0;
    }

    public function countItems()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_items";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function countReturnedItems()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_items WHERE status = 'returned'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
}
