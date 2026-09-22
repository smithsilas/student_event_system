// =========================================================
// Records page: live search/filter + dynamic "total" count
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const table = document.getElementById("recordsTable");
    const totalCount = document.getElementById("totalCount");
    const noResultsMsg = document.getElementById("noResultsMsg");

    if (!searchInput || !table) return;

    const rows = Array.from(table.querySelectorAll("tbody tr"));
    const originalTotal = rows.filter(r => r.children.length > 1).length;

    searchInput.addEventListener("keyup", function () {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        rows.forEach(row => {
            // Skip the "no registrations yet" placeholder row
            if (row.children.length <= 1) return;

            const rowText = row.textContent.toLowerCase();
            const isMatch = rowText.includes(query);
            row.style.display = isMatch ? "" : "none";
            if (isMatch) visibleCount++;
        });

        totalCount.textContent = query === "" ? originalTotal : visibleCount;
        noResultsMsg.style.display = (visibleCount === 0 && query !== "") ? "block" : "none";
    });
});
