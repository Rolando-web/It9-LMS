// Handle transaction modal data population and approve return
document.addEventListener("DOMContentLoaded", function () {
    const els = {
        bookImage: document.getElementById("modalBookImage"),
        bookTitle: document.getElementById("modalBookTitle"),
        bookAuthor: document.getElementById("modalBookAuthor"),
        userName: document.getElementById("modalUserName"),
        txId: document.getElementById("modalTxId"),
        borrowDate: document.getElementById("modalBorrowDate"),
        dueDate: document.getElementById("modalDueDate"),
        returnDate: document.getElementById("modalReturnDate"),
        fee: document.getElementById("modalFee"),
        status: document.getElementById("modalStatus"),
        statusLabel: document.getElementById("modalStatusLabel"),
        statusBox: document.getElementById("modalStatusBox"),
        returnDateBox: document.getElementById("modalReturnDateBox"),
        approveBtn: document.getElementById("approveReturnBtnModal"),
        rejectBtn: document.getElementById("rejectReturnBtnModal"),
        approvalButtons: document.getElementById("returnApprovalButtons"),
        receiptBtn: document.getElementById("downloadReceiptBtn"),
    };

    // Populate modal on view button click
    document.querySelectorAll(".view-transaction-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const txId = this.getAttribute("data-tx-id") || "";
            const bookTitle = this.getAttribute("data-book-title") || "--";
            const bookAuthor = this.getAttribute("data-book-author") || "--";
            const bookImage = this.getAttribute("data-book-image") || "";
            const userName = this.getAttribute("data-user-name") || "--";
            const borrowDate = this.getAttribute("data-borrow-date") || "--";
            const dueDate = this.getAttribute("data-due-date") || "--";
            const returnDate = this.getAttribute("data-return-date") || "--";
            const statusText = this.getAttribute("data-status") || "--";
            const feeVal = this.getAttribute("data-fee") || "0";
            const originalFee = this.getAttribute("data-original-fee") || feeVal;
            const isPaid = this.getAttribute("data-is-paid") === "1";

            // Basic assignments
            if (els.bookImage) els.bookImage.src = bookImage;
            if (els.bookTitle) els.bookTitle.textContent = bookTitle;
            if (els.bookAuthor) els.bookAuthor.textContent = bookAuthor;
            if (els.userName) els.userName.textContent = userName;
            if (els.txId) els.txId.textContent = txId;
            if (els.borrowDate) els.borrowDate.textContent = borrowDate;
            if (els.dueDate) els.dueDate.textContent = dueDate;
            if (els.returnDate)
                els.returnDate.textContent = returnDate || "Not returned";
            if (els.status) els.status.textContent = statusText;
            
            // Display fee with PAID badge if applicable
            if (els.fee) {
                if (isPaid) {
                    const feeNum = parseFloat(originalFee) || 0;
                    els.fee.innerHTML = '₱' + feeNum.toFixed(2) + '/<span style="color: #10b981; font-weight: bold; padding: 2px 8px; background: rgba(16, 185, 129, 0.1); border-radius: 4px; font-size: 0.85em;">PAID</span>';
                } else {
                    els.fee.textContent = `₱${Number(feeVal).toFixed(2)}`;
                }
            }

            // Update buttons with tx id
            if (els.approveBtn) els.approveBtn.setAttribute("data-tx-id", txId);
            if (els.rejectBtn) els.rejectBtn.setAttribute("data-tx-id", txId);

            // Show return approval buttons only for Return Pending
            if (els.approvalButtons) {
                if (statusText.toLowerCase() === "return pending") {
                    els.approvalButtons.classList.remove("d-none");
                } else {
                    els.approvalButtons.classList.add("d-none");
                }
            }

            // Update receipt link (admin route)
            if (els.receiptBtn) {
                els.receiptBtn.href = `/admin/transaction/${txId}/receipt`;
            }
        });
    });

    // Approve Return (admin)
    document.addEventListener("click", async function (e) {
        const approveBtn =
            e.target.closest && e.target.closest("#approveReturnBtnModal");
        if (!approveBtn) return;

        const txId = approveBtn.getAttribute("data-tx-id");
        if (!txId) return;

        const confirmed = window.confirm(
            `Are you sure you want to approve return for transaction #${txId}?`
        );
        if (!confirmed) return;

        const csrf = document.querySelector('meta[name="csrf-token"]');
        const token = csrf ? csrf.getAttribute("content") : "";

        try {
            const res = await fetch(
                `/admin/transactions/${txId}/approve-return`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        Accept: "application/json",
                    },
                }
            );
            const data = await res.json().catch(() => ({}));

            if (data && data.message) {
                const txModalEl = document.getElementById("bookModal");
                if (window.bootstrap && txModalEl) {
                    const txModal =
                        bootstrap.Modal.getInstance(txModalEl) ||
                        new bootstrap.Modal(txModalEl);
                    txModal.hide();
                }
                alert(data.message);
                window.location.reload();
            } else {
                alert("Failed to approve return. Please try again.");
            }
        } catch (err) {
            console.error(err);
            alert("An error occurred. Please try again.");
        }
    });
});

// (Payment handler intentionally omitted to restore previous normal behavior)
