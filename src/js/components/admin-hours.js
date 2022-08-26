import { showMsg, hideMsg } from "./msg-modal";

const parent = $(`.pr-hours`);
const newHour = parent.find(`.new-hour`);
const newHourForm = newHour.find(`form`);
const hoursList = parent.find(`.hours table`);
const dltBtn = $(`.dlt-hour`);
const btnAvailibility = $(`.time-availibity`);

newHourForm.on(`submit`, function (e) {
    e.preventDefault();

    let self = $(this);
    let data = self.serialize();
    data += `&nonce=${pr.pr_insert_hour.nonce}&action=pr_insert_hour`;

    $.ajax({
        type: "POST",
        url: pr.ajax_url,
        data,
        dataType: "JSON",
        success: function (res) {
            if (res.success) {
                showMsg(res.data.msg, `success`);

                setTimeout(() => {
                    window.location.reload();
                }, 3500);
            }
        },
    });
});
dltBtn.on(`click`, function (e) {
    if (confirm(`Are you sure to delete this hour?`)) {
        let self = $(this);
        let parent = self.parents(`tr`);
        let data = {
            nonce: pr.pr_delete_hour.nonce,
            action: `pr_delete_hour`,
            id: parent.data(`id`),
        };

        $.ajax({
            type: "POST",
            url: pr.ajax_url,
            data,
            dataType: "JSON",
            success: function (res) {
                if (res.success) {
                    parent
                        .css({ backgroundColor: `red` })
                        .hide(600, function (e) {
                            parent.remove();
                        });
                }
            },
        });
    }
});

btnAvailibility.on(`change`, function (e) {
    let self = $(this);
    let parent = self.parents(`tr`);
    let data = {
        nonce: pr.pr_available_hour.nonce,
        action: `pr_available_hour`,
        id: parent.data(`id`),
        available: self.prop(`checked`),
    };

    $.ajax({
        type: "POST",
        url: pr.ajax_url,
        data,
        dataType: "JSON",
        success: function (res) {
            if (res.success) {
                console.log(res.data);
            }
        },
    });
});
