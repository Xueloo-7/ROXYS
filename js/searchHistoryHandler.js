/**
 * 通用搜索历史初始化函数
 * 适用于不同的搜索输入框，减少重复代码
 * 
 * @param {Object} config 配置对象
 * @param {string} config.inputId 搜索框的 ID
 * @param {string} config.historyId 搜索历史下拉框的 ID
 * @param {string} config.localStorageKey 用于存储历史记录的 localStorage 键名
 * @param {string} config.filterButtonClass 触发筛选框的按钮类名
 */
function initializeSearchHistory({
    inputId,
    historyId,
    localStorageKey,
    filterButtonClass,
    onSelect
}) {
    $(function () {
        const $searchInput = $('#' + inputId);
        const $searchHistory = $('#' + historyId);

        if ($searchInput.length === 0 || $searchHistory.length === 0) {
            console.warn(`Missing search input or history dropdown for ${inputId}`);
            return;
        }

        let history = JSON.parse(localStorage.getItem(localStorageKey)) || [];
        let selectedIndex = -1;

        function showSearchHistory() {
            $searchHistory.empty();

            if (history.length === 0) {
                $searchHistory.hide();
                return;
            }

            history.forEach((item, index) => {
                const $div = $('<div>').addClass('search-history-item');
                if (index === selectedIndex) {
                    $div.addClass('selected');
                }

                const $icon = $('<i>').addClass('fas fa-history');
                const $text = $('<span>').text(item);
                const $deleteIcon = $('<i>').addClass('fas fa-times delete-icon').css('opacity', 0);

                $deleteIcon.on('click', function (e) {
                    e.stopImmediatePropagation();
                    history.splice(index, 1);
                    localStorage.setItem(localStorageKey, JSON.stringify(history));
                    selectedIndex = -1;
                    showSearchHistory();
                });

                $div.on('mouseenter', () => $deleteIcon.css('opacity', 1));
                $div.on('mouseleave', () => $deleteIcon.css('opacity', 0));

                $div.on('click', () => {
                    $searchInput.val(item);
                    $searchHistory.hide();
                    selectedIndex = -1;
                    if (typeof onSelect === "function") onSelect(item);
                });

                $div.append($icon, $text, $deleteIcon);
                $searchHistory.append($div);
            });

            $searchHistory.show();
        }

        $searchInput.on('focus', function () {
            selectedIndex = -1;
            showSearchHistory();
        });

        $searchInput.on('keydown', function (e) {
            const value = $searchInput.val().trim();

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                selectedIndex = selectedIndex < history.length - 1 ? selectedIndex + 1 : 0;
                showSearchHistory();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                selectedIndex = selectedIndex > 0 ? selectedIndex - 1 : -1;
                showSearchHistory();
            } else if (e.key === 'Enter') {
                if (selectedIndex >= 0 && selectedIndex < history.length) {
                    $searchInput.val(history[selectedIndex]);
                    $searchHistory.hide();
                    if (typeof onSelect === "function") onSelect(history[selectedIndex]);
                } else {
                    if (value !== '') {
                        if (!history.includes(value)) {
                            history.unshift(value);
                            if (history.length > 10) history.pop();
                            localStorage.setItem(localStorageKey, JSON.stringify(history));
                        }
                    }
                    if (typeof onSelect === "function") onSelect(value);
                }
                selectedIndex = -1;
            } else if (e.key === 'Backspace') {
                if (value.length <= 1) showSearchHistory();
            }

            if (value !== '') $searchHistory.hide();
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest($searchInput).length && !$(e.target).closest($searchHistory).length) {
                $searchHistory.hide();
            }
        });

        const $filterButtons = $('.' + filterButtonClass);

        $filterButtons.each(function () {
            const $button = $(this);

            $button.on('click', function (e) {
                e.stopPropagation();
                const $filterBox = $button.find('.filter-box');

                if ($filterBox.length === 0) return;

                $('.filter-box').not($filterBox).hide();
                $filterBox.css('display', $filterBox.css('display') === 'flex' ? 'none' : 'flex');
            });
        });

        $(document).on('click', function () {
            $('.filter-box').hide();
        });

        $('.filter-box').on('click', function (e) {
            e.stopPropagation();
        });
    });
}
