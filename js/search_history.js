$(function () {
    initializeSearchHistory({
        inputId: "searchInput",
        historyId: "searchHistory",
        localStorageKey: "searchHistory",
        filterButtonClass: "filter-button header",
        onSelect: function (query) {
            console.log("Searching in header:", query);
            if (typeof window.history_searching === "function") {
                window.history_searching(query);
            }
        }
    });
});

window.history_searching = function (query) {
    const url = query.trim() === ''
        ? `${BASE_URL}search/all`
        : `${BASE_URL}search/${encodeURIComponent(query)}`;
    window.location.href = url;
};
