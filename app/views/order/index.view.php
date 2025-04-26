<!-- ============================================================================
Order Page
============================================================================  -->

<?php
require_once __DIR__.'/../partials/header.php';
link_css("order");
?>

<main class="purchase-container zoom">
    <div class="top-box">
        <h1>My Orders</h1>
        <!-- 搜索栏 -->
        <div class="search-container tooltip" data-tooltip="Search product by name">
            <i class="fas fa-search"></i>
            <label class="search-bar">
                <input type="text" id="shoppingSearchInput" placeholder="Search" autocomplete="off" autocorrect="off" spellcheck="false">
            </label>
            <div class="search-history" id="shoppingSearchHistory"></div>
        </div>
        <!-- 搜索栏js -->
        <?php link_js("searchHistoryHandler") ?>
        <?php link_js("ph_search_history") ?>
    </div>
    
    <!-- 导航栏 -->
    <nav class="order-tabs">
        <a href="#" class="active" data-status="all">All</a>
        <a href="#" data-status="to_pay">To Pay</a>
        <a href="#" data-status="to_ship">To Ship</a>
        <a href="#" data-status="to_receive">To Receive</a>
        <a href="#" data-status="to_review">To Review</a>
    </nav>

    <!-- 加载icon -->
    <div id="loading-icon" class="loading-container">
        <i class="fa fa-spinner fa-spin"></i> Loading...
    </div>

    <!-- 订单列表 -->
    <div id="order-list">
        <!-- 订单数据会被 JS 动态填充 -->
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        indicator_effect_initial();

        fetch_and_fill_purchase_history();

        

        // tab点击后下划线动画效果
        function indicator_effect_initial(){
            const tabs = document.querySelectorAll(".order-tabs a");
            const indicator = document.createElement("div");
            indicator.classList.add("indicator");
            document.querySelector(".order-tabs").appendChild(indicator);

            function moveIndicator(tab) {
                indicator.style.width = tab.offsetWidth + 'px';
                indicator.style.transform = 'translateX(' + tab.offsetLeft + 'px)';
            }

            // 点击后，激活当前tab，并将下划线移动过去
            tabs.forEach(tab => {
                tab.addEventListener("click", function (event) {
                    event.preventDefault();

                    // 移除所有的 active 状态
                    tabs.forEach(t => t.classList.remove("active"));

                    // 给当前 tab 添加 active
                    this.classList.add("active");

                    // 移动下划线
                    moveIndicator(this);
                });
            });

            // 初始化下划线位置
            const activeTab = document.querySelector(".order-tabs a.active");
            if (activeTab) moveIndicator(activeTab);
        }



        function fetch_and_fill_purchase_history(){
            
            // 0.5秒后才显示 loading
            const loadingIcon = document.getElementById("loading-icon");
            let loadingTimeout = setTimeout(() => {
                loadingIcon.style.display = "block";
            }, 500);

            const tabs = document.querySelectorAll(".order-tabs a");
            const orderList = document.getElementById("order-list");
           
            // 给tab添加 点击后更新状态的功能
            initial_tabs();

            // 初始化 More-information 按钮
            initialButton();

            // 初始化购物历史的搜索栏
            search_bar_initial();

            // 初始加载 "All" 购物历史
            fetchOrders("all");

            

            function initial_tabs(){
                tabs.forEach(tab => {
                    tab.addEventListener("click", function (event) {
                        event.preventDefault();

                        // 移除所有active，仅为自己添加active
                        tabs.forEach(t => t.classList.remove("active"));
                        this.classList.add("active");

                        // 获取状态
                        const status = this.getAttribute("data-status");
                        
                        // 获取搜索框输入的文字
                        const searchQuery = document.getElementById("shoppingSearchInput").value.trim();

                        // 调用 fetchOrders 进行搜索
                        fetchOrders(status, searchQuery);
                    });
                });
            }



            function initialButton(){

                // orderList被点击时
                orderList.addEventListener('click', function(e) {
                    
                    // 确定点击的是 more-information 按钮
                    const button = e.target.closest('.more-information');
                    if (!button) return;

                    e.preventDefault();

                    // 1. 找到该 button 对应的 orderCard
                    const orderCard = button.closest('.order-card');
                    const orderInfo = orderCard.querySelector('.order-info');
                    const pTag = button.querySelector('p');
                    const icon = button.querySelector('i');

                    // 2. 切换显示状态
                    orderInfo.classList.toggle('hidden');

                    // 3. 更新按钮文本和图标
                    if (orderInfo.classList.contains('hidden')) {
                        pTag.textContent = 'Hide information';
                        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                    } else {
                        pTag.textContent = 'More information';
                        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                });
            }



            function search_bar_initial(){

                // 搜索栏 Enter 时
                // document.getElementById("shoppingSearchInput").addEventListener("keydown", function(event) {
                //     if (event.key === "Enter") {
                //         // 进行搜索
                //         purchase_history_searching(this.value.trim());
                //     }
                // });

                // 搜索栏填充时 or Enter 时都会调用这个方法（通过 window 公开给 ph_search_history.js）
                window.purchase_history_searching = function($query){
                    // 搜索当前激活 tab + query
                    fetchOrders(getActiveStatus(), $query);
                }

                // 获取当前激活 tab 的状态
                function getActiveStatus() {
                    for (const tab of tabs) {
                        if (tab.classList.contains("active")) {
                            return tab.getAttribute("data-status");
                        }
                    }
                    return "all"; 
                }
            }
            

            
            function fetchOrders(status, search = '') {

                const url = `<?= API_URL ?>/fetch_orders.php?status=${status}&search=${encodeURIComponent(search)}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err; });
                        }
                        return response.text();
                    })
                    .then(html => {
                        orderList.innerHTML = html;
                        
                        clearTimeout(loadingTimeout); // 数据加载完成，取消显示 loading
                        loadingIcon.style.display = "none";
                    })
                    .catch(error => {
                        loadingIcon.style.display = "none";

                        if (error.error === 'database') {
                            window.location.href = '/';
                        } else {
                            console.error("Error fetching orders:", error);
                        }
                    });
            }
        }
    });

</script>

<?php require_once __DIR__.'/../partials/footer.php'; ?>
