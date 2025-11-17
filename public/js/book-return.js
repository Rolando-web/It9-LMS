function getToastContainer() {
    let c = document.getElementById("toast-container");
    if (!c) {
        c = document.createElement("div");
        c.id = "toast-container";
        c.className = "fixed top-4 right-4 z-50 space-y-2 pointer-events-none";
        document.body.appendChild(c);
    }
    return c;
}

function showToast(message, type = "success") {
    const container = getToastContainer();
    const color =
        type === "success"
            ? "bg-green-600"
            : type === "warn"
            ? "bg-yellow-600"
            : "bg-red-600";
    const toast = document.createElement("div");
    toast.setAttribute("role", "status");
    toast.className = `${color} text-white px-4 py-2 rounded shadow-lg text-sm pointer-events-auto opacity-0 translate-x-4 transform transition-all duration-200`;
    toast.textContent = message;
    container.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove("opacity-0", "translate-x-4");
        toast.classList.add("opacity-100", "translate-x-0");
    });

    setTimeout(() => {
        toast.classList.add("opacity-0", "translate-x-4");
        setTimeout(() => toast.remove(), 200);
    }, 2500);
}

document.addEventListener("click", async function (e) {
    const btn = e.target.closest(".return-btn");
    if (!btn) return;

    const id = btn.dataset.txId;
    const card = btn.closest(".group");
    const statusChip = card ? card.querySelector(".status-chip") : null;

    if (!confirm("Request a return for this book?")) return;

    const originalHTML = btn.innerHTML;
    btn.disabled = true;
    btn.classList.add("opacity-70", "cursor-not-allowed");
    btn.innerHTML =
        '<span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2 align-middle"></span>Submitting...';

    const tokenEl = document.querySelector('meta[name="csrf-token"]');
    const token = tokenEl ? tokenEl.content : "";

    try {
        const res = await fetch(`/return/${id}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": token,
                Accept: "application/json",
            },
            credentials: "same-origin",
        });

        const data = await res.json().catch(() => ({}));
        if (!res.ok) {
            throw new Error(data.message || "Failed to process return");
        }

        // Smooth in-place UI update: mark as Return Pending
        if (statusChip) {
            statusChip.textContent = "Return Pending";
            statusChip.className =
                "status-chip py-1 rounded text-md text-yellow-500";
        }
        btn.innerHTML = "Return Requested";
        btn.classList.remove("bg-red-600", "hover:bg-red-500");
        btn.classList.add("bg-gray-700");

        showToast(data.message || "Return request submitted.");
    } catch (err) {
        showToast(err.message || "Network error", "error");
        btn.disabled = false;
        btn.classList.remove("opacity-70", "cursor-not-allowed");
        btn.innerHTML = originalHTML;
    }
});
