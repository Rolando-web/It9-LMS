// Handle transaction modal data population
document.addEventListener("DOMContentLoaded", function () {
    const viewButtons = document.querySelectorAll(".view-transaction-btn");

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
            document.getElementById("downloadReceiptBtn").href =
                "/admin/transaction/" + txId + "/receipt";

            // Update status box and return date box colors based on status
            const statusBox = document.getElementById("modalStatusBox");
            const statusLabel = document.getElementById("modalStatusLabel");
            const statusText = document.getElementById("modalStatus");
            const returnDateBox = document.getElementById("modalReturnDateBox");
            const returnDateText = document.getElementById("modalReturnDate");

            // Remove all color classes
            statusBox.className = "rounded-lg p-3 border";
            statusLabel.className = "text-xs mb-1";
            statusText.className = "font-bold text-lg";
            returnDateBox.className = "rounded-lg p-3 border";
            returnDateText.className = "font-bold text-lg";

            // Add appropriate color based on status
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
                statusBox.classList.add("bg-red-500/10", "border-red-500/20");
                statusLabel.classList.add("text-red-500");
                statusText.classList.add("text-red-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "borrowed") {
                statusBox.classList.add("bg-blue-500/10", "border-blue-500/20");
                statusLabel.classList.add("text-blue-500");
                statusText.classList.add("text-blue-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "pending") {
                statusBox.classList.add(
                    "bg-amber-500/10",
                    "border-amber-500/20"
                );
                statusLabel.classList.add("text-amber-500");
                statusText.classList.add("text-amber-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else if (status.toLowerCase() === "rejected") {
                statusBox.classList.add("bg-gray-500/10", "border-gray-500/20");
                statusLabel.classList.add("text-gray-500");
                statusText.classList.add("text-gray-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            } else {
                statusBox.classList.add("bg-gray-500/10", "border-gray-500/20");
                statusLabel.classList.add("text-gray-500");
                statusText.classList.add("text-gray-500");
                returnDateBox.classList.add(
                    "bg-gray-500/10",
                    "border-gray-500/20"
                );
                returnDateText.classList.add("text-gray-400");
            }
        });
    });
});
