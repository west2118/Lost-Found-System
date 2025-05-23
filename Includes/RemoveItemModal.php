<!-- delete_modal.php -->
<link rel="stylesheet" href="../Styles/removeModal.css">

<div class="overlay cancelBtn" id="overlay"></div>

<div class="modal" id="deleteModal">
    <div class="modal-header">
        <h3 class="modal-title">Remove Item</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to remove this item? This action cannot be undone.</p>
    </div>
    <div class="modal-footer">
        <form method="POST" action="<?= $deleteAction ?? '../Controllers/action_item.php' ?>">
            <input type="hidden" name="delete_id" id="deleteItemId">
            <button type="button" class="btn btn-cancel cancelBtn">Cancel</button>
            <button type="submit" class="btn btn-remove" name="confirm_delete">Remove</button>
        </form>
    </div>
</div>