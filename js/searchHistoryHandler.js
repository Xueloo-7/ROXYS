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
    onSelect /* 搜索回调 */
}) {
    document.addEventListener("DOMContentLoaded", function () {
        // 获取搜索框和历史记录下拉框
        const searchInput = document.getElementById(inputId);
        const searchHistory = document.getElementById(historyId);

        if (!searchInput || !searchHistory) {
            console.warn(`Missing search input or history dropdown for ${inputId}`);
            return;
        }

        // 读取 localStorage 中存储的搜索历史
        let history = JSON.parse(localStorage.getItem(localStorageKey)) || [];
        let selectedIndex = -1; // 追踪当前选中的历史记录索引

        /**
         * 显示搜索历史
         */
        function showSearchHistory() {
            searchHistory.innerHTML = "";
            if (history.length === 0) {
                searchHistory.style.display = "none";
                return;
            }

            history.forEach((item, index) => {
                const div = document.createElement("div");
                div.classList.add("search-history-item");
                if (index === selectedIndex) {
                    div.classList.add("selected"); // 高亮选中项
                }

                // 历史记录的图标
                const icon = document.createElement("i");
                icon.classList.add("fas", "fa-history");

                // 记录文本
                const text = document.createElement("span");
                text.textContent = item;

                // 删除按钮
                const deleteIcon = document.createElement("i");
                deleteIcon.classList.add("fas", "fa-times", "delete-icon");

                // 绑定删除事件
                deleteIcon.addEventListener("click", (event) => {
                    event.stopImmediatePropagation(); // 防止点击事件冒泡到 div
                    history.splice(index, 1);
                    localStorage.setItem(localStorageKey, JSON.stringify(history));
                    selectedIndex = -1;
                    showSearchHistory();
                });

                // 鼠标悬停时显示删除按钮
                div.addEventListener("mouseenter", () => {
                    deleteIcon.style.opacity = 1;
                });
                div.addEventListener("mouseleave", () => {
                    deleteIcon.style.opacity = 0;
                });

                // 点击历史记录填充到搜索框
                div.addEventListener("click", () => {
                    searchInput.value = item;
                    searchHistory.style.display = "none";
                    selectedIndex = -1;

                    if (typeof onSelect === "function") {
                        onSelect(item); // 触发自定义的搜索行为
                    }
                });

                div.appendChild(icon);
                div.appendChild(text);
                div.appendChild(deleteIcon);
                searchHistory.appendChild(div);
            });

            searchHistory.style.display = "block";
        }

        /**
         * 监听搜索框的交互事件
         */
        searchInput.addEventListener("focus", () => {
            selectedIndex = -1; // 重新聚焦时重置索引
            showSearchHistory();
        });

        searchInput.addEventListener("keydown", function (event) {
            if (event.key === "ArrowDown") {
                // 按下箭头下移动选中项
                event.preventDefault();
                selectedIndex = selectedIndex < history.length - 1 ? selectedIndex + 1 : 0;
                showSearchHistory();
            } else if (event.key === "ArrowUp") {
                // 按下箭头上移动选中项
                event.preventDefault();
                selectedIndex = selectedIndex > 0 ? selectedIndex - 1 : -1;
                showSearchHistory();
            } else if (event.key === "Enter") {
                // 回车键选择搜索历史
                if (selectedIndex >= 0 && selectedIndex < history.length) {
                    searchInput.value = history[selectedIndex];
                    searchHistory.style.display = "none";

                    if (typeof onSelect === "function") {
                        onSelect(history[selectedIndex]); // 触发自定义的搜索行为
                    }
                } else {
                    const value = searchInput.value.trim(); // 确保 value 在整个 else 代码块都可用
                    if (value !== "") {
                        // 新增搜索记录
                        if (!history.includes(value)) {
                            history.unshift(value);
                            if (history.length > 10) history.pop();
                            localStorage.setItem(localStorageKey, JSON.stringify(history));
                        }
                    }
                    if (typeof onSelect === "function") {
                        onSelect(value); // **按回车触发自定义行为**
                    }
                    selectedIndex = -1;
                }                
            }  else if (event.key === "Backspace") {
                // 退格键时显示历史记录
                if (searchInput.value.length <= 1) {
                    showSearchHistory();
                }
                return;
            }

            // 只在输入内容时隐藏搜索历史
            if (searchInput.value.trim() !== "") {
                searchHistory.style.display = "none";
            }
        });

        /**
         * 监听点击事件，点击其他地方时隐藏搜索历史
         */
        document.addEventListener("click", function (event) {
            if (!searchInput.contains(event.target) && !searchHistory.contains(event.target)) {
                searchHistory.style.display = "none";
            }
        });

        /**
         * 处理筛选按钮逻辑
         */
        const filterButtons = document.querySelectorAll(`.${filterButtonClass}`);

        filterButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.stopPropagation();

                const filterBox = button.querySelector('.filter-box');
                if (!filterBox) return;

                // 关闭其他筛选框
                document.querySelectorAll('.filter-box').forEach(box => {
                    if (box !== filterBox) box.style.display = 'none';
                });

                // 切换当前筛选框的显示状态
                filterBox.style.display = (filterBox.style.display === 'flex') ? 'none' : 'flex';
            });
        });

        // 点击页面其他地方时关闭所有筛选框
        document.addEventListener('click', () => {
            document.querySelectorAll('.filter-box').forEach(box => {
                box.style.display = 'none';
            });
        });

        // 阻止点击筛选框内部时关闭
        document.querySelectorAll('.filter-box').forEach(filterBox => {
            filterBox.addEventListener('click', (event) => {
                event.stopPropagation();
            });
        });
    });
}