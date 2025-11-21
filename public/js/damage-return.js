// Damage Return modal logic
// - Opens damage modal from transaction modal
// - Validates inputs and confirms action
// - Submits reject-return with reason and damage_fee

(function () {
    let damageConfirmed = false;

    function getToken() {
        const csrf = document.querySelector('meta[name="csrf-token"]');
        return csrf ? csrf.getAttribute("content") : "";
    }

    // Ensure damage modal is at document.body level (avoid nested modal stacking issues)
    function ensureDamageModalRoot() {
        const damageEl = document.getElementById("damageReturnModal");
        if (damageEl && damageEl.parentElement !== document.body) {
            document.body.appendChild(damageEl);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        ensureDamageModalRoot();
    });

    // Open Damage Return modal
    document.addEventListener("click", function (e) {
        const damageBtn =
            e.target.closest && e.target.closest("#rejectReturnBtnModal");
        if (!damageBtn) return;

        const txId = damageBtn.getAttribute("data-tx-id");
        if (!txId) return;

        ensureDamageModalRoot();

        const bookModalEl = document.getElementById("bookModal");
        const damageModalEl = document.getElementById("damageReturnModal");

        // Populate tx id and reset fields
        const txIdInput = document.getElementById("damageTxId");
        const reasonEl = document.getElementById("damageReason");
        const feeEl = document.getElementById("damageFee");
        if (txIdInput) txIdInput.value = txId;
        if (reasonEl) reasonEl.value = "";
        if (feeEl) feeEl.value = "";

        damageConfirmed = false;

        // Hide transaction modal before showing damage modal
        if (window.bootstrap && bookModalEl) {
            const bookModal =
                bootstrap.Modal.getInstance(bookModalEl) ||
                new bootstrap.Modal(bookModalEl);
            bookModal.hide();
        }

        // Show damage modal
        if (window.bootstrap && damageModalEl) {
            const damageModal =
                bootstrap.Modal.getInstance(damageModalEl) ||
                new bootstrap.Modal(damageModalEl);
            damageModal.show();
        }

        // If damage modal closed without confirming, restore the transaction modal
        if (damageModalEl) {
            damageModalEl.addEventListener(
                "hidden.bs.modal",
                function onHidden() {
                    damageModalEl.removeEventListener(
                        "hidden.bs.modal",
                        onHidden
                    );
                    // Hide any lingering custom notification overlay to prevent stacking issues
                    try {
                        const notif =
                            document.getElementById("notificationModal");
                        if (notif && !notif.classList.contains("hidden")) {
                            notif.classList.add("hidden");
                        }
                    } catch {}
                    if (!damageConfirmed && window.bootstrap && bookModalEl) {
                        const bookModal =
                            bootstrap.Modal.getInstance(bookModalEl) ||
                            new bootstrap.Modal(bookModalEl);
                        bookModal.show();
                    }
                }
            );
        }
    });

    // Confirm Apply Damage
    document.addEventListener("click", async function (e) {
        const confirmBtn =
            e.target.closest && e.target.closest("#confirmDamageBtn");
        if (!confirmBtn) return;

        const txId = (document.getElementById("damageTxId") || {}).value || "";
        const reason =
            (document.getElementById("damageReason") || {}).value || "";
        const feeRaw =
            (document.getElementById("damageFee") || {}).value || "0";
        const damageFee = parseFloat(feeRaw);

        if (!reason.trim()) {
            alert("Please enter a reason for the damage.");
            return;
        }
        if (isNaN(damageFee) || damageFee < 0) {
            alert("Please enter a valid damage fee (0 or greater).");
            return;
        }

        const summary = `Are you sure you want to mark this return as Damaged?\n\nReason: ${reason.trim()}\nDamage Fee: ₱${Number(
            damageFee
        ).toFixed(2)}`;
        let proceed = true;
        try {
            proceed = window.confirm(summary);
        } catch (_) {
            proceed = window.confirm(summary);
        }
        if (!proceed) return;

        // Spinner
        const originalHTML = confirmBtn.innerHTML;
        confirmBtn.disabled = true;
        confirmBtn.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Applying...';

        try {
            const res = await fetch(
                `/admin/transactions/${txId}/reject-return`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getToken(),
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                    credentials: "same-origin",
                    body: JSON.stringify({
                        reason: reason.trim(),
                        damage_fee: damageFee,
                    }),
                }
            );

            // Try JSON first, fallback to text
            let data = null;
            const ct = res.headers.get("content-type") || "";
            if (ct.includes("application/json")) {
                data = await res.json().catch(() => null);
            } else {
                const text = await res.text().catch(() => "");
                data = { message: text };
            }

            if (res.ok) {
                damageConfirmed = true;
                // Close modals
                const damageModalEl =
                    document.getElementById("damageReturnModal");
                const bookModalEl = document.getElementById("bookModal");
                if (window.bootstrap && damageModalEl) {
                    const damageModal =
                        bootstrap.Modal.getInstance(damageModalEl) ||
                        new bootstrap.Modal(damageModalEl);
                    damageModal.hide();
                }
                if (window.bootstrap && bookModalEl) {
                    const bookModal =
                        bootstrap.Modal.getInstance(bookModalEl) ||
                        new bootstrap.Modal(bookModalEl);
                    bookModal.hide();
                }
                alert(
                    (data && data.message) ||
                        "Return rejected - damage fee applied"
                );
                window.location.reload();
            } else {
                const msg =
                    (data && data.message) ||
                    (res.status === 419
                        ? "Session expired (CSRF mismatch). Please refresh and try again."
                        : res.status === 403
                        ? "Unauthorized. Please log in as admin."
                        : "Failed to apply damage. Please try again.");
                if (typeof showError === "function")
                    await showError(msg, "Error");
                else alert(msg);
            }
        } catch (err) {
            console.error(err);
            alert("An error occurred. Please try again.");
        } finally {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalHTML;
        }
    });
})();
