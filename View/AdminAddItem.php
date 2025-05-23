<?php

include "../Model/item.php";
$item = new Item();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Styles/adminAddItem.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <?php
            if (isset($_GET['edit'])) {
                $get_id_edit = $_GET['edit'];
                $row = $item->getItemById($get_id_edit);
                if ($row) { ?>
                    <form id="addItemForm" action="../Controllers/action_item.php" method="POST">
                        <div class="form-section">
                            <h3><i class="fa fa-info-circle"></i> Basic Information</h3>
                            <div class="form-grid">
                                <input type="text" class="form-control" name="item_id" value="<?php echo $row['item_id']; ?>" required style="display: none;">
                                <div class="form-group">
                                    <label for="itemName">Item Name*</label>
                                    <input type="text" id="itemName" name="itemName" required value="<?php echo $row['itemName'] ?>" placeholder="e.g. Black Wallet, iPhone 12">
                                </div>

                                <div class="form-group">
                                    <label for="itemCategory">Category*</label>
                                    <select id="itemCategory" name="itemCategory" required>
                                        <option value="">Select Category</option>
                                        <option value="electronics" <?php if ($row['itemCategory'] == 'electronics') echo 'selected'; ?>>Electronics</option>
                                        <option value="documents" <?php if ($row['itemCategory'] == 'documents') echo 'selected'; ?>>Documents</option>
                                        <option value="personal" <?php if ($row['itemCategory'] == 'personal') echo 'selected'; ?>>Personal Items</option>
                                        <option value="clothing" <?php if ($row['itemCategory'] == 'clothing') echo 'selected'; ?>>Clothing</option>
                                        <option value="accessories" <?php if ($row['itemCategory'] == 'accessories') echo 'selected'; ?>>Accessories</option>
                                        <option value="other" <?php if ($row['itemCategory'] == 'other') echo 'selected'; ?>>Other</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="dateFound">Date Found*</label>
                                    <input type="date" id="dateFound" name="dateFound" value="<?php echo $row['dateFound'] ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="location">Location*</label>
                                    <input type="text" id="location" name="location" value="<?php echo $row['location'] ?>" required placeholder="e.g. Black Wallet, iPhone 12">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3><i class="fa fa-image"></i> Item Image</h3>
                            <div class="image-upload-container">
                                <div class="form-group">
                                    <label for="itemImage">Image*</label>
                                    <input type="text" id="itemImage" name="itemImage" value="<?php echo $row['itemImage'] ?>" required placeholder="e.g. Black Wallet, iPhone 12">
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3><i class="fa fa-align-left"></i> Detailed Description</h3>
                            <div class="form-group">
                                <label for="description">Description*</label>
                                <textarea id="description" name="description" rows="4" required
                                    placeholder="Provide detailed description including color, brand, distinguishing features, contents if applicable"><?php echo $row['description']; ?></textarea>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3><i class="fa fa-user"></i> Reporter Information</h3>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="reporterName">Reporter Name*</label>
                                    <input type="text" id="reporterName" name="reporterName" value="<?php echo $row['reporterName']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="reporterEmail">Email*</label>
                                    <input type="email" id="reporterEmail" name="reporterEmail" value="<?php echo $row['reporterEmail']; ?>" required>
                                </div>

                                <div class=" form-group">
                                    <label for="reporterContact">Phone Number</label>
                                    <input type="tel" id="reporterContact" name="reporterContact" value="<?php echo $row['reporterContact']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class=" form-actions">
                            <button type="button" class="btn-cancel" onclick="window.location.href='AdminListOfitems.php'">Cancel</button>
                            <button type="submit" class="btn-submit" name="edit" onclick='window.location.href="adminListOfItems.php"'>
                                <i class="fa fa-plus"></i> Edit Item
                            </button>
                        </div>
                    </form>
                <?php }
            } else {
                ?>
                <form action="../Controllers/action_item.php" method="POST" id="addItemForm">
                    <div class="form-section">
                        <h3><i class="fa fa-info-circle"></i> Basic Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="itemName">Item Name*</label>
                                <input type="text" id="itemName" name="itemName" required placeholder="e.g. Black Wallet, iPhone 12">
                            </div>

                            <div class="form-group">
                                <label for="itemCategory">Category*</label>
                                <select id="itemCategory" name="itemCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="documents">Documents</option>
                                    <option value="personal">Personal Items</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="accessories">Accessories</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="dateFound">Date Found*</label>
                                <input type="date" id="dateFound" name="dateFound" required>
                            </div>

                            <div class="form-group">
                                <label for="location">Location*</label>
                                <input type="text" id="location" name="location" required placeholder="e.g. Black Wallet, iPhone 12">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fa fa-image"></i> Item Image</h3>
                        <div class="image-upload-container">
                            <div class="form-group">
                                <label for="itemImage">Image*</label>
                                <input type="text" id="itemImage" name="itemImage" required placeholder="e.g. Black Wallet, iPhone 12">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fa fa-align-left"></i> Detailed Description</h3>
                        <div class="form-group">
                            <label for="description">Description*</label>
                            <textarea id="description" name="description" rows="4" required
                                placeholder="Provide detailed description including color, brand, distinguishing features, contents if applicable"></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3><i class="fa fa-user"></i> Reporter Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="reporterName">Reporter Name*</label>
                                <input type="text" id="reporterName" name="reporterName" required>
                            </div>

                            <div class="form-group">
                                <label for="reporterEmail">Email*</label>
                                <input type="email" id="reporterEmail" name="reporterEmail" required>
                            </div>

                            <div class="form-group">
                                <label for="reporterContact">Phone Number</label>
                                <input type="text" id="reporterContact" name="reporterContact" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="window.location.href='AdminListOfitems.php'">Cancel</button>
                        <button type="submit" name="add" class="btn-submit">
                            <i class="fa fa-plus"></i> Add Item
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</body>

</html>