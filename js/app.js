// ============================================================================
// Page Load (jQuery)
// ============================================================================

/**
 * 通用交互脚本
 * 
 * ✅ 用法一览：
 * - Autofocus：自动聚焦到第一个输入框或报错字段
 * - data-confirm="确认信息"：点击时弹出确认框，取消则阻止默认行为
 * - data-get="URL"：点击后触发 GET 请求跳转
 * - data-post="URL"：点击后以 POST 方式提交跳转
 * - type="reset"：刷新页面（不是真正 reset 表单）
 * - data-upper：输入自动转为大写
 * - label.upload + input[type=file]：图片选择后自动预览
 */
$(() => {

    // Autofocus
    $('form :input:not(button):first').focus();
    $('.err:first').prev().focus();
    $('.err:first').prev().find(':input:first').focus();
    
    // Confirmation message
    $('[data-confirm]').on('click', e => {
        const text = e.currentTarget.dataset.confirm || 'Are you sure?';
        if (!confirm(text)) {
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });

    // Initiate GET request
    $('[data-get]').on('click', e => {
        e.preventDefault();
        const url = e.currentTarget.dataset.get;
        location = url || location;
    });

    // Initiate POST request
    $('[data-post]').on('click', e => {
        e.preventDefault();
        const url = e.currentTarget.dataset.post;
        const f = $('<form>').appendTo(document.body)[0];
        f.method = 'POST';
        f.action = url || location;
        f.submit();
    });

    // Reset form
    $('[type=reset]').on('click', e => {
        e.preventDefault();
        location = location;
    });

    // Auto uppercase
    $('[data-upper]').on('input', e => {
        const a = e.currentTarget.selectionStart;
        const b = e.currentTarget.selectionEnd;
        e.currentTarget.value = e.currentTarget.value.toUpperCase();
        e.currentTarget.setSelectionRange(a, b);
    });

    // Photo preview
    $('label.upload input[type=file]').on('change', e => {
        const f = e.currentTarget.files[0];
        const img = $(e.currentTarget).siblings('img')[0];

        if (!img) return;

        img.dataset.src ??= img.src;

        if (f?.type.startsWith('image/')) {
            img.src = URL.createObjectURL(f);
        }
        else {
            img.src = img.dataset.src;
            e.currentTarget.value = '';
        }
    });

});