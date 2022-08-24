import { hideMsg, showMsg } from "./msg-modal";
const parent = $(`.customer-report`);
const showBtn = parent.find(`.btn-show-detail`);
const modal = $(`.report-modal`);
const inner = modal.find(`.inner-content`);
const modalClsBtn = modal.find(`.cls-btn`);
const btnUpdate = modal.find(`.update-report`);
let modalForm = $(`#report-form`);

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

                modalForm = $(`#report-form`);
                modalForm.on(`submit`, function (e) {
                    e.preventDefault();


                    let data = $(this).serialize();
                    data += `&nonce=${pr.update_report.nonce}&action=update_report`;

                    $.ajax({
                        type: "POST",
                        url: pr.ajax_url,
                        data,
                        dataType: "JSON",
                        success: function (res) {
                            console.log(res);
                            modal.hide();
                            showMsg("Report updated.", "success");
                            hideMsg();
                        },
                    });
                });
            }
        },
    });
});

modalClsBtn.on(`click`, function (e) {
    modal.hide();
});
