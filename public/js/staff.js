// Get CSRF token from meta tag
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute("content") : "";
}

function showAdminToast(message, sub) {
    const t = document.getElementById("adminToast");
    const msg = document.getElementById("adminToastMsg");
    const subEl = document.getElementById("adminToastSub");

    if (!t || !msg || !subEl) return;

    msg.innerText = message;
    subEl.innerText = sub || "";
    t.classList.remove("hidden");
    t.style.opacity = "0";
    requestAnimationFrame(() => {
        t.style.transition = "opacity 200ms";
        t.style.opacity = "1";
    });
    setTimeout(() => {
        t.style.opacity = "0";
        setTimeout(() => t.classList.add("hidden"), 220);
    }, 2200);
}

document.addEventListener("click", function (e) {
    const btn =
        e.target.closest &&
        (e.target.closest(".approve-btn") || e.target.closest(".reject-btn"));
    if (!btn) return;
    const id = btn.dataset.txId;
    const action = btn.dataset.action;
    if (!id || !action) return;

    if (!confirm("Confirm " + action + " for transaction #" + id + "?")) return;

    // disable buttons while processing
    const parent = btn.closest("td");
    const buttons = parent.querySelectorAll("button");
    buttons.forEach((b) => (b.disabled = true));

    fetch("/admin/transactions/" + id + "/" + action, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": getCsrfToken(),
            "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
    })
        .then(async (r) => {
            let body = null;
            const ct = r.headers.get("content-type") || "";
            if (ct.indexOf("application/json") !== -1) {
                try {
                    body = await r.json();
                } catch (e) {
                    body = null;
                }
            } else {
                try {
                    body = await r.text();
                } catch (e) {
                    body = null;
                }
            }

            if (r.ok) {
                showAdminToast(
                    "Request " + action + "ed",
                    body && body.message ? body.message : ""
                );
                // remove the row from the table to reflect change
                const row = document.getElementById("tx-row-" + id);
                if (row) row.remove();
            } else {
                const msg =
                    body && body.message
                        ? body.message
                        : typeof body === "string"
                        ? body.replace(/<[^>]*>?/gm, "").trim()
                        : "Unable to process request";
                showAdminToast(msg);
                buttons.forEach((b) => (b.disabled = false));
            }
        })
        .catch((err) => {
            showAdminToast(err.message || "Network error");
            buttons.forEach((b) => (b.disabled = false));
        });
});

// Handle Approve Return button
document.addEventListener("click", function (e) {
    const btn = e.target.closest && e.target.closest(".approve-return-btn");
    if (!btn) return;

    const txId = btn.dataset.txId;
    if (!txId) return;

    if (
        !confirm(
            "Approve this book return? The book will be marked as returned."
        )
    )
        return;

    // Disable button while processing
    btn.disabled = true;
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Processing...';

    fetch("/admin/transactions/" + txId + "/approve-return", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": getCsrfToken(),
            "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
    })
        .then(async (r) => {
            let body = null;
            const ct = r.headers.get("content-type") || "";
            if (ct.indexOf("application/json") !== -1) {
                try {
                    body = await r.json();
                } catch (e) {
                    body = null;
                }
            }

            if (r.ok) {
                showAdminToast(
                    "Return Approved",
                    body && body.message
                        ? body.message
                        : "Book return has been approved"
                );
                // Reload the page to refresh the table
                setTimeout(() => window.location.reload(), 1000);
            } else {
                const msg =
                    body && body.message
                        ? body.message
                        : "Unable to approve return";
                showAdminToast(msg);
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        })
        .catch((err) => {
            showAdminToast(err.message || "Network error");
            btn.disabled = false;
            btn.innerHTML = originalHTML;
        });
});

// Handle Reject Return Modal - Set transaction ID when modal opens
document.addEventListener("DOMContentLoaded", function () {
    const rejectReturnModal = document.getElementById("rejectReturnModal");

    if (!rejectReturnModal) {
        console.error("Reject modal not found!");
        return;
    }

    // Check if Bootstrap is loaded
    if (typeof bootstrap === "undefined") {
        console.error("Bootstrap is not loaded!");
        return;
    }

    console.log("Reject modal initialized successfully");

    rejectReturnModal.addEventListener("show.bs.modal", function (event) {
        // Button that triggered the modal
        const button = event.relatedTarget;

        if (!button) {
            console.error("No button found that triggered the modal");
            return;
        }

        const txId = button.getAttribute("data-tx-id");
        console.log("Modal opening for transaction:", txId);

        // Set transaction ID in the modal
        const txIdInput = document.getElementById("rejectTransactionId");
        if (txIdInput) {
            txIdInput.value = txId;
            console.log("Transaction ID set in modal:", txId);
        } else {
            console.error("Transaction ID input field not found");
        }

        // Reset form
        const form = document.getElementById("rejectReturnForm");
        if (form) {
            form.reset();
        }

        // Set default damage fee
        const damageFeeInput = document.getElementById("damageFee");
        if (damageFeeInput) {
            damageFeeInput.value = "50.00";
        }
    });
});

// Handle Confirm Reject button in Modal
document.addEventListener("click", function (e) {
    if (
        e.target.id !== "confirmRejectBtn" &&
        !e.target.closest("#confirmRejectBtn")
    )
        return;

    const form = document.getElementById("rejectReturnForm");
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const txId = document.getElementById("rejectTransactionId").value;
    const reason = document.getElementById("rejectReason").value;
    const damageFee = document.getElementById("damageFee").value;

    if (!txId || !reason || !damageFee) {
        alert("Please fill in all fields");
        return;
    }

    const confirmBtn = document.getElementById("confirmRejectBtn");
    confirmBtn.disabled = true;
    confirmBtn.innerHTML =
        '<i class="bi bi-hourglass-split me-1"></i>Processing...';

    fetch("/admin/transactions/" + txId + "/reject-return", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": getCsrfToken(),
            "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
        body: JSON.stringify({
            reason: reason,
            damage_fee: parseFloat(damageFee),
        }),
    })
        .then(async (r) => {
            let body = null;
            const ct = r.headers.get("content-type") || "";
            if (ct.indexOf("application/json") !== -1) {
                try {
                    body = await r.json();
                } catch (e) {
                    body = null;
                }
            }

            if (r.ok) {
                // Close the modal
                const modal = bootstrap.Modal.getInstance(
                    document.getElementById("rejectReturnModal")
                );
                if (modal) modal.hide();

                showAdminToast(
                    "Return Rejected",
                    body && body.message
                        ? body.message
                        : "Book return has been rejected with damage fee"
                );
                // Reload the page to refresh the table
                setTimeout(() => window.location.reload(), 1000);
            } else {
                const msg =
                    body && body.message
                        ? body.message
                        : "Unable to reject return";
                showAdminToast(msg);
                confirmBtn.disabled = false;
                confirmBtn.innerHTML =
                    '<i class="bi bi-check-circle me-1"></i>Confirm Rejection';
            }
        })
        .catch((err) => {
            showAdminToast(err.message || "Network error");
            confirmBtn.disabled = false;
            confirmBtn.innerHTML =
                '<i class="bi bi-check-circle me-1"></i>Confirm Rejection';
        });
});
