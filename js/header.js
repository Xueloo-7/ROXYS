$(() => {

    // 滚动时隐藏 .top-nav
    $(window).on('scroll', () => {
        $('.top-nav').toggleClass('hidden', $(window).scrollTop() !== 0);
    });

    // 点击 .nav-item[data-link] 跳转
    $('.nav-item[data-link]').on('click', function () {
        const link = $(this).data('link');
        if (link) window.location.href = link;
    });

    // 侧边栏菜单逻辑
    $('.menu-toggle').on('click', () => {
        $('.sideMenu').addClass('open');
        $('.overlay').addClass('show');
    });

    $('.closeMenu, .overlay').on('click', () => {
        $('.sideMenu').removeClass('open');
        $('.overlay').removeClass('show');
    });

    // Header dynamic layout
    const header = $('header');
    if (header.length) {
        $('body').css('padding-top', (header.outerHeight() / 2) + 'px');
    }
});