// Get CSRF token from meta tag
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute("content") : "";
}

// Handle user transaction modal data population (NOT USED - using transaction-modal.js instead)
// Keeping this file for the return button functionality only

document.addEventListener("DOMContentLoaded", function () {
    // Note: Eye button now uses .view-transaction-btn class handled by transaction-modal.js
    const viewButtons = document.querySelectorAll(".view-user-transaction-btn");

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
            const returnDate = this.getAttribute("data-return-date");
            const status = this.getAttribute("data-status");
            const fee = this.getAttribute("data-fee");

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
            document.getElementById("modalFee").textContent = "₱" + fee;

            // Update download receipt button URL
            const downloadBtn = document.getElementById("downloadReceiptBtn");
            if (downloadBtn) {
                downloadBtn.href = "/transaction/" + txId + "/receipt";
            }

            // Update status box and return date box colors based on status
            const statusBox = document.getElementById("modalStatusBox");
            const statusLabel = document.getElementById("modalStatusLabel");
            const statusText = document.getElementById("modalStatus");
            const returnDateBox = document.getElementById("modalReturnDateBox");
            const returnDateText = document.getElementById("modalReturnDate");

            if (
                statusBox &&
                statusLabel &&
                statusText &&
                returnDateBox &&
                returnDateText
            ) {
                statusBox.className = "rounded-lg p-3 border";
                statusLabel.className = "text-xs mb-1";
                statusText.className = "font-bold text-lg";
                returnDateBox.className = "rounded-lg p-3 border";
                returnDateText.className = "font-bold text-lg";

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
                    statusBox.classList.add(
                        "bg-red-500/10",
                        "border-red-500/20"
                    );
                    statusLabel.classList.add("text-red-500");
                    statusText.classList.add("text-red-500");
                    returnDateBox.classList.add(
                        "bg-gray-500/10",
                        "border-gray-500/20"
                    );
                    returnDateText.classList.add("text-gray-400");
                } else if (status.toLowerCase() === "borrowed") {
                    statusBox.classList.add(
                        "bg-blue-500/10",
                        "border-blue-500/20"
                    );
                    statusLabel.classList.add("text-blue-500");
                    statusText.classList.add("text-blue-500");
                    returnDateBox.classList.add(
                        "bg-gray-500/10",
                        "border-gray-500/20"
                    );
                    returnDateText.classList.add("text-gray-400");
                } else {
                    statusBox.classList.add(
                        "bg-gray-500/10",
                        "border-gray-500/20"
                    );
                    statusLabel.classList.add("text-gray-500");
                    statusText.classList.add("text-gray-500");
                    returnDateBox.classList.add(
                        "bg-gray-500/10",
                        "border-gray-500/20"
                    );
                    returnDateText.classList.add("text-gray-400");
                }
            }
        });
    });
});

// Handle return button clicks
document.addEventListener("click", function (e) {
    const btn = e.target.closest && e.target.closest(".return-btn");
    if (!btn) return;
    const id = btn.dataset.txId;
    if (!confirm("Confirm return for transaction #" + id + "?")) return;

    fetch("/return/" + id, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": getCsrfToken(),
            "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
    })
        .then(async (r) => {
            const ct = r.headers.get("content-type") || "";
            let body = null;
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
                const fee =
                    body &&
                    typeof body === "object" &&
                    typeof body.fee !== "undefined"
                        ? body.fee
                        : null;
                alert(
                    "Return processed." + (fee !== null ? " Fee: " + fee : "")
                );
                location.reload();
            } else {
                let msg = "Unable to return";
                if (body && typeof body === "object" && body.message)
                    msg = body.message;
                else if (body && typeof body === "string") {
                    const stripped = body.replace(/<[^>]*>?/gm, "").trim();
                    msg = stripped.length
                        ? stripped.length > 300
                            ? stripped.slice(0, 300) + "..."
                            : stripped
                        : msg;
                }
                alert(msg);
            }
        })
        .catch((err) => alert(err.message || "Network error"));
});
