const parent = $(`.admin-orders`);
const newOrdersTable = parent.find(`table`).eq(0);
const manageOrdersTable = parent.find(`table`).eq(1);
const orderApprovalSelection = newOrdersTable.find(`.approve-order-selection`);
const bulkApprovalBtn = parent.find(`.approve-orders-btn`);
const reviewList = $(`.review-list`);
const modalParent = $(`.sample-modal`);
const btnModalCancel = $(`.btn-cancel`);
const btnModalConfirm = $(`.btn-confirm`);
const approvalForm = $(`.approval-form`);
const btnOpen = $(`.open-order`);
const animDur = 600;

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
});

btnOpen.on(`click`, function (e) {
    e.preventDefault();

    parent.slideUp(animDur);
    modalParent.slideDown(animDur);

    reviewList.find(`li`).removeClass(`in-list`);

    let rowParent = $(this).parents(`tr`);
    let id = rowParent.data(`id`);

    console.log(id);
    // console.log(reviewList.find(`li[data-id="${id}"]`).length);
    reviewList.find(`li[data-id="${id}"]`).addClass(`in-list`);
});
btnModalCancel.on(`click`, function (e) {
    e.preventDefault();

    parent.slideDown(animDur);
    modalParent.slideUp(animDur);
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
            window.location.reload();
        },
    });
});
