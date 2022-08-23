import { showMsg } from "./msg-modal";
let parent = $(`.sample-registration `);
let form = parent.find(`form`);
let pickup_info = parent.find(`.leftcol`);
let sample_info = parent.find(`.rightcol`);
let sample_form = sample_info.find(`.form-holder`).html();
let btnSubmit = parent.find(`button[type=submit]`);
let specificInfo = parent.find(`#specific-info`).parents(`tr`);
let condY = $(`.condition_y`);
let condN = $(`.condition_n`);

// specificInfo.slideUp(0);

sample_info.find(`.add-new-sample`).on(`click`, function (e) {
    sample_info.find(`.form-holder`).append(sample_form);

    condY = $(`.condition_y`);
    condN = $(`.condition_n`);

    condY.off();
    condN.off();

    condY.on(`change`, handleCondY);
    condN.on(`change`, handleCondN);

    // let tableOrigin = parent.find(`.rightcol table`);
    // let lastTable = tableOrigin.eq(tableOrigin.length - 1);

    // lastTable.find(`.specific-info`).hide(0);

    // $.each(tableOrigin, function (i, val) {
    //     $(this).find();
    // });
});

form.on(`submit`, function (e) {
    e.preventDefault();
    let self = $(this);
    let data = self.serialize();

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

    // let self = $(this);
    // let self_parent = self.parents(`table`);
    // let selfSpecific = self_parent.find(`.specific-info`);

    // if (self.prop(`checked`)) {
    //     selfSpecific.show(500);
    // }
}

function handleCondN(e) {
    $(this).parents(`td`).find(`.condition_y`).prop(`checked`, false);

    // let self = $(this);
    // let self_parent = self.parents(`table`);
    // let selfSpecific = self_parent.find(`.specific-info`);

    // if (self.prop(`checked`)) {
    //     selfSpecific.hide(500);
    // }
}
