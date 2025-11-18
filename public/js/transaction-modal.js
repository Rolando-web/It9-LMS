// Handle transaction modal data population
document.addEventListener("DOMContentLoaded", function () {
    const viewButtons = document.querySelectorAll(".view-transaction-btn");

    viewButtons.forEach((button) => {
        button.addEventListener("click", function () {
            // Get data from button attributes
            const txId = this.getAttribute("data-tx-id");
            const bookTitle = this.getAttribute("data-book-title");
            const bookAuthor = this.getAttribute("data-book-author");
            const bookImage = this.getAttribute("data-book-image");
            const userName = this.getAttribute("data-user-name");
            const borrowDate = this.getAttribute("data-borrow-date");
            const dueDate = this.getAttribute("data-due-date");
            const dueRaw = this.getAttribute("data-due-raw") || "";
            const returnDate = this.getAttribute("data-return-date");
            const status = this.getAttribute("data-status");
            const fee = this.getAttribute("data-fee");

            // Show/hide return approval buttons based on status
            const returnApprovalButtons = document.getElementById(
                "returnApprovalButtons"
            );
            if (status.toLowerCase() === "return pending") {
                returnApprovalButtons.classList.remove("d-none");
                // Store transaction ID for approval buttons
                document
                    .getElementById("approveReturnBtnModal")
                    .setAttribute("data-tx-id", txId);
                document
                    .getElementById("rejectReturnBtnModal")
                    .setAttribute("data-tx-id", txId);
                const damageBtn = document.getElementById(
                    "damageReturnBtnModal"
                );
                if (damageBtn) damageBtn.setAttribute("data-tx-id", txId);
            } else {
                returnApprovalButtons.classList.add("d-none");
            }

            // Show/hide Pay Now button based on fee amount (user page only)
            const payNowBtn = document.getElementById("payNowBtn");
            const payNowAmount = document.getElementById("payNowAmount");
            let feeAmount = parseFloat(fee.replace(/,/g, ""));
            if (isNaN(feeAmount) || feeAmount < 0) feeAmount = 0; // clamp negative/NaN
            const isUserPage =
                window.location.pathname.includes("/user-transaction");

            // Recompute live overdue (₱50/day) for active/unreturned items (borrowed, overdue, return_pending)
            const normStatus = (status || "").toLowerCase();
            const isOverdueStatus = normStatus === "overdue";

            if (
                (normStatus === "borrowed" ||
                    normStatus === "overdue" ||
                    normStatus === "return pending") &&
                dueRaw
            ) {
                try {
                    const toMid = (d) => {
                        const dt = new Date(d + "T00:00:00");
                        dt.setHours(0, 0, 0, 0);
                        return dt;
                    };
                    const due = toMid(dueRaw);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const diffMs = today.getTime() - due.getTime();
                    const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                    const live = days > 0 ? days * 50 : 0;
                    feeAmount = live;
                } catch (e) {
                    // ignore, fall back to provided fee
                }
            }

            // Show Pay Now button for overdue transactions or any transaction with fees
            if (payNowBtn) {
                const shouldShowPay =
                    (feeAmount > 0 || isOverdueStatus) && isUserPage;
                if (shouldShowPay) {
                    payNowBtn.classList.remove("d-none");
                    payNowBtn.setAttribute("data-tx-id", txId);
                    payNowBtn.setAttribute("data-fee", Math.max(0, feeAmount));
                    if (payNowAmount) {
                        payNowAmount.textContent = Math.max(
                            0,
                            feeAmount
                        ).toFixed(2);
                    }
                } else {
                    payNowBtn.classList.add("d-none");
                }
            }

            // Update modal content
            document.getElementById("modalTxId").textContent = txId;
            document.getElementById("modalBookTitle").textContent = bookTitle;
            document.getElementById("modalBookAuthor").textContent = bookAuthor;
            document.getElementById("modalBookImage").src = bookImage;
            document.getElementById("modalUserName").textContent = userName;
            document.getElementById("modalBorrowDate").textContent = borrowDate;
            document.getElementById("modalDueDate").textContent = dueDate;
            document.getElementById("modalReturnDate").textContent = returnDate;
            document.getElementById("modalStatus").textContent = status;
            document.getElementById("modalFee").textContent =
                "₱" + feeAmount.toFixed(2);

            // Update download receipt button URL
            // Check if we're on admin page or user page
            const isAdminPage =
                window.location.pathname.includes("/transaction") ||
                window.location.pathname.includes("/admin");
            const receiptUrl = isAdminPage
                ? "/admin/transaction/" + txId + "/receipt"
                : "/transaction/" + txId + "/receipt";
            document.getElementById("downloadReceiptBtn").href = receiptUrl;

            // Update status box and return date box colors based on status
            const statusBox = document.getElementById("modalStatusBox");
            const statusLabel = document.getElementById("modalStatusLabel");
            const statusText = document.getElementById("modalStatus");
            const returnDateBox = document.getElementById("modalReturnDateBox");
            const returnDateText = document.getElementById("modalReturnDate");

            // Remove all color classes
            statusBox.className = "rounded-lg p-3 border";
            statusLabel.className = "text-xs mb-1";
            statusText.className = "font-bold text-lg";
            returnDateBox.className = "rounded-lg p-3 border";
            returnDateText.className = "font-bold text-lg";

            // Add appropriate color based on status
            if (status.toLowerCase() === "returned") {
                statusBox.classList.add(
                    "bg-emerald-500/10",
                    "border-emerald-500/20"
                );
                statusLabel.classList.add("text-emerald-500");
                statusText.classList.add("text-emerald-500");
                returnDateBox.classList.add(
                    "bg-emerald-500/10",
                    "border-emerald-500/20"
                );
                returnDateText.classList.add("text-emerald-500");
            } else if (status.toLowerCase() === "overdue") {
                statusBox.classList.add("bg-red-500/10", "border-red-500/20");
                statusLabel.classList.add("text-red-500");
                statusText.classList.add("text-red-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "borrowed") {
                statusBox.classList.add("bg-blue-500/10", "border-blue-500/20");
                statusLabel.classList.add("text-blue-500");
                statusText.classList.add("text-blue-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "pending") {
                statusBox.classList.add(
                    "bg-amber-500/10",
                    "border-amber-500/20"
                );
                statusLabel.classList.add("text-amber-500");
                statusText.classList.add("text-amber-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "return pending") {
                statusBox.classList.add(
                    "bg-orange-500/10",
                    "border-orange-500/20"
                );
                statusLabel.classList.add("text-orange-500");
                statusText.classList.add("text-orange-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "rejected") {
                statusBox.classList.add("bg-gray-500/10", "border-gray-500/20");
                statusLabel.classList.add("text-gray-500");
                statusText.classList.add("text-gray-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else {
                statusBox.classList.add("bg-gray-500/10", "border-gray-500/20");
                statusLabel.classList.add("text-gray-500");
                statusText.classList.add("text-gray-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            }
        });
    });

    // Handle Approve Return button (admin pages)
    document.addEventListener("click", async function (e) {
        const approveBtn =
            e.target.closest && e.target.closest("#approveReturnBtnModal");
        if (approveBtn) {
            const txId = approveBtn.getAttribute("data-tx-id");
            if (!txId) return;

            const confirmed = await showConfirm(
                `Are you sure you want to approve return for transaction #${txId}?`,
                "Approve Return"
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

                const data = await res.json();

                if (data && data.message) {
                    // Hide transaction modal
                    const txModalEl = document.getElementById("bookModal");
                    if (window.bootstrap && txModalEl) {
                        const txModal =
                            bootstrap.Modal.getInstance(txModalEl) ||
                            new bootstrap.Modal(txModalEl);
                        txModal.hide();
                    }
                    await showSuccess(data.message);
                    window.location.reload();
                } else {
                    await showError(
                        "Failed to approve return. Please try again.",
                        "Error"
                    );
                }
            } catch (err) {
                console.error(err);
                await showError(
                    "An error occurred. Please try again.",
                    "Error"
                );
            }
        }
    });

    // Open Damage modal when clicking Reject/Damage button (admin pages)
    document.addEventListener("click", function (e) {
        const rejectBtn =
            e.target.closest && e.target.closest("#rejectReturnBtnModal");
        const damageBtn =
            e.target.closest && e.target.closest("#damageReturnBtnModal");
        if (rejectBtn || damageBtn) {
            const btn = rejectBtn || damageBtn;
            const txId = btn.getAttribute("data-tx-id");
            const txInput = document.getElementById("damageTxId");
            const reasonInput = document.getElementById("damageReason");
            const feeInput = document.getElementById("damageFee");
            if (txInput) txInput.value = txId || "";
            if (reasonInput) reasonInput.value = "";
            if (feeInput) feeInput.value = "";

            if (window.bootstrap) {
                const modalEl = document.getElementById("damageReturnModal");
                const damageModal = new bootstrap.Modal(modalEl);
                damageModal.show();
            } else {
                console.warn("Bootstrap not found for damage modal");
            }
        }
    });

    // Submit damage form
    const confirmDamage = document.getElementById("confirmDamageBtn");
    if (confirmDamage) {
        confirmDamage.addEventListener("click", async function () {
            const txId = document.getElementById("damageTxId").value;
            const reason = (
                document.getElementById("damageReason").value || ""
            ).trim();
            const damageFee = parseFloat(
                document.getElementById("damageFee").value || "0"
            );

            if (!reason) {
                await showError(
                    "Please enter a reason for the damage.",
                    "Validation Error"
                );
                return;
            }
            if (isNaN(damageFee) || damageFee < 0) {
                await showError(
                    "Please enter a valid damage fee (0 or greater).",
                    "Validation Error"
                );
                return;
            }

            const csrf = document.querySelector('meta[name="csrf-token"]');
            const token = csrf ? csrf.getAttribute("content") : "";

            try {
                const res = await fetch(
                    `/admin/transactions/${txId}/reject-return`,
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": token,
                            Accept: "application/json",
                        },
                        body: JSON.stringify({
                            reason: reason,
                            damage_fee: damageFee,
                        }),
                    }
                );

                const data = await res.json();

                if (data && data.message) {
                    // Hide modal and refresh
                    const modalEl =
                        document.getElementById("damageReturnModal");
                    if (window.bootstrap && modalEl) {
                        const dm =
                            bootstrap.Modal.getInstance(modalEl) ||
                            new bootstrap.Modal(modalEl);
                        dm.hide();
                    }
                    await showSuccess(data.message);
                    window.location.reload();
                } else {
                    await showError(
                        "Failed to apply damage. Please try again.",
                        "Error"
                    );
                }
            } catch (err) {
                console.error(err);
                await showError(
                    "An error occurred. Please try again.",
                    "Error"
                );
            }
        });
    }
});

// (Payment handler intentionally omitted to restore previous normal behavior)
