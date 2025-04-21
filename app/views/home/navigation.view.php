<nav>
    <div class="First-Box-Container zoom">
        <div class="shell">
            <ul class="images">
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
                <li class="img"></li>
            </ul>
            <ul class="min">
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
                <li class="m"></li>
            </ul>
            <div class="button">
                <div class="button-left"><i class="fas fa-chevron-left"></i></div>
                <div class="button-right"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>

        <script>
            let left = document.querySelector(".button-left")
            let right = document.querySelector(".button-right")
            let m = document.querySelectorAll(".m")
            let images = document.querySelector(".images")

            let index = 0
            let time
            function position(){
                images.style.left = (index * -100) + "%";
            }

            function add(){
                if(index >= m.length - 1){
                    index = 0
                }
                else{
                    index++
                }
            }
            function desc(){
                if(index < 1){
                    index = m.length - 1
                }
                else{
                    index--
                }
            }
            function m_select(){
                for (let i = 0; i < m.length; i++) {
                    m[i].classList.remove("selected")
                    if (i === index) {
                        m[i].classList.add("selected")
                    }
                }
            }

            function timer(){
                time = setInterval(() => {
                    index++
                    desc()
                    add()
                    position()
                    m_select()
                }, 3000)
            }

            left.addEventListener("click", () => {
                desc()
                position()
                m_select()
                clearInterval(time)
                timer()
            })

            right.addEventListener("click", () => {
                add()
                position()
                m_select()
                clearInterval(time)
                timer()
            })

            for (let i = 0; i < m.length; i++) {
                m[i].addEventListener("click", () => {
                    index = i
                    position()
                    m_select()
                    clearInterval(time)
                    timer()
                })
            }


            timer()
            position()
            m_select()
        </script>

        <?php
        $category = [
            "Shoe" => "category1.jpg",
            "Socks" => "category2.jpg",
            "Pants" => "category3.jpg",
            "Cap" => "category4.jpg",
            "Clothes" => "category5.jpg",
            "UnderClothes" => "category6.jpg",
            "Bag" => "category7.jpg",
            "Dress" => "category8.jpg"
        ];
        ?>

        <div class="category-container">
            <p>Category</p>
            <div class="category">
                <?php foreach ($category as $cat => $img_url): ?>
                    <a href="<?= SCRIPT_URL ?>search_result?search=<?= strtolower(urlencode($cat)) ?>" class="category-box">
                        <img src="<?= BASE_URL ?>image/category/<?= $img_url ?>" alt="<?= htmlspecialchars($cat) ?>">
                        <p><?= htmlspecialchars($cat) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</nav>
