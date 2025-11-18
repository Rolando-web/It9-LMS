(function () {
    const payModal = document.getElementById("payModal");
    if (!payModal) return;

    const closeBtn = document.getElementById("closePayModal");
    const cancelBtn = document.getElementById("cancelPay");
    const confirmBtn = document.getElementById("confirmPay");
    const amountEl = document.getElementById("payAmount");
    const txIdEl = document.getElementById("payTxId");
    const methodHint = document.getElementById("methodHint");
    const txModalEl = document.getElementById("bookModal");
    let selectedMethod = null;
    let restoreTxModalOnClose = false;

    function openPayModal(txId, amount) {
        console.log(
            "Opening payment modal for transaction:",
            txId,
            "amount:",
            amount
        );
        txIdEl.textContent = txId || "—";
        const amt = Math.max(0, parseFloat(amount || 0));
        amountEl.textContent = (isNaN(amt) ? 0 : amt).toFixed(2);
        selectedMethod = null;
        confirmBtn.disabled = true;
        confirmBtn.classList.add("bg-emerald-600/60", "cursor-not-allowed");
        confirmBtn.classList.remove("bg-emerald-600");
        methodHint.textContent = "Choose a method to continue.";
        document.querySelectorAll(".pay-method-btn").forEach((btn) => {
            btn.classList.remove("border-emerald-500");
        });
        payModal.classList.remove("hidden");
        console.log(
            "Payment modal opened, buttons found:",
            document.querySelectorAll(".pay-method-btn").length
        );
    }

    function closePay(reason) {
        payModal.classList.add("hidden");
        // If opened from transaction modal and user canceled/closed (not success), reopen it
        if (restoreTxModalOnClose && reason !== "success") {
            try {
                if (window.bootstrap && txModalEl) {
                    const inst =
                        window.bootstrap.Modal.getInstance(txModalEl) ||
                        new window.bootstrap.Modal(txModalEl);
                    inst.show();
                }
            } catch (e) {
                console.warn("Failed to reopen transaction modal:", e);
            } finally {
                restoreTxModalOnClose = false;
            }
        } else {
            restoreTxModalOnClose = false;
        }
    }

    // Expose open method globally
    window.__openPayModal = openPayModal;

    // Wire Pay Now trigger from transaction modal and summary card
    document.addEventListener("click", function (e) {
        const btn =
            (e.target.closest && e.target.closest("#payNowBtn")) ||
            (e.target.closest && e.target.closest(".pay-now-btn"));
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        const txId = btn.getAttribute("data-tx-id");
        const fee = btn.getAttribute("data-fee");

        // If launched from inside the Bootstrap transaction modal, hide it and remember to restore on cancel
        const launchedFromTxModal = !!(
            txModalEl &&
            btn.closest &&
            btn.closest("#bookModal")
        );

        console.log(
            "Pay Now clicked - launched from TX modal:",
            launchedFromTxModal
        );

        if (launchedFromTxModal) {
            restoreTxModalOnClose = true;

            // Hide transaction modal first
            if (window.bootstrap && txModalEl) {
                const inst = window.bootstrap.Modal.getInstance(txModalEl);
                console.log("Bootstrap Modal instance:", inst);

                if (inst) {
                    console.log("Hiding transaction modal...");
                    // Wait for modal to be fully hidden before opening payment modal
                    txModalEl.addEventListener(
                        "hidden.bs.modal",
                        function onHidden() {
                            console.log(
                                "Transaction modal hidden, opening payment modal"
                            );
                            openPayModal(txId, fee);
                        },
                        { once: true }
                    );
                    inst.hide();
                } else {
                    console.log(
                        "No Bootstrap modal instance, opening payment modal directly"
                    );
                    openPayModal(txId, fee);
                }
            } else {
                console.log(
                    "Bootstrap not available, opening payment modal directly"
                );
                restoreTxModalOnClose = false;
                openPayModal(txId, fee);
            }
        } else {
            console.log(
                "Not from transaction modal, opening payment modal directly"
            );
            restoreTxModalOnClose = false;
            openPayModal(txId, fee);
        }
    });
    [closeBtn, cancelBtn].forEach(
        (el) =>
            el &&
            el.addEventListener("click", function () {
                closePay("cancel");
            })
    );
    payModal.addEventListener("click", function (e) {
        // Handle payment method selection
        const btn = e.target.closest(".pay-method-btn");
        if (btn) {
            console.log(
                "Payment method clicked:",
                btn.getAttribute("data-method")
            );
            document.querySelectorAll(".pay-method-btn").forEach((b) => {
                b.classList.remove("border-emerald-500");
            });
            btn.classList.add("border-emerald-500");
            selectedMethod = btn.getAttribute("data-method");
            console.log("Selected method:", selectedMethod);
            methodHint.textContent = selectedMethod
                ? "Selected: " + selectedMethod.toUpperCase()
                : "Choose a method to continue.";
            confirmBtn.disabled = !selectedMethod;
            if (selectedMethod) {
                confirmBtn.classList.remove(
                    "bg-emerald-600/60",
                    "cursor-not-allowed"
                );
                confirmBtn.classList.add("bg-emerald-600");
            }
            return;
        }

        // Handle backdrop click to close
        if (e.target === payModal) closePay("cancel");
    });

    // Confirm payment via PayMongo
    confirmBtn &&
        confirmBtn.addEventListener("click", async function () {
            if (!selectedMethod) return;

            const txId = txIdEl.textContent;
            const amount = parseFloat(amountEl.textContent);

            if (!txId || txId === "—" || isNaN(amount) || amount <= 0) {
                await showError(
                    "Invalid payment details. Please try again.",
                    "Invalid Payment"
                );
                return;
            }

            confirmBtn.disabled = true;
            confirmBtn.textContent = "Processing...";

            const csrf = document.querySelector('meta[name="csrf-token"]');
            const token = csrf ? csrf.getAttribute("content") : "";

            fetch("/payment/create", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    transaction_id: txId,
                    amount: amount,
                    payment_method: selectedMethod,
                }),
            })
                .then(async (res) => {
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(
                            data.message || "Payment creation failed"
                        );
                    }
                    return data;
                })
                .then(async (data) => {
                    console.log("Payment response:", data);
                    if (data.checkout_url) {
                        // Redirect to PayMongo checkout page
                        window.location.href = data.checkout_url;
                    } else {
                        await showError(
                            data.message ||
                                "No checkout URL received. Please contact support.",
                            "Payment Error"
                        );
                        confirmBtn.disabled = false;
                        confirmBtn.textContent = "Confirm Payment";
                    }
                })
                .catch(async (err) => {
                    console.error("Payment error:", err);
                    await showError(
                        err.message || "An error occurred. Please try again.",
                        "Error"
                    );
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = "Confirm Payment";
                });
        });
})();
