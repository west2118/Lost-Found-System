<!-- delete_modal.php -->
<link rel="stylesheet" href="../Styles/emailUserModal.css">

<div class="overlay cancelBtn" id="overlay"></div>

<div class="modal" id="email_user_modal">
    <div class="modal-header">
        <h3 class="modal-title" id="modalTitle">Found Item</h3>
    </div>
    <div class="modal-body" id="modalBodyText">
        <p>This item has been successfully matched. Please advise the owner to claim it at the <strong>OSA Office</strong>.</p>
        <p>Make sure to note the reference number and item details for verification.</p>
        <p><strong>REF NUM:</strong> <span id="displayRefNum"></span></p>
    </div>
    <div class="modal-footer">
        <form method="POST" action="../Controllers/action_report.php">
            <input type="hidden" name="report_id" id="modalReportId">
            <input type="hidden" name="fullName" id="modalFullname">
            <input type="hidden" name="item_id" id="modalItemId">
            <input type="hidden" name="ref_number" id="modalRefNum">
            <input type="hidden" name="email" id="modalEmail">
            <button type="button" class="btn btn-cancel cancelBtn">Cancel</button>
            <button type="submit" class="btn btn-remove" name="confirm_match">Confirm</button>
        </form>
    </div>
</div>

<script>
    // Adjust modal content depending on button clicked (match or notify)
    function openModalForMatch(data) {
        document.getElementById('modalTitle').textContent = 'Found Item';
        document.getElementById('modalBodyText').innerHTML = `
            <p>This item has been successfully matched. Please advise the owner to claim it at the <strong>OSA Office</strong>.</p>
            <p>Make sure to note the reference number and item details for verification.</p>
            <p><strong>REF NUM:</strong> <span id="displayRefNum">${data.refNum}</span></p>
        `;
        fillHiddenInputs(data);
        showModal();
    }

    function openModalForNotify(data) {
        document.getElementById('modalTitle').textContent = 'Notify User';
        document.getElementById('modalBodyText').innerHTML = `
            <p>We couldn't find any matching items for this report right now.</p>
            <p>Click Confirm below to notify the reporter or follow up with updated details.</p>
            <p><strong>Email:</strong> ${data.email}</span></p>
        `;
        // For notify, clear item_id and ref_number
        fillHiddenInputs({
            reportId: data.reportId,
            fullName: data.fullName,
            itemId: '',
            refNum: '',
            email: data.email
        });
        showModal();
    }

    function fillHiddenInputs({
        reportId,
        fullName,
        itemId,
        refNum,
        email
    }) {
        document.getElementById('modalReportId').value = reportId;
        document.getElementById('modalFullname').value = fullName;
        document.getElementById('modalItemId').value = itemId;
        document.getElementById('modalRefNum').value = refNum;
        document.getElementById('modalEmail').value = email;
    }

    function showModal() {
        document.getElementById('overlay').classList.add('show');
        document.getElementById('email_user_modal').classList.add('show');
    }

    // Cancel buttons hide modal
    document.querySelectorAll('.cancelBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('overlay').classList.remove('show');
            document.getElementById('email_user_modal').classList.remove('show');
        });
    });

    // Your existing listeners (adapted to use above functions)
    document.querySelectorAll('.btn-confirm').forEach(btn => {
        btn.addEventListener('click', () => {
            openModalForMatch({
                reportId: btn.getAttribute('data-report-id'),
                fullName: btn.getAttribute('data-full-name'),
                itemId: btn.getAttribute('data-item-id'),
                refNum: btn.getAttribute('data-ref-number'),
                email: btn.getAttribute('data-email')
            });
        });
    });

    document.querySelectorAll('.no-match-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            openModalForNotify({
                reportId: btn.getAttribute('data-report-id'),
                fullName: btn.getAttribute('data-full-name'),
                email: btn.getAttribute('data-email')
            });
        });
    });
</script>