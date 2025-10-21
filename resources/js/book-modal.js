document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editBtn");

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const title = this.getAttribute("data-title");
            const author = this.getAttribute("data-author");
            const category = this.getAttribute("data-category");
            const isbn = this.getAttribute("data-isbn");
            const publishDate = this.getAttribute("data-publish_date");
            const copies = this.getAttribute("data-copies");
            const image = this.getAttribute("data-image");

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_title").value = title;
            document.getElementById("edit_author").value = author;
            document.getElementById("edit_category").value = category;
            document.getElementById("edit_isbn").value = isbn;
            document.getElementById("edit_publish_date").value = publishDate;
            document.getElementById("edit_copies").value = copies;

            const previewImg = document.getElementById("edit_preview");
            const previewPlaceholder = document.getElementById(
                "edit_preview_placeholder"
            );

            if (image && image !== "") {
                previewImg.src = image;
                previewImg.style.display = "block";
                if (previewPlaceholder) {
                    previewPlaceholder.style.display = "none";
                }
            } else {
                previewImg.style.display = "none";
                if (previewPlaceholder) {
                    previewPlaceholder.style.display = "block";
                }
            }
        });
    });
});
