const parent = $(`.msg-modal`);
const inner = parent.find(`.inner`);
const dur = 500;
// $(document).on(`click`, function (e) {
//     parent.hide(600);
// });

export function showMsg(content, type) {
    parent.removeClass(`success error`).addClass(type);
    parent.show(dur);
    inner.html(content);
}

export function hideMsg() {
    setTimeout(() => {
        parent.hide(dur);
    }, 3000);
}
