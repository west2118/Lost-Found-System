<?php

include "../Model/item.php";
$item = new Item();

// Pagination setup
$limit = 10; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalItems = $item->getItemCount();
$totalPages = max(1, ceil($totalItems / $limit));

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
                        <button type="button"><i class="fa fa-search"></i></button>
                    </div>

                    <select class="filter-select category-select">
                        <option>All Categories</option>
                        <option>Electronics</option>
                        <option>Wallet</option>
                        <option>Keys</option>
                        <option>Bag</option>
                        <option>Jewelry</option>
                        <option>Other</option>
                    </select>

                    <select class="filter-select status-select">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Matched</option>
                        <option>No matched</option>
                        <option>Returned</option>
                        <option>Donated</option>
                    </select>
                </div>
                <button class="btn-add-item" onclick="window.location.href='AdminAddItem.php'">
                    <i class="fa fa-plus"></i> Add New Item
                </button>
            </div>
        </div>

        <div class="items-container">
            <div class="items-grid">
                <?php foreach ($items as $item) {
                ?>
                    <div class="item-card" data-category="<?= htmlspecialchars($item['itemCategory']); ?>"
                        data-status="<?= htmlspecialchars($item['status']); ?>">
                        <div class="item-image">
                            <img src="<?= $item['itemImage'] ?>" alt="Item Image">
                            <span class="item-status found"><?= $item['status'] ?></span>
                        </div>
                        <div class="item-details">
                            <div class="title-id">
                                <h3 class="item-name"><?= $item['itemName'] ?></h3>
                                <p>Item ID: <strong>#<?= $item['item_id'] ?></strong></p>
                            </div>
                            <div class="item-meta">
                                <span><?= $item['dateFound'] ?></span>
                                <span><?= $item['location'] ?></span>
                            </div>
                            <p class="item-desc"><?= $item['description'] ?></p>
                            <div class="item-actions">
                                <a href="AdminAddItem.php?edit=<?= $item['item_id'] ?>" class="btn-edit"><i class="fa fa-edit"></i></a>
                                <?php if ($item['status'] === 'pending'): ?>
                                    <form action="../Controllers/action_item.php" method="POST">
                                        <input type="text" name="item_id" value="<?php echo $item['item_id'] ?>" hidden>
                                        <button class="btn-donate" type="submit" name="btn-donate">Mark as Donated</button>
                                    </form>
                                <?php endif; ?>
                                <button class=" btn-delete" data-id="<?= $item['item_id']; ?>"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
        const categorySelect = document.querySelector('.category-select');
        const statusSelect = document.querySelector('.status-select');
        const searchInput = document.querySelector('.search-box input');
        const noResults = document.querySelector('.no-results');

        function filterItems() {
            const selectedCategory = categorySelect.value.toLowerCase();
            const selectedStatus = statusSelect.value.toLowerCase();
            const searchTerm = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            itemCards.forEach(card => {
                const category = card.getAttribute('data-category').toLowerCase();
                const status = card.getAttribute('data-status').toLowerCase();
                const name = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('.item-desc').textContent.toLowerCase();

                const matchesCategory = selectedCategory === 'all categories' || selectedCategory === category;
                const matchesStatus = selectedStatus === 'all status' || selectedStatus === status;
                const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);

                if (matchesCategory && matchesStatus && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        categorySelect.addEventListener('change', filterItems);
        statusSelect.addEventListener('change', filterItems);
        searchInput.addEventListener('input', filterItems);

        // Prevent button default behavior (if button is inside a form)
        const searchButton = document.querySelector('.search-box button');
        searchButton.addEventListener('click', (e) => {
            e.preventDefault();
            filterItems();
        });

        // Initial filtering
        filterItems();

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