<?php

include "../Model/item.php";
$item = new Item();

// Pagination setup
$limit = 9; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalItems = $item->getItemCount();
$totalPages = ceil($totalItems / $limit);

if ($page < 1) {
    header("Location: ?page=1");
    exit;
} elseif ($page > $totalPages) {
    header("Location: ?page=$totalPages");
    exit;
}

$items = $item->getAllItemsPaginated($limit, $offset);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost Item Inventory</title>
    <link rel="stylesheet" href="../Styles/adminListOfItems.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include "../Includes/AdminSidebar.php" ?>

    <div class="main-content">
        <div class="content-header">
            <h2 class="title">Lost Item Inventory</h2>
            <div class="item-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <input type="text" placeholder="Search items...">
                        <button><i class="fa fa-search"></i></button>
                    </div>
                    <select class="filter-select">
                        <option>All Categories</option>
                        <option>Electronics</option>
                        <option>Documents</option>
                        <option>Personal Items</option>
                        <option>Clothing</option>
                        <option>Accessories</option>
                    </select>
                </div>
                <button class="btn-add-item" onclick="window.location.href='AdminAddItem.php'">
                    <i class="fa fa-plus"></i> Add New Item
                </button>
            </div>
        </div>

        <div class="items-container">
            <div class="items-grid">
                <?php if (empty($items)): ?>
                    <p class="empty-message" style="text-align: center;">No items found.</p>
                <?php else: ?>
                    <?php foreach ($items as $item): ?>
                        <div class="item-card" data-category="<?= $item['itemCategory']; ?>">
                            <div class="item-image">
                                <img src="<?= $item['itemImage'] ?>" alt="Item Image">
                                <span class="item-status found"><?= $item['status'] ?></span>
                            </div>
                            <div class="item-details">
                                <div class="title-id">
                                    <h3><?= $item['itemName'] ?></h3>
                                    <p>Item ID: <strong>#<?= $item['item_id'] ?></strong></p>
                                </div>
                                <div class="item-meta">
                                    <span><?= $item['dateFound'] ?></span>
                                    <span><?= $item['location'] ?></span>
                                </div>
                                <p class="item-desc"><?= $item['description'] ?></p>
                                <div class="item-actions">
                                    <a href="AdminAddItem.php?edit=<?= $item['item_id'] ?>" class="btn-edit"><i class="fa fa-edit"></i></a>
                                    <button class="btn-delete" data-id="<?= $item['item_id']; ?>"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="no-results" style="display: none; text-align: center;">
                <h1>No items found.</h1>
            </div>

            <!-- Pagination Controls -->
            <div class="pagination-controls">
                <?php if ($page > 1): ?>
                    <a class="pagination-btn" href="?page=<?= $page - 1 ?>"><i class="fa fa-chevron-left"></i> Previous</a>
                <?php else: ?>
                    <span class="pagination-btn" style="opacity: 0.5;"><i class="fa fa-chevron-left"></i> Previous</span>
                <?php endif; ?>

                <div class="page-numbers">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="pagination-btn <?= ($i == $page) ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>

                <?php if ($page < $totalPages): ?>
                    <a class="pagination-btn" href="?page=<?= $page + 1 ?>">Next <i class="fa fa-chevron-right"></i></a>
                <?php else: ?>
                    <span class="pagination-btn" style="opacity: 0.5;">Next <i class="fa fa-chevron-right"></i></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include '../Includes/RemoveItemModal.php'; ?>

    <script>
        const itemCards = document.querySelectorAll('.item-card');
        const filterSelect = document.querySelector('.filter-select');
        const searchInput = document.querySelector('.search-box input');
        const noResults = document.querySelector('.no-results');

        function filterItems() {
            const selectedCategory = filterSelect.value.toLowerCase();
            const searchTerm = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            itemCards.forEach(card => {
                const category = card.getAttribute('data-category').toLowerCase();
                const name = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.item-desc').textContent.toLowerCase();

                const matchesCategory = selectedCategory === 'all categories' || selectedCategory === category;
                const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);

                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        filterSelect.addEventListener('change', filterItems);
        searchInput.addEventListener('input', filterItems);

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
    </script>

</body>

</html>