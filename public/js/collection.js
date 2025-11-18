// Book Collection Dynamic Loading and Filtering
(function () {
    // Get initial pagination data from data attributes
    const paginationData = document.getElementById("booksGrid")?.dataset;
    let currentPage = parseInt(paginationData?.currentPage || "1");
    let lastPage = parseInt(paginationData?.lastPage || "1");
    const perPage = parseInt(paginationData?.perPage || "8");

    const loadMoreBtn = document.getElementById("loadMoreBtn");
    const booksGrid = document.getElementById("booksGrid");
    const searchInput = document.getElementById("searchInput");
    const categoryInput = document.getElementById("categoryInput");
    const sortSelect = document.getElementById("sortSelect");
    const filterButtons = document.querySelectorAll(".filter-btn");

    if (!booksGrid || !loadMoreBtn) return;

    function buildQuery(page = 1) {
        const params = new URLSearchParams();
        params.set("page", page);
        params.set("per_page", perPage);
        const s =
            searchInput && searchInput.value ? searchInput.value.trim() : "";
        const c =
            categoryInput && categoryInput.value ? categoryInput.value : "";
        const so = sortSelect && sortSelect.value ? sortSelect.value : "";
        if (s) params.set("search", s);
        if (c) params.set("category", c);
        if (so) params.set("sort", so);
        return params.toString();
    }

    function updateActiveButtons() {
        const active =
            categoryInput && categoryInput.value ? categoryInput.value : "";
        filterButtons.forEach((btn) => {
            const cat = btn.dataset.category || "";
            if ((active === "" || active === "all") && cat === "all") {
                btn.classList.remove("bg-gray-700", "text-gray-300");
                btn.classList.add("bg-gray-600", "text-white");
            } else if (active === cat) {
                btn.classList.remove("bg-gray-700", "text-gray-300");
                btn.classList.add("bg-gray-600", "text-white");
            } else {
                btn.classList.remove("bg-gray-600", "text-white");
                btn.classList.add("bg-gray-700", "text-gray-300");
            }
        });
    }

    function renderItems(items, replace = false) {
        if (replace) booksGrid.innerHTML = "";
        items.forEach((item) => {
            const el = document.createElement("div");
            el.className =
                "book-card bg-gray-800 rounded-xl p-2 hover:bg-gray-750 transition-colors group";
            el.innerHTML = `
            <div class="bg-gray-800 rounded-xl p-6 hover:bg-gray-750 transition-colors group ">
              <div class="mb-4">
                <div class="w-full h-48 bg-gradient-to-br from-slate-600 to-slate-800 rounded-lg flex items-center justify-center mb-4 relative overflow-hidden">
                  <img src="${item.image}" alt="${
                item.title
            }" class="w-full h-full object-cover rounded-lg">
                </div>
              </div>
              <div class="space-y-2">
                <h3 class="text-white font-medium text-lg leading-tight">${
                    item.title
                }</h3>
                <p class="text-gray-400 text-sm">${item.author}</p>
                <div class="flex items-center space-x-2">
                  <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-yellow-400 text-sm font-medium">4.8</span>
                                        <span class="text-gray-500 text-sm">${
                                            item.publish_year || ""
                                        }</span>
                                        ${
                                            item.copies <= 0
                                                ? '<span class="text-red-500 text-sm font-semibold ml-2">OUT OF STOCK</span>'
                                                : ""
                                        }
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="book_id" value="${item.id}">
            <div class="flex justify-center">
              ${
                  item.is_borrowed
                      ? '<button type="button" disabled class="w-full bg-gray-600 text-gray-400 py-2 px-3 rounded-lg text-sm font-medium mb-2 cursor-not-allowed">Already Borrowed</button>'
                      : item.copies <= 0
                      ? `<button type="button" class="findSimilarBtn w-full bg-white hover:bg-gray-100 text-gray-900 py-2 px-3 rounded-lg text-sm font-medium transition-colors mb-2" data-category="${
                            item.category || ""
                        }">Find Similar Book</button>`
                      : '<button type="button" class="openBorrowModal w-full bg-gray-700 hover:bg-gray-600 text-white py-2 px-3 rounded-lg text-sm font-medium transition-colors mb-2">Borrow Book</button>'
              }
            </div>
          `;
            booksGrid.appendChild(el);
        });
    }

    async function fetchPage(page = 1, replace = false) {
        if (!loadMoreBtn) return;
        if (page === 1) {
            // when replacing, show loading state on top-level button
            loadMoreBtn.disabled = true;
            loadMoreBtn.querySelector("span").textContent = "Loading...";
        }

        try {
            const qs = buildQuery(page);
            const res = await fetch(`/books/load-more?${qs}`);
            if (!res.ok) throw new Error("Network response was not ok");
            const json = await res.json();
            const items = json.data || [];

            if (replace) {
                renderItems(items, true);
            } else {
                renderItems(items, false);
            }

            // handle empty state when replacing (search/filter) or when no items returned
            const emptyState = document.getElementById("emptyState");
            if (items.length === 0) {
                if (emptyState) emptyState.classList.remove("hidden");
                if (loadMoreBtn) loadMoreBtn.style.display = "none";
            } else {
                if (emptyState) emptyState.classList.add("hidden");
            }

            currentPage = json.current_page || page;
            lastPage = json.last_page || lastPage;

            if (currentPage >= lastPage) {
                loadMoreBtn.style.display = "none";
            } else {
                loadMoreBtn.style.display = "";
            }
        } catch (err) {
            console.error(err);
            await showError("Failed to load books.", "Error");
        } finally {
            if (loadMoreBtn.style.display !== "none") {
                loadMoreBtn.disabled = false;
                loadMoreBtn.querySelector("span").textContent =
                    "Load More Books";
            }
        }
    }

    function debounce(fn, wait) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    if (currentPage >= lastPage) {
        loadMoreBtn.style.display = "none";
    }

    loadMoreBtn &&
        loadMoreBtn.addEventListener("click", function (e) {
            e.preventDefault();
            const next = currentPage + 1;
            fetchPage(next, false);
        });

    filterButtons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            const cat = btn.dataset.category || "";
            categoryInput.value = cat;
            updateActiveButtons();
            fetchPage(1, true);
        });
    });

    if (searchInput) {
        searchInput.addEventListener(
            "input",
            debounce(function () {
                fetchPage(1, true);
            }, 350)
        );
    }

    if (sortSelect) {
        sortSelect.addEventListener("change", function () {
            fetchPage(1, true);
        });
    }

    window.submitForm = function (cat) {
        if (categoryInput) categoryInput.value = cat;
        updateActiveButtons();
        fetchPage(1, true);
    };

    updateActiveButtons();

    // Delegate click for Find Similar Book to auto-apply category filter
    booksGrid.addEventListener("click", function (e) {
        const btn = e.target.closest && e.target.closest(".findSimilarBtn");
        if (!btn) return;
        const cat = btn.getAttribute("data-category") || "";
        if (categoryInput) categoryInput.value = cat;
        updateActiveButtons();
        fetchPage(1, true);
        // Optionally scroll to top of grid after applying filter
        try {
            booksGrid.scrollIntoView({ behavior: "smooth", block: "start" });
        } catch (_) {}
    });
})();
