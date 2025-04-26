initializeSearchHistory({
    inputId: "shoppingSearchInput",
    historyId: "shoppingSearchHistory",
    localStorageKey: "searchHistory_shopping",
    filterButtonClass: "filter-button.purchase-history",
    onSelect: function (query) {
        console.log("Searching in purchase history:", query);
        if (typeof window.purchase_history_searching === "function") {
            window.purchase_history_searching(query);
        }
    }
});