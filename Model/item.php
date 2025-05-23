<?php
include("database.php");

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
}
