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
            // TODO: call backend to create borrow transaction. For now, show success UI.
            borrowModal.classList.add("hidden");
            if (successModal) successModal.classList.remove("hidden");
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
