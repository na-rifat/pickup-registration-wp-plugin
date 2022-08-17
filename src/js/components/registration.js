let parent = $(`.sample-registration `);
let form = parent.find(`form`);
let pickup_info = parent.find(`.leftcol`);
let sample_info = parent.find(`.rightcol`);
let sample_form = sample_info.find(`.form-holder`).html();
let btnSubmit = parent.find(`button[type=submit]`);

sample_info.find(`.add-new-sample`).on(`click`, function (e) {
    sample_info.find(`.form-holder`).append(sample_form);
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
                window.location.href = res.data.url;
            }
        },
        error: function (res) {
            alert(`There was an error in the server.`);
        },
    });
});
