// Get CSRF token from meta tag
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    return token ? token.getAttribute("content") : "";
}

document.addEventListener("DOMContentLoaded", function () {
    // Note: Eye button now uses
    const viewButtons = document.querySelectorAll(".view-user-transaction-btn");

    viewButtons.forEach((button) => {
        button.addEventListener("click", function () {
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
document.addEventListener("click", async function (e) {
    const btn = e.target.closest && e.target.closest(".return-btn");
    if (!btn) return;
    const id = btn.dataset.txId;

    const confirmed = await showConfirm(
        `Are you sure you want to request return for transaction #${id}?`,
        "Confirm Return"
    );
    if (!confirmed) return;

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
                        ? parseFloat(body.fee)
                        : 0;
                const bookTitle =
                    body && body.book_title ? body.book_title : "Book";
                const daysOverdue =
                    body && body.days_overdue ? body.days_overdue : 0;

                // Show toast notification with fee information
                let toastMessage =
                    body && body.message
                        ? body.message
                        : "Return request submitted successfully.";
                if (fee > 0) {
                    showToast(
                        `${bookTitle} - Return Requested`,
                        `Days overdue: ${daysOverdue} | Total Fee: ₱${fee.toFixed(
                            2
                        )}`,
                        "warning"
                    );
                } else {
                    showToast("Return Requested", toastMessage, "success");
                }

                // Update UI immediately: mark row as Return Pending and freeze fee
                try {
                    function findRowByTxId(txId) {
                        let row = document.querySelector(
                            `tr[data-tx-id="${txId}"]`
                        );
                        if (row) return row;
                        const rows =
                            document.querySelectorAll("table tbody tr");
                        for (const r of rows) {
                            const first = r.querySelector("td");
                            if (
                                first &&
                                first.textContent.trim() === String(txId)
                            )
                                return r;
                        }
                        return null;
                    }
                    function parseMoneyText(t) {
                        return (
                            parseFloat(
                                String(t || "").replace(/[^\d.]/g, "") || "0"
                            ) || 0
                        );
                    }
                    function formatMoney(n) {
                        const v = Math.max(0, parseFloat(n || 0));
                        return `₱${v.toFixed(2)}`;
                    }
                    function updateOutstanding(delta) {
                        const amtEl = document.getElementById(
                            "outstandingFeesAmount"
                        );
                        if (!amtEl) return;
                        const current = parseFloat(
                            amtEl.getAttribute("data-amount") || "0"
                        );
                        const next = Math.max(
                            0,
                            current + (parseFloat(delta) || 0)
                        );
                        amtEl.setAttribute("data-amount", String(next));
                        amtEl.textContent = `₱${next.toFixed(2)}`;
                        const payBtn = document.getElementById(
                            "outstandingFeesPayBtn"
                        );
                        if (payBtn)
                            payBtn.setAttribute("data-fee", String(next));
                    }

                    const row = findRowByTxId(id);
                    if (row) {
                        // Status column index = 6
                        const statusCell = row.children[6];
                        if (statusCell) {
                            statusCell.innerHTML =
                                '<span class="status-label inline-flex items-center px-2.5 py-0.5 rounded-md text-small font-medium text-orange-500">Return pending</span>';
                        }
                        // Fee column index = 7
                        const feeCell = row.children[7];
                        const feeSpan = feeCell
                            ? feeCell.querySelector(".live-fee")
                            : null;
                        let prev = 0;
                        if (feeSpan) {
                            prev = parseMoneyText(feeSpan.textContent);
                            // If API didn't send fee or sent 0 for an overdue, keep previous computed fee
                            const safeFee =
                                isFinite(fee) && fee > 0 ? fee : prev;
                            feeSpan.setAttribute("data-freeze", "1");
                            feeSpan.textContent = formatMoney(safeFee);
                        }
                        const delta =
                            (isFinite(fee) && fee > 0 ? fee : prev) - prev;
                        updateOutstanding(delta);
                    }
                } catch (err) {
                    // No-op if DOM structure changed
                    console.warn("UI update failed:", err);
                }

                // Emit a custom event for any listeners
                try {
                    window.dispatchEvent(
                        new CustomEvent("user:return-success", {
                            detail: { id, fee, days_overdue: daysOverdue },
                        })
                    );
                } catch {}
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
                await showError(msg);
            }
        })
        .catch(
            async (err) =>
                await showError(err.message || "Network error", "Error")
        );
});

// Toast Notification Function
function showToast(title, message, type = "info") {
    // Remove existing toast if any
    const existingToast = document.getElementById("feeToast");
    if (existingToast) {
        existingToast.remove();
    }

    // Create toast container
    const toast = document.createElement("div");
    toast.id = "feeToast";
    toast.className = "fixed top-20 right-6 z-[9999] animate-slide-in-right";

    // Color scheme based on type
    const colors = {
        success: {
            bg: "bg-emerald-500/10",
            border: "border-emerald-500/30",
            icon: "text-emerald-500",
            iconBg: "bg-emerald-500/20",
        },
        warning: {
            bg: "bg-amber-500/10",
            border: "border-amber-500/30",
            icon: "text-amber-500",
            iconBg: "bg-amber-500/20",
        },
        error: {
            bg: "bg-red-500/10",
            border: "border-red-500/30",
            icon: "text-red-500",
            iconBg: "bg-red-500/20",
        },
        info: {
            bg: "bg-blue-500/10",
            border: "border-blue-500/30",
            icon: "text-blue-500",
            iconBg: "bg-blue-500/20",
        },
    };

    const scheme = colors[type] || colors.info;

    // Icon based on type
    const icons = {
        success: "bi-check-circle-fill",
        warning: "bi-exclamation-triangle-fill",
        error: "bi-x-circle-fill",
        info: "bi-info-circle-fill",
    };

    const icon = icons[type] || icons.info;

    toast.innerHTML = `
        <div class="max-w-md ${scheme.bg} border ${scheme.border} backdrop-blur-sm rounded-xl shadow-2xl p-4">
            <div class="flex items-start gap-3">
                <div class="${scheme.iconBg} rounded-lg p-2 flex-shrink-0">
                    <i class="bi ${icon} ${scheme.icon} text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-white font-semibold text-sm mb-1">${title}</h4>
                    <p class="text-gray-300 text-xs leading-relaxed">${message}</p>
                </div>
                <button onclick="this.closest('#feeToast').remove()" class="text-gray-400 hover:text-white transition-colors flex-shrink-0">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(toast);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (toast && toast.parentNode) {
            toast.style.animation = "slide-out-right 0.3s ease-out";
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

// Add CSS animations
if (!document.getElementById("toastStyles")) {
    const style = document.createElement("style");
    style.id = "toastStyles";
    style.textContent = `
        @keyframes slide-in-right {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slide-out-right {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        .animate-slide-in-right {
            animation: slide-in-right 0.3s ease-out;
        }
    `;
    document.head.appendChild(style);
}
