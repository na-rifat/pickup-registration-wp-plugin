import { hideMsg, showMsg } from "./msg-modal";

let parent = $(`.sample-registration `);
let form = parent.find(`form`);
let pickup_info = parent.find(`.leftcol`);
let sample_info = parent.find(`.rightcol`);
let sample_form = sample_info.find(`.form-holder`).html();
let btnSubmit = parent.find(`button[type=submit]`);
let specificInfo = parent.find(`#specific-info`).parents(`tr`);
let condY = $(`.condition_y`);
let condN = $(`.condition_n`);
let times = $(`.customer-times .available`);
let requestDate = form.find(`#request-date`);

// specificInfo.slideUp(0);

sample_info.find(`.add-new-sample`).on(`click`, function (e) {
    sample_info.find(`.form-holder`).append(sample_form);

    condY = $(`.condition_y`);
    condN = $(`.condition_n`);

    condY.off();
    condN.off();

    condY.on(`change`, handleCondY);
    condN.on(`change`, handleCondN);
});

form.on(`submit`, function (e) {
    e.preventDefault();
    let self = $(this);
    let data = self.serialize();
    let goAhead = true;

    let timer = $(`#request-time`);
    // console.log(timer.val().length);

    // return;
    if (timer.val().length == 0) {
        showMsg("Please select a time.", `error`);
        hideMsg();
        return;
    }

    $.each($(`.condition_y`), function (i, val) {
        if ($(this).prop(`checked`) == true && goAhead) {
            goAhead = false;
        }
    });

    if (!goAhead) {
        showMsg(`Samples with ~~ cannot be processed`, `error`);
        hideMsg();
        return;
    }

    data += `&nonce=${pr.register_pickup.nonce}&action=register_pickup`;

    $.ajax({
        type: "POST",
        url: pr.ajax_url,
        data,
        dataType: "JSON",
        success: function (res) {
            if (res.success) {
                showMsg(res.data.msg, "success");
                setTimeout(() => {
                    window.location.href = res.data.url;
                }, 3500);
            }
        },
        error: function (res) {
            alert(`There was an error in the server.`);
        },
    });
});

condY.on(`change`, handleCondY);
condN.on(`change`, handleCondN);

function handleCondY(e) {
    $(this).parents(`td`).find(`.condition_n`).prop(`checked`, false);
}

function handleCondN(e) {
    $(this).parents(`td`).find(`.condition_y`).prop(`checked`, false);
}

times.on(`click`, function (e) {
    let self = $(this);
    let timer = $(`#request-time`);

    times.removeClass(`active`);
    timer.val(self.data(`id`));
    self.addClass(`active`);
});

requestDate.on(`change`, function (e) {
    let self = $(this);
    let hoursHolder = form.find(".request-date-holder");

    let data = {
        action: "pr_get_hours",
        nonce: pr.pr_get_hours.nonce,
        date: self.val(),
    };

    $.ajax({
        type: "POST",
        url: pr.ajax_url,
        data,
        dataType: `JSON`,
        success: function (res) {
            if (res.success) {
                hoursHolder.html(res.data.hours);

                times = $(`.customer-times .available`);
                times.on(`click`, function (e) {
                    let self = $(this);
                    let timer = $(`#request-time`);

                    times.removeClass(`active`);
                    timer.val(self.data(`id`));
                    self.addClass(`active`);
                });
            }
        },
    });
});
