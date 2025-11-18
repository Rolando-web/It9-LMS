(function () {
    const container = document.getElementById("booksListContainer");
    const form = document.querySelector('form[action*="books"]');
    const categorySelect = document.getElementById("categoryFilter");
    const searchInput = form
        ? form.querySelector('input[name="search"]')
        : null;

    if (!container || !form) return;

    let debounceTimer = null;

    function buildUrl(baseUrl, params) {
        const url = new URL(baseUrl, window.location.origin);
        Object.keys(params).forEach((k) => {
            if (
                params[k] !== undefined &&
                params[k] !== null &&
                params[k] !== ""
            ) {
                url.searchParams.set(k, params[k]);
            } else {
                url.searchParams.delete(k);
            }
        });
        return url.toString();
    }

    async function loadBooks(url) {
        try {
            const res = await fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });
            const html = await res.text();
            container.innerHTML = html;
            attachPaginationHandlers();
        } catch (err) {
            console.error("Failed to load books:", err);
        }
    }

    function onSearchInput() {
        if (!searchInput) return;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const base = form.getAttribute("action");
            const params = {
                category: categorySelect ? categorySelect.value : undefined,
                search: searchInput.value || "",
            };
            const url = buildUrl(base, params);
            loadBooks(url);
        }, 300);
    }

    function attachPaginationHandlers() {
        const links = container.querySelectorAll("a.page-link");
        links.forEach((a) => {
            a.addEventListener("click", function (e) {
                e.preventDefault();
                const url = this.getAttribute("href");
                if (!url) return;
                // Ensure we keep current search/category values by relying on server-appended links.
                loadBooks(url);
            });
        });
    }

    // Bind search input for AJAX
    if (searchInput) {
        searchInput.addEventListener("input", onSearchInput);
    }

    // Initial bind for current pagination links
    attachPaginationHandlers();
})();
