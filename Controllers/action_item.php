<?php
include "../Model/item.php";
$item = new Item();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['add'])) {
        $itemName = $_POST['itemName'];
        $itemCategory = $_POST['itemCategory'];
        $dateFound = $_POST['dateFound'];
        $location = $_POST['location'];
        $itemImage = $_POST['itemImage'];
        $description = $_POST['description'];
        $reporterName = $_POST['reporterName'];
        $reporterContact = $_POST['reporterContact'];
        $reporterEmail = $_POST['reporterEmail'];

        $result_add = $item->addItem($itemName, $itemCategory, $dateFound, $location, $itemImage, $description, $reporterName, $reporterContact, $reporterEmail);

        if ($result_add) {
            header("Location: ../View/AdminListOfItems.php");
            exit();
        }
    } else if (isset($_POST['edit'])) {
        $itemName = $_POST['itemName'];
        $itemCategory = $_POST['itemCategory'];
        $dateFound = $_POST['dateFound'];
        $location = $_POST['location'];
        $itemImage = $_POST['itemImage'];
        $description = $_POST['description'];
        $reporterName = $_POST['reporterName'];
        $reporterContact = $_POST['reporterContact'];
        $reporterEmail = $_POST['reporterEmail'];
        $item_id = $_POST['item_id'];

        $result_add = $item->editItem($item_id, $itemName, $itemCategory, $dateFound, $location, $itemImage, $description, $reporterName, $reporterContact, $reporterEmail);

        if ($result_add) {
            header("Location: ../View/AdminListOfItems.php");
            exit();
        }
    } else if (isset($_POST['btn-donate'])) {
        $item_id = $_POST['item_id'];

        $result = $item->markAsDonated($item_id);

        if ($result) {
            header("Location: ../View/AdminListOfItems.php");
            exit();
        }
    } else if (isset($_POST['confirm_delete'])) {
        $delete_id = $_POST['delete_id'];

        $result = $item->deleteItem($delete_id);

        if ($result) {
            header("Location: ../View/AdminListOfItems.php");
            exit();
        }
    }
}
