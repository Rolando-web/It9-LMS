(function () {
    "use strict";

    // Wait for DOM to be ready
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Return modal JS loaded");
        console.log("Bootstrap available:", typeof bootstrap !== "undefined");

        const modal = document.getElementById("rejectReturnModal");
        console.log("Modal element found:", modal !== null);

        const rejectBtns = document.querySelectorAll(".reject-return-btn");
        console.log("Reject buttons found:", rejectBtns.length);

        // Add manual click tracking
        rejectBtns.forEach((btn, index) => {
            btn.addEventListener("click", function (e) {
                console.log(`Reject button ${index + 1} clicked!`);
                console.log("Button data:", {
                    toggle: this.getAttribute("data-bs-toggle"),
                    target: this.getAttribute("data-bs-target"),
                    txId: this.getAttribute("data-tx-id"),
                });
            });
        });

        // Create test function to manually open modal
        window.testRejectModal = function (txId) {
            console.log("Testing reject modal with txId:", txId || "123");
            const rejectModal = document.getElementById("rejectReturnModal");
            if (!rejectModal) {
                console.error("Modal not found!");
                return;
            }

            document.getElementById("rejectTransactionId").value =
                txId || "123";
            document.getElementById("rejectReason").value = "";
            document.getElementById("damageFee").value = "50.00";

            const modalInstance = new bootstrap.Modal(rejectModal);
            modalInstance.show();
            console.log("Modal opened!");
        };

        console.log("Type testRejectModal() in console to test");

        // Handle Approve Return Button (both from table and modal)
        document.addEventListener("click", function (e) {
            if (
                !e.target.closest(".approve-return-btn") &&
                !e.target.closest(".approve-return-btn-modal")
            )
                return;

            const btn =
                e.target.closest(".approve-return-btn") ||
                e.target.closest(".approve-return-btn-modal");
            const txId = btn.getAttribute("data-tx-id");

            if (
                !confirm(
                    "Approve this book return? The book will be marked as returned."
                )
            ) {
                return;
            }

            btn.disabled = true;
            btn.innerHTML =
                '<i class="bi bi-hourglass-split me-1"></i>Processing...';

            fetch("/admin/transactions/" + txId + "/approve-return", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": getCsrfToken(),
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Close transaction modal if it's open
                    const transactionModal =
                        document.getElementById("bookModal");
                    if (transactionModal) {
                        const transactionModalInstance =
                            bootstrap.Modal.getInstance(transactionModal);
                        if (transactionModalInstance) {
                            transactionModalInstance.hide();
                        }
                    }

                    alert(data.message || "Return approved successfully!");
                    window.location.reload();
                })
                .catch((error) => {
                    alert("Error: " + error.message);
                    btn.disabled = false;
                    btn.innerHTML =
                        '<i class="bi bi-check-circle me-1"></i>Approve';
                });
        });

        // Handle Reject Button Click from Modal - Open Reject Modal
        document.addEventListener("click", function (e) {
            if (!e.target.closest(".reject-return-btn-modal")) return;

            console.log("Reject button from modal clicked!");

            const btn = e.target.closest(".reject-return-btn-modal");
            const txId = btn.getAttribute("data-tx-id");

            console.log("Transaction ID:", txId);

            // Close the transaction details modal first
            const transactionModal = document.getElementById("bookModal");
            if (transactionModal) {
                const transactionModalInstance =
                    bootstrap.Modal.getInstance(transactionModal);
                if (transactionModalInstance) {
                    console.log("Hiding transaction modal...");
                    transactionModalInstance.hide();
                }
            }

            // Open reject modal after a short delay
            setTimeout(function () {
                console.log("Opening reject modal...");
                const rejectModal =
                    document.getElementById("rejectReturnModal");

                if (!rejectModal) {
                    console.error("Reject modal not found!");
                    return;
                }

                // Set transaction ID
                document.getElementById("rejectTransactionId").value = txId;
                document.getElementById("rejectReason").value = "";
                document.getElementById("damageFee").value = "50.00";

                // Create and show modal
                const rejectModalInstance = new bootstrap.Modal(rejectModal);
                rejectModalInstance.show();
                console.log("Reject modal should be visible now");
            }, 400);
        });

        // Handle Reject Button Click - Open Modal
        const rejectModal = document.getElementById("rejectReturnModal");

        if (rejectModal) {
            rejectModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                const txId = button.getAttribute("data-tx-id");

                // Set transaction ID in modal
                document.getElementById("rejectTransactionId").value = txId;
                document.getElementById("rejectReason").value = "";
                document.getElementById("damageFee").value = "50.00";
            });
        }

        // Handle Confirm Reject Button in Modal
        const confirmRejectBtn = document.getElementById("confirmRejectBtn");

        if (confirmRejectBtn) {
            confirmRejectBtn.addEventListener("click", function () {
                const txId = document.getElementById(
                    "rejectTransactionId"
                ).value;
                const reason = document.getElementById("rejectReason").value;
                const damageFee = document.getElementById("damageFee").value;

                if (!reason) {
                    alert("Please enter a rejection reason");
                    return;
                }

                confirmRejectBtn.disabled = true;
                confirmRejectBtn.innerHTML =
                    '<i class="bi bi-hourglass-split me-1"></i>Processing...';

                fetch("/admin/transactions/" + txId + "/reject-return", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCsrfToken(),
                    },
                    body: JSON.stringify({
                        reason: reason,
                        damage_fee: parseFloat(damageFee),
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        // Close modal
                        const modalInstance =
                            bootstrap.Modal.getInstance(rejectModal);
                        if (modalInstance) modalInstance.hide();

                        alert(data.message || "Return rejected successfully!");
                        window.location.reload();
                    })
                    .catch((error) => {
                        alert("Error: " + error.message);
                        confirmRejectBtn.disabled = false;
                        confirmRejectBtn.innerHTML =
                            '<i class="bi bi-check-circle me-1"></i>Confirm Rejection';
                    });
            });
        }
    });
})();
