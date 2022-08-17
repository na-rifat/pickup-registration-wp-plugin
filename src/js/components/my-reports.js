const parent = $(`.customer-report`);
const showBtn = parent.find(`.btn-show-detail`);
const modal = $(`.report-modal`);
const inner = modal.find(`.inner-content`);
const modalClsBtn = modal.find(`.cls-btn`);

showBtn.on(`click`, function (e) {
    e.preventDefault();

    let self = $(this);
    let selfParent = self.parents(`tr`);
    let id = selfParent.data(`id`);

    let data = {
        id,
        nonce: pr.view_detail.nonce,
        action: `view_detail`,
    };

    $.ajax({
        type: "POST",
        url: pr.ajax_url,
        data,
        dataType: "JSON",
        success: function (res) {
            console.log(res);
            if (res.success) {
                inner.html(res.data.detail);
                modal.show();
            }
        },
    });
});

modalClsBtn.on(`click`, function (e) {
    modal.hide();
});
