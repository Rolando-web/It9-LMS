document.addEventListener("click", function (e) {
    const btn =
        e.target.closest(".approve-btn") || e.target.closest(".reject-btn");
    if (!btn) return;

    const id = btn.dataset.txId;
    const action = btn.dataset.action;
    if (!id || !action) return;

    if (!confirm(`Are you sure you want to ${action} this transaction?`))
        return;

    btn.disabled = true;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/admin/transactions/${id}/${action}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": token,
        },
    })
        .then((res) => res.json())
        .then((data) => {
            alert(data.message || `Transaction ${action}ed successfully`);
            window.location.reload();
        })
        .catch((err) => {
            alert("Error: " + (err.message || "Network error"));
            btn.disabled = false;
        });
});
