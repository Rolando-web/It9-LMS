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
