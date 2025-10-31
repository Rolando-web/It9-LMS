document.addEventListener("DOMContentLoaded", function () {
    const borrowModal = document.getElementById("borrowModal");
    const successModal = document.getElementById("successModal");
    const errorModal = document.getElementById("errorModal");

    if (!borrowModal) return; // no modal on the page

    const borrowBookTitle = document.getElementById("borrowBookTitle");
    const borrowBookAuthor = document.getElementById("borrowBookAuthor");
    const borrowBookImage = document.getElementById("borrowBookImage");
    const borrowDuration = document.getElementById("borrowDuration");
    const returnDate = document.getElementById("returnDate");
    const cancelBorrow = document.getElementById("cancelBorrow");
    const confirmBorrow = document.getElementById("confirmBorrow");
    const closeSuccess = document.getElementById("closeSuccess");

    function addDaysToDate(days) {
        const d = new Date();
        d.setDate(d.getDate() + Number(days));
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth() + 1).padStart(2, "0");
        const dd = String(d.getDate()).padStart(2, "0");
        return `${yyyy}-${mm}-${dd}`;
    }

    function openBorrowModalFromCard(card) {
        if (!card) return;
        const title =
            card.dataset.title ||
            (card.querySelector("h3")
                ? card.querySelector("h3").innerText.trim()
                : "Unknown");
        const author =
            card.dataset.author ||
            (card.querySelector("p")
                ? card.querySelector("p").innerText.trim()
                : "Unknown");
        const image =
            card.dataset.image ||
            (card.querySelector("img") ? card.querySelector("img").src : null);
        const bookId =
            card.dataset.bookId ||
            (card.querySelector('input[name="book_id"]')
                ? card.querySelector('input[name="book_id"]').value
                : "0");

        if (borrowBookTitle) borrowBookTitle.innerText = title;
        if (borrowBookAuthor) borrowBookAuthor.innerText = author;
        if (borrowDuration) {
            if (!borrowDuration.value) borrowDuration.value = "3";
            if (returnDate)
                returnDate.value = addDaysToDate(borrowDuration.value);
        }

        if (borrowBookImage && image) {
            borrowBookImage.src = image;
            borrowBookImage.alt = title;
        }

        // optionally store selected book id for confirm step
        borrowModal.dataset.currentBookId = bookId;

        borrowModal.classList.remove("hidden");
    }

    // Delegated click for any Borrow button
    document.addEventListener("click", function (e) {
        const btn = e.target.closest && e.target.closest(".openBorrowModal");
        if (btn) {
            const card = btn.closest(".book-card");
            openBorrowModalFromCard(card);
        }
    });

    if (borrowDuration) {
        borrowDuration.addEventListener("change", function () {
            if (returnDate) returnDate.value = addDaysToDate(this.value);
        });
    }

    if (cancelBorrow) {
        cancelBorrow.addEventListener("click", function () {
            borrowModal.classList.add("hidden");
        });
    }

    if (confirmBorrow) {
        confirmBorrow.addEventListener("click", function () {
            // call backend to create borrow transaction
            const bookId = borrowModal.dataset.currentBookId || 0;
            const duration = borrowDuration ? borrowDuration.value : 3;
            const due = returnDate ? returnDate.value : null;

            if (!bookId) {
                const err = document.getElementById("errorMessage");
                if (err) err.innerText = "No book selected.";
                document
                    .getElementById("errorModal")
                    .classList.remove("hidden");
                return;
            }

            fetch("/borrow", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": window.Laravel
                        ? window.Laravel.csrfToken
                        : "",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({
                    book_id: bookId,
                    duration: duration,
                    due_date: due,
                }),
                credentials: "same-origin",
            })
                .then(async (res) => {
                    const contentType = res.headers.get("content-type") || "";
                    let body = null;
                    if (contentType.indexOf("application/json") !== -1) {
                        try {
                            body = await res.json();
                        } catch (e) {
                            body = null;
                        }
                    } else {
                        // not JSON (likely an HTML login/CSRF error page) — capture text for display
                        try {
                            body = await res.text();
                        } catch (e) {
                            body = null;
                        }
                    }

                    if (res.ok) {
                        borrowModal.classList.add("hidden");
                        if (successModal)
                            successModal.classList.remove("hidden");
                        setTimeout(() => location.reload(), 800);
                    } else {
                        const errEl = document.getElementById("errorMessage");
                        // prefer JSON message, else plain text or generic
                        let msg = "Unable to borrow";
                        if (body && typeof body === "object" && body.message)
                            msg = body.message;
                        else if (body && typeof body === "string") {
                            // if it's HTML, try to extract a short message, otherwise show generic
                            const stripped = body
                                .replace(/<[^>]*>?/gm, "")
                                .trim();
                            msg = stripped.length
                                ? stripped.length > 300
                                    ? stripped.slice(0, 300) + "..."
                                    : stripped
                                : msg;
                        }
                        if (errEl) errEl.innerText = msg;
                        document
                            .getElementById("errorModal")
                            .classList.remove("hidden");
                    }
                })
                .catch((err) => {
                    const em = document.getElementById("errorMessage");
                    if (em) em.innerText = err.message || "Network error";
                    document
                        .getElementById("errorModal")
                        .classList.remove("hidden");
                });
        });
    }

    if (closeSuccess) {
        closeSuccess.addEventListener("click", function () {
            if (successModal) successModal.classList.add("hidden");
        });
    }

    // close modals by clicking overlay
    borrowModal.addEventListener("click", function (e) {
        if (e.target === borrowModal) borrowModal.classList.add("hidden");
    });
    if (successModal) {
        successModal.addEventListener("click", function (e) {
            if (e.target === successModal) successModal.classList.add("hidden");
        });
    }
});
