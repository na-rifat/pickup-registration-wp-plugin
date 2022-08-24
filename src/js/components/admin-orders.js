import { showMsg } from "./msg-modal";

const parent = $(`.admin-orders`);
const newOrdersTable = parent.find(`table`).eq(0);
const manageOrdersTable = parent.find(`table`).eq(1);
const orderApprovalSelection = newOrdersTable.find(`.approve-order-selection`);
const bulkApprovalBtn = parent.find(`.approve-orders-btn`);
const reviewList = $(`.review-list`);
const modalParent = $(`.sample-modal`);
const btnModalClose = $(`.btn-close`);
const btnModalCancel = $(`.btn-cancel`);
const btnModalConfirm = $(`.btn-confirm`);
const approvalForm = $(`.approval-form`);
const btnOpen = $(`.open-order`);
const animDur = 600;
const dltBtn = parent.find(`.delete-orders-btn`);

const sortingForm = parent.find(`#sorting`);

bulkApprovalBtn.on(`click`, function (e) {
    e.preventDefault();

    parent.slideUp(animDur);
    modalParent.slideDown(animDur);

    reviewList.find(`li`).removeClass(`in-list`);

    $.each(orderApprovalSelection, function (i, val) {
        let rowParent = $(this).parents(`tr`);
        let id = rowParent.data(`id`);

        if ($(this).prop("checked") == false) return;

        reviewList.find(`li[data-id="${id}"]`).addClass(`in-list`);
    });

    btnModalConfirm.show();
});

btnOpen.on(`click`, function (e) {
    e.preventDefault();

    parent.slideUp(animDur);
    modalParent.slideDown(animDur);

    reviewList.find(`li`).removeClass(`in-list`);

    let rowParent = $(this).parents(`tr`);
    let id = rowParent.data(`id`);

    // console.log(id);
    // console.log(reviewList.find(`li[data-id="${id}"]`).length);
    reviewList.find(`li[data-id="${id}"]`).addClass(`in-list`);
    btnModalConfirm.hide();
});
btnModalClose.on(`click`, function (e) {
    e.preventDefault();

    parent.slideDown(animDur);
    modalParent.slideUp(animDur);
});

btnModalCancel.on(`click`, function (e) {
    if (confirm("Are you sure to delete the selected orders?")) {
        let selectedRows = reviewList.find(`.in-list`);
        let data = new FormData();

        data.append("action", "pr_delete");
        data.append("nonce", pr.pr_delete.nonce);

        $.each(selectedRows, function (i, val) {
            let file_el = $(this).find(`input[type="file"]`);

            data.append("orders[]", $(this).data(`id`));
            data.append(file_el.attr(`name`), file_el[0].files[0]);
        });

        $.ajax({
            type: "POST",
            url: pr.ajax_url,
            data,
            // dataType: "dataType",
            contentType: false,
            processData: false,
            success: function (res) {
                // console.log(res);
                showMsg(data.res.msg, "success");

                setTimeout(() => {
                    window.location.reload();
                }, 3500);
            },
        });
    }
});

btnModalConfirm.on(`click`, function (e) {
    e.preventDefault();

    let selectedRows = reviewList.find(`.in-list`);
    let data = new FormData();

    data.append("action", "pr_approval");
    data.append("nonce", pr.pr_approval.nonce);

    $.each(selectedRows, function (i, val) {
        let file_el = $(this).find(`input[type="file"]`);

        data.append("orders[]", $(this).data(`id`));
        data.append(file_el.attr(`name`), file_el[0].files[0]);
    });

    $.ajax({
        type: "POST",
        url: pr.ajax_url,
        data,
        // dataType: "dataType",
        contentType: false,
        processData: false,
        success: function (res) {
            // console.log(res);
            window.location.reload();
        },
    });
});

sortingForm.on(`change`, function (e) {
    e.preventDefault();

    $(this).parents(`form`).submit();
});

dltBtn.on(`click`, function (e) {
    if (confirm("Are you sure to delete the selected orders?")) {
        let selectedRows = reviewList.find(`.in-list`);
        let data = new FormData();

        data.append("action", "pr_delete");
        data.append("nonce", pr.pr_delete.nonce);

        $.each(selectedRows, function (i, val) {
            let file_el = $(this).find(`input[type="file"]`);

            data.append("orders[]", $(this).data(`id`));
            data.append(file_el.attr(`name`), file_el[0].files[0]);
        });

        $.ajax({
            type: "POST",
            url: pr.ajax_url,
            data,
            // dataType: "dataType",
            contentType: false,
            processData: false,
            success: function (res) {
                // console.log(res);
                showMsg(data.res.msg, "success");

                setTimeout(() => {
                    window.location.reload();
                }, 3500);
            },
        });
    }
});
