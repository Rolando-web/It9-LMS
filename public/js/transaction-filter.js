// Filter transactions by status
const statusFilter = document.getElementById("statusFilter");
const clearFilterBtn = document.getElementById("clearFilter");

function applyFilter() {
    const filterValue = statusFilter.value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");
    let visibleCount = 0;

    // Show/hide clear button
    if (filterValue === "") {
        clearFilterBtn.classList.add("hidden");
    } else {
        clearFilterBtn.classList.remove("hidden");
    }

    rows.forEach((row) => {
        // Skip empty state row
        if (row.querySelector("td[colspan]")) {
            return;
        }

        const statusCell = row.querySelector("td:nth-child(7)"); // Status column
        if (!statusCell) return;

        const statusText = statusCell.textContent.trim().toLowerCase();

        // Check if the row matches the filter
        if (
            filterValue === "" ||
            statusText.includes(filterValue.replace("_", " "))
        ) {
            row.style.display = "";
            visibleCount++;
        } else {
            row.style.display = "none";
        }
    });

    // Show/hide empty state message
    const tbody = document.querySelector("tbody");
    let emptyRow = tbody.querySelector(".filter-empty-state");

    if (visibleCount === 0 && filterValue !== "") {
        if (!emptyRow) {
            const displayStatus = filterValue
                .replace("_", " ")
                .replace(/\b\w/g, (l) => l.toUpperCase());
            emptyRow = document.createElement("tr");
            emptyRow.className = "filter-empty-state";
            emptyRow.innerHTML = `
                    <td colspan="9" class="px-4 py-8 text-center text-gray-400">
                        <i class="bi bi-inbox text-4xl mb-2 block"></i>
                        <p class="mb-2">No transactions found with status: <strong class="text-white">${displayStatus}</strong></p>
                        <button onclick="document.getElementById('clearFilter').click()" 
                                class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-cyan-500/10 border border-cyan-500/20 text-cyan-500 rounded-lg hover:bg-cyan-500/20 transition-all text-sm">
                            <i class="bi bi-x-circle"></i>
                            Clear filter
                        </button>
                    </td>
                `;
            tbody.appendChild(emptyRow);
        }
    } else if (emptyRow) {
        emptyRow.remove();
    }

    // Update page info text if exists
    const pageInfo = document.querySelector(".text-sm.text-gray-400");
    if (pageInfo && filterValue !== "") {
        pageInfo.innerHTML = `Showing <span class="font-semibold text-white">${visibleCount}</span> filtered results`;
    }
}

statusFilter.addEventListener("change", applyFilter);

// Clear filter button
clearFilterBtn.addEventListener("click", function () {
    statusFilter.value = "";
    applyFilter();
});

// Preserve filter on page load if there's a URL parameter
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");
    if (status) {
        statusFilter.value = status;
        applyFilter();
    }
});
