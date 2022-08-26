import { showMsg, hideMsg } from "./msg-modal";

const parent = $(`.admin-reports`);
const modal = $(`.report-modal`);
const inner = modal.find(`.inner-content`);
const modalClsBtn = modal.find(`.cls-btn`);
const btnUpdate = modal.find(`.update-report`);
let modalForm = $(`#report-form`);
let dltFileBtn = $(`.dlt-file`);
const btnShowInfo = parent.find(`.btn-show-detail`);

btnShowInfo.on(`click`, function (e) {
    e.preventDefault();

    let self = $(this);
    let selfParent = self.parents(`tr`);
    let id = selfParent.data(`id`);

    let data = {
        id,
        nonce: pr.view_detail_admin.nonce,
        action: `view_detail_admin`,
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
                
                dltFileBtn = $(`.dlt-file`)
                dltFileBtn.on(`click`, handleDeleteFile);

                modalForm = $(`#report-form`);
                modalForm.on(`submit`, function (e) {
                    e.preventDefault();

                    // let data = $(this).serialize();
                    // data += `&nonce=${pr.update_report.nonce}&action=update_report`;
                    let data = new FormData($(this)[0]);
                    data.append("nonce", pr.update_report.nonce);
                    data.append("action", "update_report");

                    $.ajax({
                        type: "POST",
                        url: pr.ajax_url,
                        data,
                        // dataType: "JSON",
                        processData: false,
                        contentType: false,
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

function handleDeleteFile(e) {
    e.preventDefault();
    let self = $(this);
    let data = {
        id: self.data(`id`),
        file: self.data(`file`),
        nonce: pr.dlt_sample_file.nonce,
        action: `dlt_sample_file`,
    };
    if (confirm("Are you sure to delete sample file?")) {
        $.ajax({
            type: "POST",
            url: pr.ajax_url,
            data,
            dataType: "JSON",
            success: function (res) {
                if (res.data.success) {
                    self.parents(`p`)
                        .css({ backgroundColor: red })
                        .hide(600)
                        .remove();
                }
            },
        });
    }
}
