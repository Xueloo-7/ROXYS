initializeSearchHistory({
    inputId: "searchInput",
    historyId: "searchHistory",
    localStorageKey: "searchHistory",
    filterButtonClass: "filter-button.header",
    onSelect: function (query) {
        console.log("Searching in header:", query);
        if (typeof window.history_searching === "function") {
            window.history_searching(query);
        }
    }
});

window.history_searching = function(query) {
    // 使用 SCRIPT_URL 变量，这个变量在页面上已经由 PHP 输出过
    window.location.href = `${SCRIPT_URL}search_result?search=${encodeURIComponent(query)}`;
}